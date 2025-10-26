<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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
        $shipping = 2000; // Fixed shipping cost
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
            $shipping = 2000;
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
            foreach ($cart as $item) {
                $product = Product::find($item['id']);

                if (!$product || $product->stock < $item['quantity']) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Stock insuffisant pour ' . $item['name']);
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);

                // Decrease stock
                $product->decrement('stock', $item['quantity']);
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
