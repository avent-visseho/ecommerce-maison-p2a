<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductVariant;
use App\Services\ProductVariantService;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    protected $variantService;

    public function __construct(ProductVariantService $variantService)
    {
        $this->variantService = $variantService;
    }

    /**
     * Afficher les variantes d'un produit
     */
    public function index(Product $product)
    {
        $variants = $product->variants()
            ->with('attributeValues.attribute')
            ->orderBy('sort_order')
            ->get();

        return view('admin.products.variants.index', compact('product', 'variants'));
    }

    /**
     * Formulaire création variante
     */
    public function create(Product $product)
    {
        $attributes = ProductAttribute::active()->with('activeValues')->get();

        return view('admin.products.variants.create', compact('product', 'attributes'));
    }

    /**
     * Enregistrer variante(s)
     */
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'variant_data' => 'required|array|min:1',
            'variant_data.*.price' => 'nullable|numeric|min:0',
            'variant_data.*.sale_price' => 'nullable|numeric|min:0',
            'variant_data.*.stock' => 'required|integer|min:0',
            'variant_data.*.low_stock_alert' => 'nullable|integer|min:0',
            'variant_data.*.attribute_values' => 'required|array|min:1',
            'variant_data.*.attribute_values.*' => 'exists:product_attribute_values,id',
            'variant_data.*.image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'is_active' => 'boolean',
        ]);

        $isActive = $request->has('is_active');
        $count = 0;

        foreach ($validated['variant_data'] as $index => $variantInput) {
            $variantData = [
                'price' => $variantInput['price'] ?? null,
                'sale_price' => $variantInput['sale_price'] ?? null,
                'stock' => $variantInput['stock'],
                'low_stock_alert' => $variantInput['low_stock_alert'] ?? 10,
                'is_active' => $isActive,
                'is_default' => $count === 0, // première variante par défaut
                'sort_order' => $count,
                'attribute_values' => $variantInput['attribute_values'],
            ];

            // Ajouter l'image si uploadée
            if ($request->hasFile("variant_data.{$index}.image")) {
                $variantData['image'] = $request->file("variant_data.{$index}.image");
            }

            // Générer un SKU unique
            $valueCodes = [];
            foreach ($variantInput['attribute_values'] as $valueId) {
                $attrValue = \App\Models\ProductAttributeValue::find($valueId);
                if ($attrValue && $attrValue->code) {
                    $valueCodes[] = $attrValue->code;
                }
            }
            $variantData['sku'] = $this->variantService->generateSku($product, $valueCodes);

            $this->variantService->createVariant($product, $variantData);
            $count++;
        }

        $message = $count > 1
            ? __('messages.admin.variant.created_many', ['count' => $count])
            : __('messages.admin.variant.created');

        return redirect()
            ->route('admin.products.variants.index', $product)
            ->with('success', $message);
    }

    /**
     * Formulaire édition
     */
    public function edit(Product $product, ProductVariant $variant)
    {
        $variant->load('attributeValues');

        // Only show attributes that this product's variants actually use
        $usedAttributeIds = $product->variants()
            ->with('attributeValues')
            ->get()
            ->pluck('attributeValues')
            ->flatten()
            ->pluck('product_attribute_id')
            ->unique();

        $attributes = ProductAttribute::active()
            ->whereIn('id', $usedAttributeIds)
            ->with('activeValues')
            ->get();

        return view('admin.products.variants.edit', compact('product', 'variant', 'attributes'));
    }

    /**
     * Mettre à jour
     */
    public function update(Request $request, Product $product, ProductVariant $variant)
    {
        $validated = $request->validate([
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'low_stock_alert' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'attribute_values' => 'required|array|min:1',
            'attribute_values.*' => 'exists:product_attribute_values,id',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'remove_image' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_default'] = $request->has('is_default');
        $validated['sort_order'] = $request->input('sort_order', 0);
        $validated['remove_image'] = $request->has('remove_image');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image');
        }

        $variant = $this->variantService->updateVariant($variant, $validated);

        return redirect()
            ->route('admin.products.variants.index', $product)
            ->with('success', __('messages.admin.variant.updated'));
    }

    /**
     * Supprimer
     */
    public function destroy(Product $product, ProductVariant $variant)
    {
        $this->variantService->deleteVariant($variant);

        return redirect()
            ->route('admin.products.variants.index', $product)
            ->with('success', __('messages.admin.variant.deleted'));
    }
}
