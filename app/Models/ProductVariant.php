<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProductVariant extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'sale_price',
        'stock',
        'low_stock_alert',
        'image',
        'is_active',
        'is_default',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    /**
     * Boot
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($variant) {
            if (empty($variant->sku)) {
                $variant->sku = 'VAR-' . strtoupper(Str::random(8));
            }
        });
    }

    /**
     * Produit parent
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Attributs de la variante (via pivot)
     */
    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductAttributeValue::class,
            'product_variant_attributes',
            'product_variant_id',
            'product_attribute_value_id'
        )->withTimestamps();
    }

    /**
     * Prix effectif (sale_price > variant price > product price)
     */
    public function getEffectivePriceAttribute()
    {
        if ($this->sale_price !== null) {
            return $this->sale_price;
        }
        if ($this->price !== null) {
            return $this->price;
        }
        return $this->product->effective_price;
    }

    /**
     * Vérifier si en promo
     */
    public function isOnSale(): bool
    {
        if ($this->sale_price !== null && $this->price !== null) {
            return $this->sale_price < $this->price;
        }
        if ($this->sale_price !== null && $this->price === null) {
            return $this->sale_price < $this->product->price;
        }
        return false;
    }

    /**
     * Stock bas
     */
    public function isLowStock(): bool
    {
        return $this->stock <= $this->low_stock_alert;
    }

    /**
     * Rupture de stock
     */
    public function isOutOfStock(): bool
    {
        return $this->stock <= 0;
    }

    /**
     * Nom complet de la variante (ex: "Rouge, Taille L")
     */
    public function getDisplayNameAttribute(): string
    {
        $attributes = $this->attributeValues()
            ->with('attribute')
            ->get()
            ->map(fn($val) => $val->value)
            ->join(', ');

        return $attributes ?: 'Variante sans attributs';
    }

    /**
     * Attributs formatés pour commande (snapshot)
     */
    public function getAttributesSnapshotAttribute(): array
    {
        return $this->attributeValues()
            ->with('attribute')
            ->get()
            ->map(function($attributeValue) {
                return [
                    'attribute' => $attributeValue->attribute->name,
                    'value' => $attributeValue->value,
                    'code' => $attributeValue->code,
                ];
            })
            ->toArray();
    }

    /**
     * Image avec fallback sur produit parent
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        if ($this->product->main_image) {
            return asset('storage/' . $this->product->main_image);
        }
        return asset('images/placeholder.png');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
}
