<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'blog_post_id' => 'required|exists:blog_posts,id',
            'parent_id' => 'nullable|exists:blog_comments,id',
            'content' => 'required|string|min:3|max:1000',
        ]);

        $post = BlogPost::findOrFail($validated['blog_post_id']);

        if (!$post->allow_comments) {
            return back()->with('error', __('messages.comment.disabled'));
        }

        // Validation supplémentaire pour les réponses
        if (!empty($validated['parent_id'])) {
            $parentComment = BlogComment::findOrFail($validated['parent_id']);

            // Vérifier que le parent appartient au même article
            if ($parentComment->blog_post_id != $validated['blog_post_id']) {
                return back()->with('error', __('messages.comment.invalid_parent'));
            }

            // Empêcher les réponses de réponses (max 1 niveau d'imbrication)
            if ($parentComment->parent_id !== null) {
                return back()->with('error', __('messages.comment.no_nested_reply'));
            }
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending'; // Always pending for moderation

        BlogComment::create($validated);

        return back()->with('success', __('messages.comment.submitted'));
    }
}
