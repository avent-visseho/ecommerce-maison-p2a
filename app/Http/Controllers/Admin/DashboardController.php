<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\SiteVisit;
use App\Models\User;
use Illuminate\Http\Request;
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

        // Statistiques des visiteurs
        $totalVisits = SiteVisit::count();
        $visitsToday = SiteVisit::today()->count();
        $visitsThisWeek = SiteVisit::thisWeek()->count();
        $visitsThisMonth = SiteVisit::thisMonth()->count();
        $uniqueVisitors = SiteVisit::distinct('ip_address')->count('ip_address');
        $uniqueVisitorsToday = SiteVisit::today()->distinct('ip_address')->count('ip_address');

        // Visites par jour pour le graphique (30 derniers jours)
        $dailyVisits = SiteVisit::select(
                DB::raw('DATE(visited_at) as date'),
                DB::raw('COUNT(*) as visits'),
                DB::raw('COUNT(DISTINCT ip_address) as unique_visits')
            )
            ->where('visited_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

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
            'totalVisits',
            'visitsToday',
            'visitsThisWeek',
            'visitsThisMonth',
            'uniqueVisitors',
            'uniqueVisitorsToday',
            'dailyVisits'
        ));
    }
}
