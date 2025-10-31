<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::with(['author', 'category', 'tags'])->published();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('blog_category_id', $request->category);
        }

        // Filter by tag
        if ($request->filled('tag')) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('blog_tags.id', $request->tag);
            });
        }

        // Sort
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'popular':
                $query->orderByDesc('views');
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'newest':
            default:
                $query->latest('published_at');
                break;
        }

        $posts = $query->paginate(12);

        // Sidebar data
        $featuredPosts = BlogPost::published()->featured()->limit(3)->get();
        $popularPosts = BlogPost::published()->orderByDesc('views')->limit(5)->get();
        $categories = BlogCategory::active()->withCount(['publishedPosts'])->get();
        $tags = BlogTag::has('posts')->withCount('posts')->get();

        return view('blog.index', compact('posts', 'featuredPosts', 'popularPosts', 'categories', 'tags'));
    }

    public function show($slug)
    {
        $post = BlogPost::with(['author', 'category', 'tags', 'approvedComments.user', 'approvedComments.replies'])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Increment views
        $post->incrementViews();

        // Related posts
        $relatedPosts = $post->relatedPosts(3);

        // Sidebar data
        $popularPosts = BlogPost::published()->orderByDesc('views')->limit(5)->get();
        $categories = BlogCategory::active()->withCount(['publishedPosts'])->get();

        return view('blog.show', compact('post', 'relatedPosts', 'popularPosts', 'categories'));
    }

    public function category($slug)
    {
        $category = BlogCategory::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $posts = BlogPost::with(['author', 'category', 'tags'])
            ->published()
            ->where('blog_category_id', $category->id)
            ->latest('published_at')
            ->paginate(12);

        // Sidebar data
        $featuredPosts = BlogPost::published()->featured()->limit(3)->get();
        $popularPosts = BlogPost::published()->orderByDesc('views')->limit(5)->get();
        $categories = BlogCategory::active()->withCount(['publishedPosts'])->get();
        $tags = BlogTag::has('posts')->withCount('posts')->get();

        return view('blog.category', compact('posts', 'category', 'featuredPosts', 'popularPosts', 'categories', 'tags'));
    }

    public function tag($slug)
    {
        $tag = BlogTag::where('slug', $slug)->firstOrFail();

        $posts = BlogPost::with(['author', 'category', 'tags'])
            ->published()
            ->whereHas('tags', function($q) use ($tag) {
                $q->where('blog_tags.id', $tag->id);
            })
            ->latest('published_at')
            ->paginate(12);

        // Sidebar data
        $featuredPosts = BlogPost::published()->featured()->limit(3)->get();
        $popularPosts = BlogPost::published()->orderByDesc('views')->limit(5)->get();
        $categories = BlogCategory::active()->withCount(['publishedPosts'])->get();
        $tags = BlogTag::has('posts')->withCount('posts')->get();

        return view('blog.tag', compact('posts', 'tag', 'featuredPosts', 'popularPosts', 'categories', 'tags'));
    }

    public function search(Request $request)
    {
        $search = $request->get('q', '');

        $posts = BlogPost::with(['author', 'category'])
            ->published()
            ->where(function($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('excerpt', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
            })
            ->latest('published_at')
            ->paginate(12);

        return view('blog.search', compact('posts', 'search'));
    }
}
