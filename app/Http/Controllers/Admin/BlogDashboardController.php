<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogNewsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogDashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $stats = [
            'total_posts' => BlogPost::count(),
            'published_posts' => BlogPost::published()->count(),
            'draft_posts' => BlogPost::draft()->count(),
            'scheduled_posts' => BlogPost::scheduled()->count(),
            'total_categories' => BlogCategory::count(),
            'total_comments' => BlogComment::count(),
            'pending_comments' => BlogComment::pending()->count(),
            'approved_comments' => BlogComment::approved()->count(),
            'newsletter_subscribers' => BlogNewsletter::active()->count(),
        ];

        // Recent posts
        $recentPosts = BlogPost::with('author')
            ->latest()
            ->limit(5)
            ->get();

        // Popular posts (by views)
        $popularPosts = BlogPost::published()
            ->orderByDesc('views')
            ->limit(5)
            ->get();

        // Recent comments
        $recentComments = BlogComment::with(['post', 'user'])
            ->latest()
            ->limit(5)
            ->get();

        // Posts per month (last 6 months)
        $postsPerMonth = BlogPost::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Comments per status
        $commentsByStatus = BlogComment::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        return view('admin.blog.dashboard', compact(
            'stats',
            'recentPosts',
            'popularPosts',
            'recentComments',
            'postsPerMonth',
            'commentsByStatus'
        ));
    }
}
