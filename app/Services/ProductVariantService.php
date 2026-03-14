<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Storage;

class ProductVariantService
{
    /**
     * Créer une variante avec ses attributs
     */
    public function createVariant(Product $product, array $data): ProductVariant
    {
        $variant = $product->variants()->create([
            'sku' => $data['sku'] ?? null,
            'price' => $data['price'] ?? null,
            'sale_price' => $data['sale_price'] ?? null,
            'stock' => $data['stock'] ?? 0,
            'low_stock_alert' => $data['low_stock_alert'] ?? 10,
            'is_active' => $data['is_active'] ?? true,
            'is_default' => $data['is_default'] ?? false,
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        // Upload image si présente
        if (isset($data['image']) && $data['image']) {
            $variant->image = $data['image']->store('product-variants', 'public');
            $variant->save();
        }

        // Attacher les attributs avec leur product_attribute_id
        if (isset($data['attribute_values'])) {
            $syncData = [];
            foreach ($data['attribute_values'] as $attributeId => $valueId) {
                $attributeValue = ProductAttributeValue::find($valueId);
                if ($attributeValue) {
                    $syncData[$valueId] = [
                        'product_attribute_id' => $attributeValue->product_attribute_id
                    ];
                }
            }
            $variant->attributeValues()->sync($syncData);
        }

        // Si définie comme défaut, retirer le flag des autres
        if ($variant->is_default) {
            $this->setAsDefault($variant);
        }

        return $variant->load('attributeValues.attribute');
    }

    /**
     * Mettre à jour une variante
     */
    public function updateVariant(ProductVariant $variant, array $data): ProductVariant
    {
        // Supprimer ancienne image si nouvelle uploadée
        if (isset($data['image']) && $data['image'] && $variant->image) {
            Storage::disk('public')->delete($variant->image);
        }

        $variant->update([
            'price' => array_key_exists('price', $data) ? $data['price'] : $variant->price,
            'sale_price' => array_key_exists('sale_price', $data) ? $data['sale_price'] : $variant->sale_price,
            'stock' => array_key_exists('stock', $data) ? $data['stock'] : $variant->stock,
            'low_stock_alert' => array_key_exists('low_stock_alert', $data) ? $data['low_stock_alert'] : $variant->low_stock_alert,
            'is_active' => array_key_exists('is_active', $data) ? $data['is_active'] : $variant->is_active,
            'is_default' => array_key_exists('is_default', $data) ? $data['is_default'] : $variant->is_default,
            'sort_order' => array_key_exists('sort_order', $data) ? $data['sort_order'] : $variant->sort_order,
        ]);

        // Gérer suppression de l'image
        if (isset($data['remove_image']) && $data['remove_image']) {
            if ($variant->image) {
                Storage::disk('public')->delete($variant->image);
                $variant->image = null;
                $variant->save();
            }
        }

        // Upload nouvelle image
        if (isset($data['image']) && $data['image']) {
            // Supprimer l'ancienne image si elle existe
            if ($variant->image) {
                Storage::disk('public')->delete($variant->image);
            }
            $variant->image = $data['image']->store('product-variants', 'public');
            $variant->save();
        }

        // Mettre à jour attributs avec leur product_attribute_id
        if (isset($data['attribute_values'])) {
            $syncData = [];
            foreach ($data['attribute_values'] as $attributeId => $valueId) {
                $attributeValue = ProductAttributeValue::find($valueId);
                if ($attributeValue) {
                    $syncData[$valueId] = [
                        'product_attribute_id' => $attributeValue->product_attribute_id
                    ];
                }
            }
            $variant->attributeValues()->sync($syncData);
        }

        // Gérer le flag par défaut
        if ($variant->is_default) {
            $this->setAsDefault($variant);
        }

        return $variant->load('attributeValues.attribute');
    }

    /**
     * Définir comme variante par défaut
     */
    public function setAsDefault(ProductVariant $variant): void
    {
        // Retirer is_default des autres variantes du même produit
        ProductVariant::where('product_id', $variant->product_id)
            ->where('id', '!=', $variant->id)
            ->update(['is_default' => false]);
    }

    /**
     * Supprimer une variante (soft delete)
     */
    public function deleteVariant(ProductVariant $variant): bool
    {
        // Supprimer l'image
        if ($variant->image) {
            Storage::disk('public')->delete($variant->image);
        }

        return $variant->delete();
    }

    /**
     * Trouver une variante par ses attributs
     */
    public function findVariantByAttributes(Product $product, array $attributeValueIds): ?ProductVariant
    {
        $variants = $product->activeVariants()->with('attributeValues')->get();

        foreach ($variants as $variant) {
            $variantAttributeIds = $variant->attributeValues->pluck('id')->sort()->values()->toArray();
            $searchAttributeIds = collect($attributeValueIds)->sort()->values()->toArray();

            if ($variantAttributeIds === $searchAttributeIds) {
                return $variant;
            }
        }

        return null;
    }

    /**
     * Générer un SKU unique pour variante
     */
    public function generateSku(Product $product, array $attributeValueCodes = []): string
    {
        $baseSku = $product->sku;
        $suffix = !empty($attributeValueCodes)
            ? strtoupper(implode('-', $attributeValueCodes))
            : strtoupper(\Str::random(4));

        $sku = "{$baseSku}-{$suffix}";

        // Vérifier unicité
        $counter = 1;
        while (ProductVariant::where('sku', $sku)->exists()) {
            $sku = "{$baseSku}-{$suffix}-{$counter}";
            $counter++;
        }

        return $sku;
    }

    /**
     * Générer toutes les combinaisons possibles à partir des attributs sélectionnés
     *
     * @param array $attributeValues Format: ['attribute_id' => [value_id1, value_id2], ...]
     * @return array Tableau de combinaisons, chaque combinaison est un tableau ['attribute_id' => value_id]
     */
    public function generateCombinations(array $attributeValues): array
    {
        // Filtrer les attributs vides
        $attributeValues = array_filter($attributeValues, fn($values) => !empty($values));

        if (empty($attributeValues)) {
            return [];
        }

        // Convertir en tableau indexé pour faciliter le traitement
        $attributes = [];
        foreach ($attributeValues as $attributeId => $valueIds) {
            $attributes[] = [
                'attribute_id' => $attributeId,
                'values' => $valueIds
            ];
        }

        // Générer le produit cartésien
        $combinations = [[]];
        foreach ($attributes as $attribute) {
            $temp = [];
            foreach ($combinations as $combination) {
                foreach ($attribute['values'] as $valueId) {
                    $newCombination = $combination;
                    $newCombination[$attribute['attribute_id']] = $valueId;
                    $temp[] = $newCombination;
                }
            }
            $combinations = $temp;
        }

        return $combinations;
    }

    /**
     * Créer plusieurs variantes à partir de combinaisons d'attributs
     *
     * @param Product $product
     * @param array $data Données communes (price, stock, etc.)
     * @param array $attributeValues Format: ['attribute_id' => [value_id1, value_id2], ...]
     * @return \Illuminate\Support\Collection Collection de ProductVariant créées
     */
    public function createVariants(Product $product, array $data, array $attributeValues): \Illuminate\Support\Collection
    {
        $combinations = $this->generateCombinations($attributeValues);
        $createdVariants = collect();

        foreach ($combinations as $combination) {
            // Préparer les données pour cette variante
            $variantData = $data;
            $variantData['attribute_values'] = $combination;

            // Générer un SKU unique basé sur les codes des valeurs
            $valueCodes = [];
            foreach ($combination as $valueId) {
                $attributeValue = ProductAttributeValue::find($valueId);
                if ($attributeValue && $attributeValue->code) {
                    $valueCodes[] = $attributeValue->code;
                }
            }
            $variantData['sku'] = $this->generateSku($product, $valueCodes);

            // Créer la variante
            $variant = $this->createVariant($product, $variantData);
            $createdVariants->push($variant);
        }

        return $createdVariants;
    }
}
