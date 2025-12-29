<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\CartService;
use App\Services\FedaPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
        $subtotal = $this->cartService->getTotal();
        $shipping = 0; // Fixed shipping cost
        $total = $subtotal + $shipping;

        return view('public.checkout.index', compact('cart', 'subtotal', 'shipping', 'total'));
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
            $subtotal = $this->cartService->getTotal();
            $shipping = 0;
            $total = $subtotal + $shipping;

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'subtotal' => $subtotal,
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
                // Récupérer produit et variante si applicable
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
