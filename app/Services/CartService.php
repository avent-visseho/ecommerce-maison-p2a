<?php

namespace App\Services;

use App\Models\Product;
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
     * Add item to cart
     */
    public function addToCart(Product $product, int $quantity = 1): void
    {
        $cart = $this->getCart();
        $productId = $product->id;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->effective_price,
                'image' => $product->main_image,
                'quantity' => $quantity,
                'stock' => $product->stock,
            ];
        }

        // Ensure quantity doesn't exceed stock
        if ($cart[$productId]['quantity'] > $product->stock) {
            $cart[$productId]['quantity'] = $product->stock;
        }

        Session::put($this->sessionKey, $cart);
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity(int $productId, int $quantity): void
    {
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] = $quantity;

                // Ensure quantity doesn't exceed stock
                if ($quantity > $cart[$productId]['stock']) {
                    $cart[$productId]['quantity'] = $cart[$productId]['stock'];
                }
            }

            Session::put($this->sessionKey, $cart);
        }
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart(int $productId): void
    {
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
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
    public function getItem(int $productId): ?array
    {
        $cart = $this->getCart();
        return $cart[$productId] ?? null;
    }
}
