<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RentalCategory;
use App\Models\RentalItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RentalItemController extends Controller
{
    public function index()
    {
        $rentalItems = RentalItem::with('rentalCategory')
            ->latest()
            ->paginate(15);

        return view('admin.rental-items.index', compact('rentalItems'));
    }

    public function create()
    {
        $categories = RentalCategory::active()->get();

        return view('admin.rental-items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'daily_rate' => 'required|numeric|min:0',
            'weekly_rate' => 'nullable|numeric|min:0',
            'monthly_rate' => 'nullable|numeric|min:0',
            'deposit_amount' => 'required|numeric|min:0',
            'min_rental_days' => 'nullable|integer|min:1',
            'max_rental_days' => 'nullable|integer|min:1',
            'sku' => 'nullable|string|unique:rental_items,sku',
            'quantity' => 'required|integer|min:0',
            'rental_category_id' => 'required|exists:rental_categories,id',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        // Generate unique slug
        $baseSlug = Str::slug($validated['name']);
        $slug = $baseSlug;
        $counter = 1;

        while (RentalItem::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        // Generate SKU if not provided
        if (empty($validated['sku'])) {
            $validated['sku'] = 'RENT-' . strtoupper(Str::random(8));

            // Ensure uniqueness
            while (RentalItem::where('sku', $validated['sku'])->exists()) {
                $validated['sku'] = 'RENT-' . strtoupper(Str::random(8));
            }
        }

        // Handle main image upload
        if ($request->hasFile('main_image')) {
            $validated['main_image'] = $request->file('main_image')->store('rental-items', 'public');
        }

        // Handle multiple images
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('rental-items', 'public');
            }
            $validated['images'] = $images;
        }

        RentalItem::create($validated);

        return redirect()->route('admin.rental-items.index')
            ->with('success', 'Objet de location créé avec succès.');
    }

    public function edit(RentalItem $rentalItem)
    {
        $categories = RentalCategory::active()->get();

        return view('admin.rental-items.edit', compact('rentalItem', 'categories'));
    }

    public function update(Request $request, RentalItem $rentalItem)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'daily_rate' => 'required|numeric|min:0',
            'weekly_rate' => 'nullable|numeric|min:0',
            'monthly_rate' => 'nullable|numeric|min:0',
            'deposit_amount' => 'required|numeric|min:0',
            'min_rental_days' => 'nullable|integer|min:1',
            'max_rental_days' => 'nullable|integer|min:1',
            'sku' => 'nullable|string|unique:rental_items,sku,' . $rentalItem->id,
            'quantity' => 'required|integer|min:0',
            'rental_category_id' => 'required|exists:rental_categories,id',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        // Generate unique slug (excluding current item)
        $baseSlug = Str::slug($validated['name']);
        $slug = $baseSlug;
        $counter = 1;

        while (RentalItem::where('slug', $slug)->where('id', '!=', $rentalItem->id)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        // Handle main image upload
        if ($request->hasFile('main_image')) {
            if ($rentalItem->main_image) {
                Storage::disk('public')->delete($rentalItem->main_image);
            }
            $validated['main_image'] = $request->file('main_image')->store('rental-items', 'public');
        }

        // Handle multiple images
        if ($request->hasFile('images')) {
            if ($rentalItem->images) {
                foreach ($rentalItem->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            $images = [];
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('rental-items', 'public');
            }
            $validated['images'] = $images;
        }

        $rentalItem->update($validated);

        return redirect()->route('admin.rental-items.index')
            ->with('success', 'Objet de location mis à jour avec succès.');
    }

    public function destroy(RentalItem $rentalItem)
    {
        if ($rentalItem->main_image) {
            Storage::disk('public')->delete($rentalItem->main_image);
        }

        if ($rentalItem->images) {
            foreach ($rentalItem->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $rentalItem->delete();

        return redirect()->route('admin.rental-items.index')
            ->with('success', 'Objet de location supprimé avec succès.');
    }
}
