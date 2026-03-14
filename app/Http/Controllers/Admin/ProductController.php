<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand'])
            ->latest()
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        $brands = Brand::active()->get();
        $checkboxAttributes = ProductAttribute::where('type', 'checkbox')->active()->with('activeValues')->get();

        return view('admin.products.create', compact('categories', 'brands', 'checkboxAttributes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'nullable|string|unique:products,sku',
            'stock' => 'required|integer|min:0',
            'low_stock_alert' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        // Generate unique slug
        $baseSlug = Str::slug($validated['name']);
        $slug = $baseSlug;
        $counter = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        // Generate SKU if not provided
        if (empty($validated['sku'])) {
            $validated['sku'] = 'PROD-' . strtoupper(Str::random(8));

            // Ensure uniqueness
            while (Product::where('sku', $validated['sku'])->exists()) {
                $validated['sku'] = 'PROD-' . strtoupper(Str::random(8));
            }
        }

        // Handle main image upload
        if ($request->hasFile('main_image')) {
            $validated['main_image'] = $request->file('main_image')->store('products', 'public');
        }

        // Handle multiple images
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('products', 'public');
            }
            $validated['images'] = $images;
        }

        $product = Product::create($validated);

        // Associer les attributs checkbox
        if ($request->has('checkbox_attributes')) {
            $product->checkboxAttributes()->sync($request->input('checkbox_attributes', []));
        }

        return redirect()->route('admin.products.index')
            ->with('success', __('messages.admin.product.created'));
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        $brands = Brand::active()->get();
        $checkboxAttributes = ProductAttribute::where('type', 'checkbox')->active()->with('activeValues')->get();
        $product->load('checkboxAttributes');

        return view('admin.products.edit', compact('product', 'categories', 'brands', 'checkboxAttributes'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'stock' => 'required|integer|min:0',
            'low_stock_alert' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        // Generate unique slug (excluding current product)
        $baseSlug = Str::slug($validated['name']);
        $slug = $baseSlug;
        $counter = 1;

        while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        // Handle main image upload
        if ($request->hasFile('main_image')) {
            if ($product->main_image) {
                Storage::disk('public')->delete($product->main_image);
            }
            $validated['main_image'] = $request->file('main_image')->store('products', 'public');
        } else {
            unset($validated['main_image']);
        }

        // Handle multiple images
        if ($request->hasFile('images')) {
            if ($product->images) {
                foreach ($product->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            $images = [];
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('products', 'public');
            }
            $validated['images'] = $images;
        } else {
            unset($validated['images']);
        }

        $product->update($validated);

        // Mettre à jour les attributs checkbox
        $product->checkboxAttributes()->sync($request->input('checkbox_attributes', []));

        return redirect()->route('admin.products.index')
            ->with('success', __('messages.admin.product.updated'));
    }

    public function destroy(Product $product)
    {
        if ($product->main_image) {
            Storage::disk('public')->delete($product->main_image);
        }

        if ($product->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', __('messages.admin.product.deleted'));
    }
}
