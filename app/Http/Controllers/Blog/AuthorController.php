<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function show($id)
    {
        $author = User::findOrFail($id);

        $posts = BlogPost::with(['author', 'category', 'tags'])
            ->where('author_id', $author->id)
            ->published()
            ->latest('published_at')
            ->paginate(12);

        $popularPosts = BlogPost::published()->orderByDesc('views')->limit(5)->get();
        $categories = BlogCategory::active()->withCount(['publishedPosts'])->get();

        return view('blog.author', compact('author', 'posts', 'popularPosts', 'categories'));
    }
}
