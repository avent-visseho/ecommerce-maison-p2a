<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\RentalItem;
use App\Services\CartService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
        $totals = $this->cartService->getTotalWithDeposits();

        return view('public.cart.index', compact('cart', 'totals'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::active()->findOrFail($id);
        $quantity = $request->input('quantity', 1);

        // Récupérer la variante si spécifiée
        $variant = null;
        if ($request->has('variant_id')) {
            $variant = ProductVariant::active()->findOrFail($request->variant_id);

            // Vérifier que la variante appartient au produit
            if ($variant->product_id !== $product->id) {
                return redirect()->back()->with('error', __('messages.cart.invalid_variant'));
            }

            // Vérifier le stock de la variante
            if ($variant->isOutOfStock()) {
                return redirect()->back()->with('error', __('messages.cart.variant_out_of_stock'));
            }

            if ($quantity > $variant->stock) {
                return redirect()->back()->with('error', __('messages.cart.variant_insufficient_stock', ['available' => $variant->stock]));
            }
        } else {
            // Produit simple : vérifier le stock
            if ($product->isOutOfStock()) {
                return redirect()->back()->with('error', __('messages.cart.out_of_stock'));
            }

            if ($quantity > $product->stock) {
                return redirect()->back()->with('error', __('messages.cart.insufficient_stock', ['available' => $product->stock]));
            }
        }

        $this->cartService->addToCart($product, $quantity, $variant);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('messages.cart.product_added'),
                'cart_count' => $this->cartService->getCount(),
            ]);
        }

        return redirect()->back()->with('success', __('messages.cart.product_added'));
    }

    public function addMultipleVariants(Request $request, $id)
    {
        $product = Product::active()->findOrFail($id);

        $request->validate([
            'variants' => 'required|array|min:1',
            'variants.*' => 'integer|min:1',
        ]);

        $added = 0;
        foreach ($request->variants as $variantId => $quantity) {
            $variant = ProductVariant::active()->where('product_id', $product->id)->find($variantId);
            if (!$variant || $variant->isOutOfStock()) continue;

            $quantity = min($quantity, $variant->stock);
            $this->cartService->addToCart($product, $quantity, $variant);
            $added += $quantity;
        }

        if ($added === 0) {
            return redirect()->back()->with('error', __('messages.cart.no_variants_added', ['default' => 'Aucune variante ajoutée']));
        }

        return redirect()->back()->with('success', __('messages.cart.products_added', ['count' => $added, 'default' => $added . ' article(s) ajouté(s) au panier']));
    }

    public function update(Request $request, $cartKey)
    {
        $quantity = $request->input('quantity', 1);

        $this->cartService->updateQuantity($cartKey, $quantity);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'total' => $this->cartService->getTotal(),
                'cart_count' => $this->cartService->getCount(),
            ]);
        }

        return redirect()->back()->with('success', __('messages.cart.updated'));
    }

    public function remove($cartKey)
    {
        $this->cartService->removeFromCart($cartKey);

        return redirect()->back()->with('success', __('messages.cart.product_removed'));
    }

    public function clear()
    {
        $this->cartService->clearCart();

        return redirect()->route('cart.index')->with('success', __('messages.cart.cleared'));
    }

    public function addRental(Request $request, $id)
    {
        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'quantity' => 'required|integer|min:1',
        ]);

        $rentalItem = RentalItem::active()->findOrFail($id);

        // Parse dates
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $quantity = $validated['quantity'];

        // Calculate duration
        $days = $startDate->diffInDays($endDate) + 1;

        // Check min/max rental days
        if ($rentalItem->min_rental_days && $days < $rentalItem->min_rental_days) {
            return response()->json([
                'success' => false,
                'message' => __('messages.cart.rental_min_days', ['days' => $rentalItem->min_rental_days]),
            ], 400);
        }

        if ($rentalItem->max_rental_days && $days > $rentalItem->max_rental_days) {
            return response()->json([
                'success' => false,
                'message' => __('messages.cart.rental_max_days', ['days' => $rentalItem->max_rental_days]),
            ], 400);
        }

        // Check quantity
        if ($quantity > $rentalItem->quantity) {
            return response()->json([
                'success' => false,
                'message' => __('messages.cart.rental_insufficient_stock', ['available' => $rentalItem->quantity]),
            ], 400);
        }

        // Add to cart
        try {
            $this->cartService->addRentalToCart($rentalItem, $startDate, $endDate, $quantity);

            return response()->json([
                'success' => true,
                'message' => __('messages.cart.rental_added'),
                'cart_count' => $this->cartService->getCount(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.cart.rental_error'),
            ], 400);
        }
    }
}
