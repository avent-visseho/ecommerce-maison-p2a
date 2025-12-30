<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\RentalItem;
use App\Models\RentalReservation;
use App\Services\CartService;
use App\Services\FedaPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected $cartService;
    protected $fedaPayService;

    public function __construct(CartService $cartService, FedaPayService $fedaPayService)
    {
        $this->cartService = $cartService;
        $this->fedaPayService = $fedaPayService;
    }

    public function index()
    {
        if ($this->cartService->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $cart = $this->cartService->getCart();
        $totals = $this->cartService->getTotalWithDeposits();
        $subtotal = $totals['subtotal'];
        $deposits = $totals['deposits'];
        $shipping = 0; // Fixed shipping cost
        $total = $totals['total'] + $shipping;

        return view('public.checkout.index', compact('cart', 'subtotal', 'deposits', 'shipping', 'total'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email',
            'shipping_phone' => 'required|string',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_postal_code' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if ($this->cartService->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        try {
            DB::beginTransaction();

            $cart = $this->cartService->getCart();
            $totals = $this->cartService->getTotalWithDeposits();
            $shipping = 0;
            $total = $totals['total'] + $shipping;

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'subtotal' => $totals['subtotal'],
                'shipping' => $shipping,
                'total' => $total,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => 'fedapay',
                'shipping_name' => $validated['shipping_name'],
                'shipping_email' => $validated['shipping_email'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_postal_code' => $validated['shipping_postal_code'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            // Create order items
            foreach ($cart as $cartKey => $item) {
                // Check if this is a rental item
                if (isset($item['type']) && $item['type'] === 'rental') {
                    // Handle rental item
                    $rentalItem = RentalItem::find($item['rental_item_id']);

                    if (!$rentalItem) {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Objet de location non trouvé : ' . $item['name']);
                    }

                    // Verify availability one last time
                    $startDate = \Carbon\Carbon::parse($item['start_date']);
                    $endDate = \Carbon\Carbon::parse($item['end_date']);

                    if (!$rentalItem->isAvailable($startDate, $endDate, $item['quantity'])) {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Objet non disponible pour les dates sélectionnées : ' . $item['name']);
                    }

                    // Create OrderItem for rental
                    $orderItem = OrderItem::create([
                        'order_id' => $order->id,
                        'rental_item_id' => $rentalItem->id,
                        'item_type' => 'rental',
                        'product_name' => $rentalItem->name,
                        'product_sku' => $rentalItem->sku,
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['price'] * $item['quantity'],
                        'rental_start_date' => $item['start_date'],
                        'rental_end_date' => $item['end_date'],
                        'rental_duration_days' => $item['duration_days'],
                        'rental_deposit' => $item['deposit'] * $item['quantity'],
                    ]);

                    // Create RentalReservation with status 'pending'
                    RentalReservation::create([
                        'reservation_number' => 'RES-' . strtoupper(Str::random(10)),
                        'rental_item_id' => $rentalItem->id,
                        'order_id' => $order->id,
                        'order_item_id' => $orderItem->id,
                        'start_date' => $item['start_date'],
                        'end_date' => $item['end_date'],
                        'duration_days' => $item['duration_days'],
                        'quantity_reserved' => $item['quantity'],
                        'rate_type' => $item['rate_type'],
                        'rate_applied' => $item['rate'],
                        'subtotal' => $item['price'] * $item['quantity'],
                        'deposit' => $item['deposit'] * $item['quantity'],
                        'status' => 'pending',
                    ]);
                } else {
                    // Handle regular product
                    $product = Product::find($item['product_id']);
                    $variant = isset($item['variant_id']) ? ProductVariant::find($item['variant_id']) : null;

                    if (!$product) {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Produit non trouvé : ' . $item['name']);
                    }

                    // Vérifier le stock (variante ou produit)
                    $availableStock = $variant ? $variant->stock : $product->stock;
                    if ($availableStock < $item['quantity']) {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Stock insuffisant pour ' . $item['name']);
                    }

                    // Créer l'OrderItem
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_variant_id' => $variant?->id,
                        'item_type' => 'product',
                        'product_name' => $product->name,
                        'product_sku' => $variant?->sku ?? $product->sku,
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['price'] * $item['quantity'],
                        'variant_attributes' => $variant?->attributes_snapshot,
                    ]);

                    // Décrémenter le stock
                    if ($variant) {
                        $variant->decrement('stock', $item['quantity']);
                    } else {
                        $product->decrement('stock', $item['quantity']);
                    }
                }
            }

            DB::commit();

            // Clear cart
            $this->cartService->clearCart();

            // Redirect to payment
            return redirect()->route('payment.show', $order);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }
}
