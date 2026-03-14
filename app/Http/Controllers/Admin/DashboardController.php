<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\SiteVisit;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCustomers = User::whereHas('role', function ($q) {
            $q->where('slug', 'customer');
        })->count();

        // Recent orders
        $recentOrders = Order::with(['user', 'items'])
            ->latest()
            ->take(10)
            ->get();

        // Low stock products
        $lowStockProducts = Product::lowStock()
            ->with('category')
            ->take(10)
            ->get();

        // Monthly revenue data for chart
        $monthlyRevenue = Order::where('payment_status', 'paid')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as revenue')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('revenue', 'month')
            ->toArray();

        // Fill missing months with 0
        $revenueData = [];
        for ($i = 1; $i <= 12; $i++) {
            $revenueData[] = $monthlyRevenue[$i] ?? 0;
        }

        // Order status distribution
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Top selling products
        $topProducts = Product::withCount(['orderItems as total_sold' => function ($q) {
            $q->select(DB::raw('SUM(quantity)'));
        }])
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        // Statistiques des visiteurs (NOUVEAU SYSTÈME - Tracking unique)
        $visitorStats = [
            'today' => [
                'unique_visitors' => SiteVisit::countUniqueVisitors('today'),
                'page_views' => SiteVisit::countPageViews('today'),
            ],
            'week' => [
                'unique_visitors' => SiteVisit::countUniqueVisitors('week'),
                'page_views' => SiteVisit::countPageViews('week'),
            ],
            'month' => [
                'unique_visitors' => SiteVisit::countUniqueVisitors('month'),
                'page_views' => SiteVisit::countPageViews('month'),
            ],
            'total' => [
                'unique_visitors' => SiteVisit::countUniqueVisitors(),
                'page_views' => SiteVisit::countPageViews(),
            ],
        ];

        // Calculer le taux d'engagement (pages par visiteur)
        if ($visitorStats['today']['unique_visitors'] > 0) {
            $visitorStats['today']['avg_pages'] = round(
                $visitorStats['today']['page_views'] / $visitorStats['today']['unique_visitors'],
                2
            );
        } else {
            $visitorStats['today']['avg_pages'] = 0;
        }

        // Visiteurs en direct (dernières 5 minutes)
        $liveVisitors = SiteVisit::where('visited_at', '>=', now()->subMinutes(5))->count();

        // Graphique des 30 derniers jours (visiteurs uniques vs pages vues)
        $dailyVisits = collect(range(0, 29))->map(function ($daysAgo) {
            $date = now()->subDays($daysAgo)->startOfDay();

            return [
                'date' => $date->format('Y-m-d'),
                'unique_visitors' => SiteVisit::whereDate('visited_at', $date)
                    ->where('is_unique_visit', true)
                    ->count(),
                'page_views' => SiteVisit::whereDate('visited_at', $date)
                    ->sum('page_views'),
            ];
        })->reverse()->values();

        // Top 5 pages les plus visitées (aujourd'hui)
        $topPages = SiteVisit::today()
            ->selectRaw('url, SUM(page_views) as total_views')
            ->groupBy('url')
            ->orderByDesc('total_views')
            ->limit(5)
            ->get();

        // Anciennes variables (pour compatibilité - à supprimer plus tard)
        $totalVisits = $visitorStats['total']['page_views'];
        $visitsToday = $visitorStats['today']['page_views'];
        $visitsThisWeek = $visitorStats['week']['page_views'];
        $visitsThisMonth = $visitorStats['month']['page_views'];
        $uniqueVisitors = $visitorStats['total']['unique_visitors'];
        $uniqueVisitorsToday = $visitorStats['today']['unique_visitors'];

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'totalProducts',
            'totalCustomers',
            'recentOrders',
            'lowStockProducts',
            'revenueData',
            'ordersByStatus',
            'topProducts',
            'visitorStats',
            'liveVisitors',
            'dailyVisits',
            'topPages',
            // Anciennes variables (pour compatibilité)
            'totalVisits',
            'visitsToday',
            'visitsThisWeek',
            'visitsThisMonth',
            'uniqueVisitors',
            'uniqueVisitorsToday'
        ));
    }

    /**
     * API pour récupérer les statistiques en direct (appelé par AJAX)
     */
    public function liveStats()
    {
        return response()->json([
            'live_visitors' => SiteVisit::where('visited_at', '>=', now()->subMinutes(5))->count(),
            'today_unique' => SiteVisit::countUniqueVisitors('today'),
            'today_views' => SiteVisit::countPageViews('today'),
            'today_avg_pages' => SiteVisit::countUniqueVisitors('today') > 0
                ? round(SiteVisit::countPageViews('today') / SiteVisit::countUniqueVisitors('today'), 2)
                : 0,
        ]);
    }
}
