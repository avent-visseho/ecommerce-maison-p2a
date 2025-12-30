<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::with('parent')
            ->withCount('posts')
            ->orderBy('order')
            ->paginate(15);

        return view('admin.blog.categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = BlogCategory::whereNull('parent_id')
            ->active()
            ->orderBy('order')
            ->get();

        return view('admin.blog.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blog_categories,slug',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:blog_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blog/categories', 'public');
        }

        BlogCategory::create($validated);

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    public function edit(BlogCategory $category)
    {
        $parentCategories = BlogCategory::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->active()
            ->orderBy('order')
            ->get();

        return view('admin.blog.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, BlogCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blog_categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:blog_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
            'delete_image' => 'boolean',
        ]);

        // Prevent category from being its own parent
        if ($validated['parent_id'] == $category->id) {
            return back()->withErrors(['parent_id' => 'Une catégorie ne peut pas être sa propre parente.'])->withInput();
        }

        // Generate slug if changed
        if (!empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $validated['is_active'] = $request->has('is_active');

        // Handle image deletion
        if ($request->has('delete_image') && $category->image) {
            Storage::disk('public')->delete($category->image);
            $validated['image'] = null;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')->store('blog/categories', 'public');
        }

        unset($validated['delete_image']);

        $category->update($validated);

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(BlogCategory $category)
    {
        // Delete image
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}
