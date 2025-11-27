@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')

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

        <!-- Visitor Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Visits -->
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-400 mb-1">Total Visites</p>
                        <h3 class="text-2xl font-bold text-neutral-900">{{ number_format($totalVisits, 0, ',', ' ') }}</h3>
                        <p class="text-sm text-primary-600 mt-2 flex items-center">
                            <span>{{ number_format($uniqueVisitors, 0, ',', ' ') }} uniques</span>
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Visits Today -->
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-400 mb-1">Visites Aujourd'hui</p>
                        <h3 class="text-2xl font-bold text-neutral-900">{{ number_format($visitsToday, 0, ',', ' ') }}</h3>
                        <p class="text-sm text-indigo-600 mt-2 flex items-center">
                            <span>{{ number_format($uniqueVisitorsToday, 0, ',', ' ') }} uniques</span>
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Visits This Week -->
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-400 mb-1">Visites Cette Semaine</p>
                        <h3 class="text-2xl font-bold text-neutral-900">{{ number_format($visitsThisWeek, 0, ',', ' ') }}</h3>
                        <p class="text-sm text-teal-600 mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            <span>Hebdomadaire</span>
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-teal-100 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Visits This Month -->
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-400 mb-1">Visites Ce Mois</p>
                        <h3 class="text-2xl font-bold text-neutral-900">{{ number_format($visitsThisMonth, 0, ',', ' ') }}</h3>
                        <p class="text-sm text-pink-600 mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            <span>Mensuel</span>
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-pink-100 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
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
        </script>
    @endpush
@endsection
