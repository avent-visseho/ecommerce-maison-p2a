<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalOrders = $user->orders()->count();
        $pendingOrders = $user->orders()->pending()->count();
        $completedOrders = $user->orders()->completed()->count();
        $totalSpent = $user->orders()->paid()->sum('total');

        $recentOrders = $user->orders()
            ->with('items')
            ->latest()
            ->take(5)
            ->get();

        return view('client.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalSpent',
            'recentOrders'
        ));
    }
}
