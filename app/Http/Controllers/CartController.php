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
                return redirect()->back()->with('error', 'Variante invalide pour ce produit.');
            }

            // Vérifier le stock de la variante
            if ($variant->isOutOfStock()) {
                return redirect()->back()->with('error', 'Cette variante est en rupture de stock.');
            }

            if ($quantity > $variant->stock) {
                return redirect()->back()->with('error', 'Stock insuffisant pour cette variante.');
            }
        } else {
            // Produit simple : vérifier le stock
            if ($product->isOutOfStock()) {
                return redirect()->back()->with('error', 'Ce produit est en rupture de stock.');
            }

            if ($quantity > $product->stock) {
                return redirect()->back()->with('error', 'Stock insuffisant pour ce produit.');
            }
        }

        $this->cartService->addToCart($product, $quantity, $variant);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produit ajouté au panier',
                'cart_count' => $this->cartService->getCount(),
            ]);
        }

        return redirect()->back()->with('success', 'Produit ajouté au panier avec succès.');
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

        return redirect()->back()->with('success', 'Panier mis à jour.');
    }

    public function remove($cartKey)
    {
        $this->cartService->removeFromCart($cartKey);

        return redirect()->back()->with('success', 'Produit retiré du panier.');
    }

    public function clear()
    {
        $this->cartService->clearCart();

        return redirect()->route('cart.index')->with('success', 'Panier vidé.');
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
                'message' => "Durée minimum de location : {$rentalItem->min_rental_days} jour(s).",
            ], 400);
        }

        if ($rentalItem->max_rental_days && $days > $rentalItem->max_rental_days) {
            return response()->json([
                'success' => false,
                'message' => "Durée maximum de location : {$rentalItem->max_rental_days} jour(s).",
            ], 400);
        }

        // Check quantity
        if ($quantity > $rentalItem->quantity) {
            return response()->json([
                'success' => false,
                'message' => "Stock insuffisant. Seulement {$rentalItem->quantity} disponible(s).",
            ], 400);
        }

        // Add to cart
        try {
            $this->cartService->addRentalToCart($rentalItem, $startDate, $endDate, $quantity);

            return response()->json([
                'success' => true,
                'message' => 'Objet ajouté au panier avec succès.',
                'cart_count' => $this->cartService->getCount(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
