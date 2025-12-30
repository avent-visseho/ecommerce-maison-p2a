<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RentalCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RentalCategoryController extends Controller
{
    public function index()
    {
        $categories = RentalCategory::with('parent')->latest()->paginate(15);

        return view('admin.rental-categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = RentalCategory::whereNull('parent_id')->get();

        return view('admin.rental-categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:rental_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'is_active' => 'boolean',
            'order' => 'integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('rental-categories', 'public');
        }

        RentalCategory::create($validated);

        return redirect()->route('admin.rental-categories.index')
            ->with('success', 'Catégorie de location créée avec succès.');
    }

    public function edit(RentalCategory $rentalCategory)
    {
        $parentCategories = RentalCategory::whereNull('parent_id')
            ->where('id', '!=', $rentalCategory->id)
            ->get();

        return view('admin.rental-categories.edit', compact('rentalCategory', 'parentCategories'));
    }

    public function update(Request $request, RentalCategory $rentalCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:rental_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'is_active' => 'boolean',
            'order' => 'integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($rentalCategory->image) {
                Storage::disk('public')->delete($rentalCategory->image);
            }
            $validated['image'] = $request->file('image')->store('rental-categories', 'public');
        }

        $rentalCategory->update($validated);

        return redirect()->route('admin.rental-categories.index')
            ->with('success', 'Catégorie de location mise à jour avec succès.');
    }

    public function destroy(RentalCategory $rentalCategory)
    {
        if ($rentalCategory->image) {
            Storage::disk('public')->delete($rentalCategory->image);
        }

        $rentalCategory->delete();

        return redirect()->route('admin.rental-categories.index')
            ->with('success', 'Catégorie de location supprimée avec succès.');
    }
}
