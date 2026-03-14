@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')

@push('styles')
    <style>
        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .animate-modal {
            animation: modalSlideIn 0.3s ease-out;
        }

        #visitorModal {
            transition: opacity 0.3s ease-out;
        }

        #visitorModal.hidden {
            opacity: 0;
            pointer-events: none;
        }
    </style>
@endpush

@section('content')
    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Revenue -->
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-400 mb-1">Revenus Total</p>
                        <h3 class="text-2xl font-bold text-neutral-900">{{ number_format($totalRevenue, 0, ',', ' ') }} €
                        </h3>
                        <p class="text-sm text-green-600 mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            <span>+12.5%</span>
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-400 mb-1">Commandes</p>
                        <h3 class="text-2xl font-bold text-neutral-900">{{ $totalOrders }}</h3>
                        <p class="text-sm text-blue-600 mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            <span>+8.2%</span>
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Products -->
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-400 mb-1">Produits</p>
                        <h3 class="text-2xl font-bold text-neutral-900">{{ $totalProducts }}</h3>
                        <p class="text-sm text-purple-600 mt-2 flex items-center">
                            <span>{{ \App\Models\Product::active()->count() }} actifs</span>
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Customers -->
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-400 mb-1">Clients</p>
                        <h3 class="text-2xl font-bold text-neutral-900">{{ $totalCustomers }}</h3>
                        <p class="text-sm text-orange-600 mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            <span>+15.3%</span>
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visitor Stats - Simplified (2 cartes seulement) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Visiteurs Aujourd'hui -->
            <div class="stat-card lg:col-span-2">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <p class="text-sm font-medium text-neutral-400">Visiteurs Aujourd'hui</p>
                            <button onclick="openVisitorModal()"
                                class="text-xs text-primary-600 hover:text-primary-700 font-medium flex items-center gap-1 transition-colors">
                                <span>Voir plus</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                        <h3 class="text-3xl font-bold text-neutral-900 mb-2">
                            {{ number_format($visitorStats['today']['unique_visitors'], 0, ',', ' ') }}
                        </h3>
                        <div class="flex items-center gap-4 text-sm">
                            <span class="text-indigo-600 font-medium">
                                {{ number_format($visitorStats['today']['page_views'], 0, ',', ' ') }} pages vues
                            </span>
                            <span class="text-neutral-400">•</span>
                            <span class="text-green-600 font-medium">
                                {{ $visitorStats['today']['avg_pages'] }} pages/visiteur
                            </span>
                        </div>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-indigo-50 rounded-2xl flex items-center justify-center ml-4">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- En Direct -->
            <div class="stat-card lg:col-span-2">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <p class="text-sm font-medium text-neutral-400">En Direct</p>
                            <div class="flex items-center gap-1">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                </span>
                            </div>
                        </div>
                        <h3 class="text-3xl font-bold text-neutral-900 mb-2" id="live-visitors">
                            {{ $liveVisitors }}
                        </h3>
                        <p class="text-sm text-red-600 font-medium">Actifs maintenant</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-red-100 to-red-50 rounded-2xl flex items-center justify-center ml-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Statistiques Détaillées -->
        <div id="visitorModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-6xl w-full max-h-[90vh] overflow-hidden animate-modal">
                <!-- Header -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-5 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Statistiques Détaillées des Visiteurs</h3>
                            <p class="text-indigo-100 text-sm">Analyse complète du trafic de votre site</p>
                        </div>
                    </div>
                    <button onclick="closeVisitorModal()" class="text-white hover:bg-white/10 p-2 rounded-lg transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-6 overflow-y-auto max-h-[calc(90vh-80px)]">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <!-- Cette Semaine -->
                        <div class="bg-gradient-to-br from-teal-50 to-teal-100/50 rounded-xl p-5 border border-teal-200">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-teal-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-neutral-700">Cette Semaine</h4>
                            </div>
                            <p class="text-3xl font-bold text-neutral-900 mb-1">
                                {{ number_format($visitorStats['week']['unique_visitors'], 0, ',', ' ') }}
                            </p>
                            <p class="text-sm text-teal-700">
                                {{ number_format($visitorStats['week']['page_views'], 0, ',', ' ') }} pages vues
                            </p>
                        </div>

                        <!-- Ce Mois -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100/50 rounded-xl p-5 border border-purple-200">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-neutral-700">Ce Mois</h4>
                            </div>
                            <p class="text-3xl font-bold text-neutral-900 mb-1">
                                {{ number_format($visitorStats['month']['unique_visitors'], 0, ',', ' ') }}
                            </p>
                            <p class="text-sm text-purple-700">
                                {{ number_format($visitorStats['month']['page_views'], 0, ',', ' ') }} pages vues
                            </p>
                        </div>

                        <!-- Total -->
                        <div class="bg-gradient-to-br from-orange-50 to-orange-100/50 rounded-xl p-5 border border-orange-200">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-neutral-700">Total</h4>
                            </div>
                            <p class="text-3xl font-bold text-neutral-900 mb-1">
                                {{ number_format($visitorStats['total']['unique_visitors'], 0, ',', ' ') }}
                            </p>
                            <p class="text-sm text-orange-700">
                                {{ number_format($visitorStats['total']['page_views'], 0, ',', ' ') }} pages vues
                            </p>
                        </div>
                    </div>

                    <!-- Graph -->
                    <div class="bg-white rounded-xl border border-neutral-200 p-6 mb-6">
                        <h4 class="font-semibold text-neutral-900 mb-4">Évolution sur 30 jours</h4>
                        <div style="height: 300px; position: relative;">
                            <canvas id="modalVisitorChart"></canvas>
                        </div>
                    </div>

                    <!-- Top Pages -->
                    <div class="bg-white rounded-xl border border-neutral-200 p-6">
                        <h4 class="font-semibold text-neutral-900 mb-4">Top 5 Pages Visitées Aujourd'hui</h4>
                        @forelse($topPages as $index => $page)
                            <div class="flex items-center gap-3 py-3 border-b border-neutral-100 last:border-0">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-sm">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-neutral-900 truncate">{{ $page->url }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-lg font-bold text-neutral-900">{{ number_format($page->total_views, 0, ',', ' ') }}</span>
                                    <span class="text-xs text-neutral-500">vues</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-neutral-400 py-8">
                                <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p>Aucune page visitée aujourd'hui</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Revenue Chart -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Revenus Mensuels ({{ date('Y') }})</h3>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="280"></canvas>
                </div>
            </div>

            <!-- Order Status Chart -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Statut des Commandes</h3>
                </div>
                <div class="card-body">
                    <canvas id="orderStatusChart" height="280"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Orders & Low Stock -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Orders -->
            <div class="card">
                <div class="card-header flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-neutral-900">Commandes Récentes</h3>
                    <a href="{{ route('admin.orders.index') }}"
                        class="text-sm text-primary-500 hover:text-primary-600 font-medium">
                        Voir tout
                    </a>
                </div>
                <div class="divide-y divide-neutral-200">
                    @forelse($recentOrders as $order)
                        <div class="p-6 hover:bg-neutral-50 transition-colors">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-neutral-900">{{ $order->order_number }}</p>
                                        <p class="text-sm text-neutral-400">{{ $order->user->name }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-neutral-900">
                                        {{ number_format($order->total, 0, ',', ' ') }} €</p>
                                    @if ($order->status === 'pending')
                                        <span class="badge badge-warning">En attente</span>
                                    @elseif($order->status === 'processing')
                                        <span class="badge badge-info">En cours</span>
                                    @elseif($order->status === 'completed')
                                        <span class="badge badge-success">Complété</span>
                                    @endif
                                </div>
                            </div>
                            <p class="text-xs text-neutral-400">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <div class="p-6 text-center text-neutral-400">
                            <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <p>Aucune commande récente</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Low Stock Products -->
            <div class="card">
                <div class="card-header flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-neutral-900">Produits en Rupture</h3>
                    <span class="badge badge-danger">{{ $lowStockProducts->count() }}</span>
                </div>
                <div class="divide-y divide-neutral-200">
                    @forelse($lowStockProducts as $product)
                        <div class="p-6 hover:bg-neutral-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    @if ($product->main_image)
                                        <img src="{{ asset('storage/' . $product->main_image) }}"
                                            alt="{{ $product->name }}" class="w-12 h-12 rounded-lg object-cover">
                                    @else
                                        <div class="w-12 h-12 bg-neutral-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-neutral-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-neutral-900">{{ $product->name }}</p>
                                        <p class="text-sm text-neutral-400">{{ $product->category->name }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="badge badge-danger">{{ $product->stock }} restants</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-neutral-400">
                            <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p>Tous les produits sont en stock</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                    datasets: [{
                        label: 'Revenus',
                        data: @json($revenueData),
                        borderColor: '#2725a9',
                        backgroundColor: 'rgba(39, 37, 169, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#2725a9',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString() + ' €';
                                }
                            },
                            grid: {
                                color: '#f4f5f7'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Order Status Chart
            const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
            new Chart(orderStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['En attente', 'En cours', 'Complété', 'Annulé'],
                    datasets: [{
                        data: [
                            {{ $ordersByStatus['pending'] ?? 0 }},
                            {{ $ordersByStatus['processing'] ?? 0 }},
                            {{ $ordersByStatus['completed'] ?? 0 }},
                            {{ $ordersByStatus['cancelled'] ?? 0 }}
                        ],
                        backgroundColor: ['#f59e0b', '#3b82f6', '#10b981', '#ef4444'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });

            // Modal Functions
            let modalChart = null;

            function openVisitorModal() {
                document.getElementById('visitorModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                // Créer le graphique du modal si pas déjà créé
                if (!modalChart) {
                    const ctx = document.getElementById('modalVisitorChart').getContext('2d');
                    modalChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: @json($dailyVisits->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d/m'))),
                            datasets: [
                                {
                                    label: 'Visiteurs Uniques',
                                    data: @json($dailyVisits->pluck('unique_visitors')),
                                    borderColor: '#6366f1',
                                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                                    tension: 0.4,
                                    fill: true,
                                    pointBackgroundColor: '#6366f1',
                                    pointBorderColor: '#fff',
                                    pointBorderWidth: 2,
                                    pointRadius: 3,
                                    pointHoverRadius: 5
                                },
                                {
                                    label: 'Pages Vues',
                                    data: @json($dailyVisits->pluck('page_views')),
                                    borderColor: '#14b8a6',
                                    backgroundColor: 'rgba(20, 184, 166, 0.1)',
                                    tension: 0.4,
                                    fill: false,
                                    pointBackgroundColor: '#14b8a6',
                                    pointBorderColor: '#fff',
                                    pointBorderWidth: 2,
                                    pointRadius: 3,
                                    pointHoverRadius: 5
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 15,
                                        usePointStyle: true
                                    }
                                },
                                tooltip: {
                                    mode: 'index',
                                    intersect: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: '#f4f5f7'
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                }
            }

            function closeVisitorModal() {
                document.getElementById('visitorModal').classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            // Fermer le modal en cliquant à l'extérieur
            document.getElementById('visitorModal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeVisitorModal();
                }
            });

            // Fermer le modal avec la touche ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeVisitorModal();
                }
            });

            // Rafraîchir les visiteurs en direct toutes les 30 secondes
            setInterval(async () => {
                try {
                    const response = await fetch('/admin/api/live-stats');
                    if (response.ok) {
                        const data = await response.json();
                        document.getElementById('live-visitors').textContent = data.live_visitors;
                    }
                } catch (error) {
                    console.error('Erreur lors du rafraîchissement des stats:', error);
                }
            }, 30000); // 30 secondes
        </script>
    @endpush
@endsection
