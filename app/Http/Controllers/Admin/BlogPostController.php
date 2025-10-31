<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\BlogNewsletter;
use App\Mail\NewBlogPostNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::with(['author', 'category', 'tags']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('blog_category_id', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->latest()->paginate(15);
        $categories = BlogCategory::active()->get();

        return view('admin.blog.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = BlogCategory::active()->get();
        $tags = BlogTag::all();

        return view('admin.blog.posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blog_posts,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date',
            'scheduled_at' => 'nullable|date|after:now',
            'is_featured' => 'boolean',
            'allow_comments' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:blog_tags,id',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // Set author as current logged in user
        $validated['author_id'] = auth()->id();

        // Handle checkboxes
        $validated['is_featured'] = $request->has('is_featured');
        $validated['allow_comments'] = $request->has('allow_comments');

        // Handle publication dates
        if ($validated['status'] === 'published') {
            $validated['published_at'] = $request->filled('published_at')
                ? $validated['published_at']
                : now();
        } elseif ($validated['status'] === 'scheduled') {
            if (empty($validated['scheduled_at'])) {
                return back()->withErrors(['scheduled_at' => 'La date de publication planifiée est requise.'])->withInput();
            }
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blog', 'public');
        }

        // Handle multiple images
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('blog', 'public');
            }
            $validated['images'] = $images;
        }

        // Extract tags before creating post
        $tags = $validated['tags'] ?? [];
        unset($validated['tags']);

        // Create post
        $post = BlogPost::create($validated);

        // Attach tags
        if (!empty($tags)) {
            $post->tags()->attach($tags);
        }

        // Send newsletter if published
        if ($validated['status'] === 'published') {
            $this->sendNewsletter($post);
        }

        return redirect()->route('admin.blog.posts.index')
            ->with('success', 'Article créé avec succès.');
    }

    public function edit(BlogPost $post)
    {
        $categories = BlogCategory::active()->get();
        $tags = BlogTag::all();

        return view('admin.blog.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, BlogPost $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blog_posts,slug,' . $post->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date',
            'scheduled_at' => 'nullable|date|after:now',
            'is_featured' => 'boolean',
            'allow_comments' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:blog_tags,id',
            'delete_featured_image' => 'boolean',
        ]);

        // Generate slug if changed
        if (!empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // Handle checkboxes
        $validated['is_featured'] = $request->has('is_featured');
        $validated['allow_comments'] = $request->has('allow_comments');

        // Handle publication dates
        $wasPublished = $post->status === 'published';
        if ($validated['status'] === 'published') {
            $validated['published_at'] = $request->filled('published_at')
                ? $validated['published_at']
                : ($post->published_at ?? now());
        } elseif ($validated['status'] === 'scheduled') {
            if (empty($validated['scheduled_at'])) {
                return back()->withErrors(['scheduled_at' => 'La date de publication planifiée est requise.'])->withInput();
            }
        }

        // Handle featured image deletion
        if ($request->has('delete_featured_image') && $post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
            $validated['featured_image'] = null;
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('blog', 'public');
        }

        // Handle multiple images
        if ($request->hasFile('images')) {
            $images = $post->images ?? [];
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('blog', 'public');
            }
            $validated['images'] = $images;
        }

        // Extract tags before updating post
        $tags = $validated['tags'] ?? [];
        unset($validated['tags']);
        unset($validated['delete_featured_image']);

        // Update post
        $post->update($validated);

        // Sync tags
        $post->tags()->sync($tags);

        // Send newsletter if newly published
        if (!$wasPublished && $validated['status'] === 'published') {
            $this->sendNewsletter($post);
        }

        return redirect()->route('admin.blog.posts.index')
            ->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy(BlogPost $post)
    {
        // Delete images
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        if ($post->images) {
            foreach ($post->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $post->delete();

        return redirect()->route('admin.blog.posts.index')
            ->with('success', 'Article supprimé avec succès.');
    }

    /**
     * Send newsletter to all active subscribers
     */
    private function sendNewsletter(BlogPost $post)
    {
        $subscribers = BlogNewsletter::active()->get();

        foreach ($subscribers as $subscriber) {
            try {
                Mail::to($subscriber->email)->send(new NewBlogPostNotification($post, $subscriber));
            } catch (\Exception $e) {
                // Log error but don't stop the process
                \Log::error('Failed to send newsletter: ' . $e->getMessage());
            }
        }
    }
}
