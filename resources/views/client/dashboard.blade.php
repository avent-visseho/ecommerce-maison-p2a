@extends('layouts.client')

@section('title', 'Mon Tableau de Bord')

@section('content')
    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="card">
            <div class="card-body">
                <h1 class="text-2xl font-bold text-neutral-900 mb-2">Bienvenue, {{ auth()->user()->name }} !</h1>
                <p class="text-neutral-400">Gérez vos commandes et votre profil depuis votre espace personnel</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="stat-card">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-neutral-400 mb-1">Total Commandes</p>
                <h3 class="text-3xl font-bold text-neutral-900">{{ $totalOrders }}</h3>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-neutral-400 mb-1">En Attente</p>
                <h3 class="text-3xl font-bold text-neutral-900">{{ $pendingOrders }}</h3>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-neutral-400 mb-1">Complétées</p>
                <h3 class="text-3xl font-bold text-neutral-900">{{ $completedOrders }}</h3>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-neutral-400 mb-1">Total Dépensé</p>
                <h3 class="text-2xl font-bold text-neutral-900">{{ number_format($totalSpent, 0, ',', ' ') }} €</h3>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h2 class="text-xl font-semibold text-neutral-900">Commandes Récentes</h2>
                <a href="{{ route('client.orders.index') }}"
                    class="text-sm text-primary-500 hover:text-primary-600 font-medium">
                    Voir tout
                </a>
            </div>
            <div class="overflow-x-auto">
                @if ($recentOrders->count() > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>N° Commande</th>
                                <th>Date</th>
                                <th>Articles</th>
                                <th>Total</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentOrders as $order)
                                <tr>
                                    <td>
                                        <span
                                            class="font-mono text-sm font-semibold text-neutral-900">{{ $order->order_number }}</span>
                                    </td>
                                    <td class="text-sm text-neutral-600">
                                        {{ $order->created_at->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <div class="flex -space-x-2">
                                            @foreach ($order->items->take(3) as $item)
                                                @if ($item->product && $item->product->main_image)
                                                    <img src="{{ asset('storage/' . $item->product->main_image) }}"
                                                        alt="{{ $item->product_name }}"
                                                        class="w-8 h-8 rounded-lg object-cover ring-2 ring-white"
                                                        title="{{ $item->product_name }}">
                                                @endif
                                            @endforeach
                                            @if ($order->items->count() > 3)
                                                <div
                                                    class="w-8 h-8 rounded-lg bg-primary-100 ring-2 ring-white flex items-center justify-center">
                                                    <span
                                                        class="text-xs font-semibold text-primary-500">+{{ $order->items->count() - 3 }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="font-semibold text-neutral-900">{{ number_format($order->total, 0, ',', ' ') }}
                                            €</span>
                                    </td>
                                    <td>
                                        @if ($order->status === 'pending')
                                            <span class="badge badge-warning">En attente</span>
                                        @elseif($order->status === 'processing')
                                            <span class="badge badge-info">En cours</span>
                                        @elseif($order->status === 'completed')
                                            <span class="badge badge-success">Complété</span>
                                        @else
                                            <span class="badge badge-danger">Annulé</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('client.orders.show', $order) }}"
                                            class="text-primary-500 hover:text-primary-600 font-medium text-sm">
                                            Voir détails
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <p class="text-neutral-400 mb-4">Vous n'avez pas encore passé de commande</p>
                        <a href="{{ route('shop.index') }}" class="btn-primary inline-flex items-center">
                            Découvrir la boutique
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('shop.index') }}" class="card group hover:shadow-lg transition-all">
                <div class="card-body text-center">
                    <div
                        class="w-16 h-16 bg-primary-50 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-500 transition-colors">
                        <svg class="w-8 h-8 text-primary-500 group-hover:text-white transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-neutral-900 mb-2">Continuer mes achats</h3>
                    <p class="text-sm text-neutral-400">Découvrez notre collection</p>
                </div>
            </a>

            <a href="{{ route('client.orders.index') }}" class="card group hover:shadow-lg transition-all">
                <div class="card-body text-center">
                    <div
                        class="w-16 h-16 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-500 transition-colors">
                        <svg class="w-8 h-8 text-blue-500 group-hover:text-white transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-neutral-900 mb-2">Mes commandes</h3>
                    <p class="text-sm text-neutral-400">Suivre mes achats</p>
                </div>
            </a>

            <a href="{{ route('client.profile.edit') }}" class="card group hover:shadow-lg transition-all">
                <div class="card-body text-center">
                    <div
                        class="w-16 h-16 bg-green-50 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-green-500 transition-colors">
                        <svg class="w-8 h-8 text-green-500 group-hover:text-white transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-neutral-900 mb-2">Mon profil</h3>
                    <p class="text-sm text-neutral-400">Gérer mes informations</p>
                </div>
            </a>
        </div>
    </div>
@endsection
