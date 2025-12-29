<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    /**
     * Liste des attributs
     */
    public function index()
    {
        $attributes = ProductAttribute::with('values')
            ->orderBy('sort_order')
            ->get();

        return view('admin.attributes.index', compact('attributes'));
    }

    /**
     * Créer attribut
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:product_attributes,code',
            'type' => 'required|in:select,color,text',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        ProductAttribute::create($validated);

        return redirect()
            ->route('admin.attributes.index')
            ->with('success', 'Attribut créé avec succès.');
    }

    /**
     * Modifier attribut
     */
    public function update(Request $request, ProductAttribute $attribute)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:product_attributes,code,' . $attribute->id,
            'type' => 'required|in:select,color,text',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $attribute->update($validated);

        return redirect()
            ->route('admin.attributes.index')
            ->with('success', 'Attribut mis à jour avec succès.');
    }

    /**
     * Supprimer attribut
     */
    public function destroy(ProductAttribute $attribute)
    {
        $attribute->delete();

        return redirect()
            ->route('admin.attributes.index')
            ->with('success', 'Attribut supprimé avec succès.');
    }

    /**
     * Gérer les valeurs d'un attribut
     */
    public function values(ProductAttribute $attribute)
    {
        $values = $attribute->values()->orderBy('sort_order')->get();

        return view('admin.attributes.values', compact('attribute', 'values'));
    }

    /**
     * Créer une valeur
     */
    public function storeValue(Request $request, ProductAttribute $attribute)
    {
        $validated = $request->validate([
            'value' => 'required|string|max:255',
            'code' => 'nullable|string',
            'color_hex' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', 0);

        $attribute->values()->create($validated);

        return redirect()
            ->route('admin.attributes.values', $attribute)
            ->with('success', 'Valeur ajoutée avec succès.');
    }

    /**
     * Modifier une valeur
     */
    public function updateValue(Request $request, ProductAttribute $attribute, ProductAttributeValue $value)
    {
        $validated = $request->validate([
            'value' => 'required|string|max:255',
            'code' => 'nullable|string',
            'color_hex' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', 0);

        $value->update($validated);

        return redirect()
            ->route('admin.attributes.values', $attribute)
            ->with('success', 'Valeur mise à jour avec succès.');
    }

    /**
     * Supprimer une valeur
     */
    public function destroyValue(ProductAttribute $attribute, ProductAttributeValue $value)
    {
        $value->delete();

        return redirect()
            ->route('admin.attributes.values', $attribute)
            ->with('success', 'Valeur supprimée avec succès.');
    }
}
