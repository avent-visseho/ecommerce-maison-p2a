<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\CartService;
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
        $total = $this->cartService->getTotal();

        return view('public.cart.index', compact('cart', 'total'));
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
}
