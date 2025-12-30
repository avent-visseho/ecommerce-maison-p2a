<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\RentalItem;
use Carbon\Carbon;
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

    /**
     * Add rental item to cart
     */
    public function addRentalToCart(RentalItem $item, Carbon $startDate, Carbon $endDate, int $quantity = 1): void
    {
        // Verify availability
        if (!$item->isAvailable($startDate, $endDate, $quantity)) {
            throw new \Exception('Cet objet n\'est pas disponible pour les dates sélectionnées.');
        }

        $cart = $this->getCart();

        // Calculate duration and pricing
        $days = $startDate->diffInDays($endDate) + 1;
        $pricing = $item->calculatePrice($days);

        // Unique key: r{item_id}_{startDate}_{endDate}
        $cartKey = "r{$item->id}_{$startDate->format('Ymd')}_{$endDate->format('Ymd')}";

        $cart[$cartKey] = [
            'type' => 'rental',
            'rental_item_id' => $item->id,
            'name' => $item->name,
            'slug' => $item->slug,
            'image' => $item->main_image,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'duration_days' => $days,
            'quantity' => $quantity,
            'rate_type' => $pricing['rate_type'],
            'rate' => $pricing['rate'],
            'price' => $pricing['subtotal'], // Price per item
            'deposit' => $item->deposit_amount,
        ];

        Session::put($this->sessionKey, $cart);
    }

    /**
     * Get total with deposits separated
     */
    public function getTotalWithDeposits(): array
    {
        $cart = $this->getCart();
        $subtotal = 0;
        $deposits = 0;

        foreach ($cart as $item) {
            if (isset($item['type']) && $item['type'] === 'rental') {
                $rentalPrice = $item['price'] * $item['quantity'];
                $rentalDeposit = $item['deposit'] * $item['quantity'];
                $subtotal += $rentalPrice;
                $deposits += $rentalDeposit;
            } else {
                $subtotal += $item['price'] * $item['quantity'];
            }
        }

        return [
            'subtotal' => $subtotal,
            'deposits' => $deposits,
            'total' => $subtotal + $deposits
        ];
    }
}
