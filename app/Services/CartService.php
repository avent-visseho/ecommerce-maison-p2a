<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected $sessionKey = 'cart';

    /**
     * Get cart items
     */
    public function getCart(): array
    {
        return Session::get($this->sessionKey, []);
    }

    /**
     * Add item to cart (with support for variants)
     */
    public function addToCart(Product $product, int $quantity = 1, ?ProductVariant $variant = null): void
    {
        $cart = $this->getCart();

        // Clé unique : product_id + variant_id
        $cartKey = $variant ? "p{$product->id}_v{$variant->id}" : "p{$product->id}";

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            // Utiliser les données de la variante si présente
            $effectivePrice = $variant ? $variant->effective_price : $product->effective_price;
            $effectiveStock = $variant ? $variant->stock : $product->stock;
            $effectiveImage = $variant && $variant->image ? $variant->image : $product->main_image;
            $variantDisplay = $variant ? $variant->display_name : null;

            $cart[$cartKey] = [
                'product_id' => $product->id,
                'variant_id' => $variant?->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $effectivePrice,
                'image' => $effectiveImage,
                'quantity' => $quantity,
                'stock' => $effectiveStock,
                'variant_name' => $variantDisplay,
            ];
        }

        // Limiter à la quantité en stock
        $stockLimit = $variant ? $variant->stock : $product->stock;
        if ($cart[$cartKey]['quantity'] > $stockLimit) {
            $cart[$cartKey]['quantity'] = $stockLimit;
        }

        Session::put($this->sessionKey, $cart);
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity(string $cartKey, int $quantity): void
    {
        $cart = $this->getCart();

        if (isset($cart[$cartKey])) {
            if ($quantity <= 0) {
                unset($cart[$cartKey]);
            } else {
                $cart[$cartKey]['quantity'] = $quantity;

                // Ensure quantity doesn't exceed stock
                if ($quantity > $cart[$cartKey]['stock']) {
                    $cart[$cartKey]['quantity'] = $cart[$cartKey]['stock'];
                }
            }

            Session::put($this->sessionKey, $cart);
        }
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart(string $cartKey): void
    {
        $cart = $this->getCart();

        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            Session::put($this->sessionKey, $cart);
        }
    }

    /**
     * Clear cart
     */
    public function clearCart(): void
    {
        Session::forget($this->sessionKey);
    }

    /**
     * Get cart total
     */
    public function getTotal(): float
    {
        $cart = $this->getCart();
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }

    /**
     * Get cart item count
     */
    public function getCount(): int
    {
        $cart = $this->getCart();
        $count = 0;

        foreach ($cart as $item) {
            $count += $item['quantity'];
        }

        return $count;
    }

    /**
     * Check if cart is empty
     */
    public function isEmpty(): bool
    {
        return empty($this->getCart());
    }

    /**
     * Get cart item
     */
    public function getItem(int $productId, ?int $variantId = null): ?array
    {
        $cartKey = $variantId ? "p{$productId}_v{$variantId}" : "p{$productId}";
        $cart = $this->getCart();
        return $cart[$cartKey] ?? null;
    }
}
