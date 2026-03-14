<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductAttribute extends Model
{
    protected $fillable = [
        'name',
        'code',
        'type',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Valeurs possibles pour cet attribut
     */
    public function values(): HasMany
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    /**
     * Valeurs actives triées
     */
    public function activeValues(): HasMany
    {
        return $this->values()->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Scope actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Produits utilisant cet attribut comme checkbox
     */
    public function checkboxProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_checkbox_attributes');
    }

    /**
     * Vérifier si c'est un attribut checkbox
     */
    public function isCheckbox(): bool
    {
        return $this->type === 'checkbox';
    }
}
