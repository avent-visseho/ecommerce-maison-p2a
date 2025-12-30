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
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'low_stock_alert' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'attribute_values' => 'nullable|array',
            'attribute_values.*' => 'nullable|array',
            'attribute_values.*.*' => 'exists:product_attribute_values,id',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_default'] = $request->has('is_default');
        $validated['sort_order'] = $request->input('sort_order', 0);

        // Préparer les données communes pour toutes les variantes
        $commonData = [
            'price' => $validated['price'] ?? null,
            'sale_price' => $validated['sale_price'] ?? null,
            'stock' => $validated['stock'],
            'low_stock_alert' => $validated['low_stock_alert'],
            'is_active' => $validated['is_active'],
            'is_default' => $validated['is_default'],
            'sort_order' => $validated['sort_order'],
        ];

        // Upload image si présente
        if ($request->hasFile('image')) {
            $commonData['image'] = $request->file('image');
        }

        // Vérifier si des attributs sont sélectionnés
        $attributeValues = $validated['attribute_values'] ?? [];
        $attributeValues = array_filter($attributeValues, fn($values) => !empty($values));

        if (empty($attributeValues)) {
            // Aucun attribut sélectionné - créer une variante simple
            $variant = $this->variantService->createVariant($product, $commonData);

            return redirect()
                ->route('admin.products.variants.index', $product)
                ->with('success', 'Variante créée avec succès.');
        }

        // Créer plusieurs variantes à partir des combinaisons
        $createdVariants = $this->variantService->createVariants($product, $commonData, $attributeValues);

        $count = $createdVariants->count();
        $message = $count > 1
            ? "{$count} variantes créées avec succès."
            : 'Variante créée avec succès.';

        return redirect()
            ->route('admin.products.variants.index', $product)
            ->with('success', $message);
    }

    /**
     * Formulaire édition
     */
    public function edit(Product $product, ProductVariant $variant)
    {
        $attributes = ProductAttribute::active()->with('activeValues')->get();
        $variant->load('attributeValues');

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
            ->with('success', 'Variante mise à jour avec succès.');
    }

    /**
     * Supprimer
     */
    public function destroy(Product $product, ProductVariant $variant)
    {
        $this->variantService->deleteVariant($variant);

        return redirect()
            ->route('admin.products.variants.index', $product)
            ->with('success', 'Variante supprimée avec succès.');
    }
}
