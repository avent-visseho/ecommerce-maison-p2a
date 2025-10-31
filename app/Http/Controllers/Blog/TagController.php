<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogTag;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show($slug)
    {
        $tag = BlogTag::where('slug', $slug)->firstOrFail();

        $posts = $tag->publishedPosts()
            ->with(['author', 'category', 'tags'])
            ->latest('published_at')
            ->paginate(12);

        $popularPosts = BlogPost::published()->orderByDesc('views')->limit(5)->get();
        $categories = BlogCategory::active()->withCount(['publishedPosts'])->get();

        return view('blog.tag', compact('tag', 'posts', 'popularPosts', 'categories'));
    }
}
