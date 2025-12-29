<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'long_description',
        'price',
        'sale_price',
        'sku',
        'stock',
        'low_stock_alert',
        'category_id',
        'brand_id',
        'main_image',
        'images',
        'is_active',
        'is_featured',
        'views',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'images' => 'array',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = 'PRD-' . strtoupper(Str::random(8));
            }
        });
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the brand that owns the product.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the variants for the product.
     */
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Get active variants for the product.
     */
    public function activeVariants(): HasMany
    {
        return $this->variants()->active()->orderBy('sort_order');
    }

    /**
     * Get the default variant for the product.
     */
    public function defaultVariant(): HasOne
    {
        return $this->hasOne(ProductVariant::class)->where('is_default', true);
    }

    /**
     * Check if product has variants.
     */
    public function hasVariants(): bool
    {
        return $this->variants()->active()->exists();
    }

    /**
     * Get minimum price (product or variants).
     */
    public function getMinPriceAttribute()
    {
        if (!$this->hasVariants()) {
            return $this->effective_price;
        }

        // Récupérer toutes les variantes actives et calculer leur prix effectif
        $variantPrices = $this->activeVariants()
            ->get()
            ->map(function ($variant) {
                // Prix effectif de la variante : sale_price > price > product price
                return $variant->sale_price ?? $variant->price ?? $this->price;
            });

        if ($variantPrices->isEmpty()) {
            return $this->effective_price;
        }

        $variantMinPrice = $variantPrices->min();

        return min($this->effective_price, $variantMinPrice);
    }

    /**
     * Get maximum price (product or variants).
     */
    public function getMaxPriceAttribute()
    {
        if (!$this->hasVariants()) {
            return $this->effective_price;
        }

        // Récupérer toutes les variantes actives et calculer leur prix effectif
        $variantPrices = $this->activeVariants()
            ->get()
            ->map(function ($variant) {
                // Prix effectif de la variante : sale_price > price > product price
                return $variant->sale_price ?? $variant->price ?? $this->price;
            });

        if ($variantPrices->isEmpty()) {
            return $this->effective_price;
        }

        $variantMaxPrice = $variantPrices->max();

        return max($this->effective_price, $variantMaxPrice);
    }

    /**
     * Get total stock (product + variants).
     */
    public function getTotalStockAttribute(): int
    {
        if (!$this->hasVariants()) {
            return $this->stock;
        }

        return $this->activeVariants()->sum('stock');
    }

    /**
     * Get price display (with range if variants).
     */
    public function getPriceDisplayAttribute(): string
    {
        if (!$this->hasVariants()) {
            return number_format($this->effective_price, 0, ',', ' ') . ' €';
        }

        $min = $this->min_price;
        $max = $this->max_price;

        if ($min == $max) {
            return number_format($min, 0, ',', ' ') . ' €';
        }

        return number_format($min, 0, ',', ' ') . ' - ' . number_format($max, 0, ',', ' ') . ' €';
    }

    /**
     * Get the effective price (sale price if available, otherwise regular price)
     */
    public function getEffectivePriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    /**
     * Check if product is on sale
     */
    public function isOnSale(): bool
    {
        return $this->sale_price !== null && $this->sale_price < $this->price;
    }

    /**
     * Check if product is low on stock
     */
    public function isLowStock(): bool
    {
        return $this->stock <= $this->low_stock_alert;
    }

    /**
     * Check if product is out of stock
     */
    public function isOutOfStock(): bool
    {
        return $this->stock <= 0;
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include in-stock products.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope a query to only include low stock products.
     */
    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock', '<=', 'low_stock_alert');
    }

    /**
     * Increment product views
     */
    public function incrementViews()
    {
        $this->increment('views');
    }
}
