<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'rental_item_id',
        'item_type',
        'product_name',
        'product_sku',
        'price',
        'quantity',
        'subtotal',
        'variant_attributes',
        'rental_start_date',
        'rental_end_date',
        'rental_duration_days',
        'rental_deposit',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'rental_deposit' => 'decimal:2',
        'rental_start_date' => 'date',
        'rental_end_date' => 'date',
        'variant_attributes' => 'array',
    ];

    /**
     * Get the order that owns the item.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that owns the item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the product variant that owns the item.
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    /**
     * Get the rental item that owns the order item.
     */
    public function rentalItem(): BelongsTo
    {
        return $this->belongsTo(RentalItem::class);
    }

    /**
     * Get the rental reservation for this order item.
     */
    public function rentalReservation(): HasOne
    {
        return $this->hasOne(RentalReservation::class);
    }

    /**
     * Check if this is a rental item.
     */
    public function isRental(): bool
    {
        return $this->item_type === 'rental';
    }

    /**
     * Check if this is a product item.
     */
    public function isProduct(): bool
    {
        return $this->item_type === 'product';
    }

    /**
     * Get variant display string.
     */
    public function getVariantDisplayAttribute(): string
    {
        if (!$this->variant_attributes) {
            return '';
        }

        return collect($this->variant_attributes)
            ->map(fn($attr) => $attr['value'])
            ->join(', ');
    }
}
