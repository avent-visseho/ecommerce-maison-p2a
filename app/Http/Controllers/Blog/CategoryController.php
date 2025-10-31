<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = BlogCategory::where('slug', $slug)->active()->firstOrFail();

        $posts = BlogPost::with(['author', 'category', 'tags'])
            ->where('blog_category_id', $category->id)
            ->published()
            ->latest('published_at')
            ->paginate(12);

        $popularPosts = BlogPost::published()->orderByDesc('views')->limit(5)->get();
        $categories = BlogCategory::active()->withCount(['publishedPosts'])->get();

        return view('blog.category', compact('category', 'posts', 'popularPosts', 'categories'));
    }
}
