<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogComment::with(['post', 'user']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $comments = $query->latest()->paginate(20);

        return view('admin.blog.comments.index', compact('comments'));
    }

    public function approve($id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->update(['status' => 'approved']);

        return back()->with('success', 'Commentaire approuvé avec succès.');
    }

    public function reject($id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->update(['status' => 'spam']);

        return back()->with('success', 'Commentaire marqué comme spam.');
    }

    public function destroy($id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->delete();

        return back()->with('success', 'Commentaire supprimé avec succès.');
    }
}
