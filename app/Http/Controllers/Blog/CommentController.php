<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'blog_post_id' => 'required|exists:blog_posts,id',
            'parent_id' => 'nullable|exists:blog_comments,id',
            'content' => 'required|string|min:3|max:1000',
        ]);

        $post = BlogPost::findOrFail($validated['blog_post_id']);

        if (!$post->allow_comments) {
            return back()->with('error', 'Les commentaires sont désactivés pour cet article.');
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending'; // Always pending for moderation

        BlogComment::create($validated);

        return back()->with('success', 'Votre commentaire a été soumis et est en attente de modération.');
    }
}
