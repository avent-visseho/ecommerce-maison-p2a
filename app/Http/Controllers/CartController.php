<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        $product = Product::active()->inStock()->findOrFail($id);

        $quantity = $request->input('quantity', 1);

        if ($quantity > $product->stock) {
            return redirect()->back()->with('error', 'Stock insuffisant pour ce produit.');
        }

        $this->cartService->addToCart($product, $quantity);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produit ajouté au panier',
                'cart_count' => $this->cartService->getCount(),
            ]);
        }

        return redirect()->back()->with('success', 'Produit ajouté au panier avec succès.');
    }

    public function update(Request $request, $id)
    {
        $quantity = $request->input('quantity', 1);

        $this->cartService->updateQuantity($id, $quantity);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'total' => $this->cartService->getTotal(),
                'cart_count' => $this->cartService->getCount(),
            ]);
        }

        return redirect()->back()->with('success', 'Panier mis à jour.');
    }

    public function remove($id)
    {
        $this->cartService->removeFromCart($id);

        return redirect()->back()->with('success', 'Produit retiré du panier.');
    }

    public function clear()
    {
        $this->cartService->clearCart();

        return redirect()->route('cart.index')->with('success', 'Panier vidé.');
    }
}
