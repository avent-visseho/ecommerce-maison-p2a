@extends('layouts.admin')

@section('title', 'Commandes')
@section('page-title', 'Gestion des Commandes')

@section('content')
    <div class="space-y-6" x-data="{ showFilters: false }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-neutral-900">Commandes</h2>
                <p class="text-sm text-neutral-400 mt-1">Suivez et gérez toutes les commandes</p>
            </div>
            <button @click="showFilters = !showFilters" class="btn-secondary flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <span>Filtres</span>
            </button>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-5 border border-neutral-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Total Commandes</p>
                        <h3 class="text-2xl font-bold text-neutral-900">{{ \App\Models\Order::count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-neutral-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">En Attente</p>
                        <h3 class="text-2xl font-bold text-orange-600">
                            {{ \App\Models\Order::where('status', 'pending')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-neutral-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">En Cours</p>
                        <h3 class="text-2xl font-bold text-blue-600">
                            {{ \App\Models\Order::where('status', 'processing')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-neutral-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Complétées</p>
                        <h3 class="text-2xl font-bold text-green-600">
                            {{ \App\Models\Order::where('status', 'completed')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Panel -->
        <div x-show="showFilters" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0" class="card" style="display: none;">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.orders.index') }}"
                    class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="label">Recherche</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="N° commande, client..." class="input-field">
                    </div>

                    <div>
                        <label class="label">Statut Commande</label>
                        <select name="status" class="input-field">
                            <option value="">Tous les statuts</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente
                            </option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>En cours
                            </option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Complété
                            </option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulé
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="label">Statut Paiement</label>
                        <select name="payment_status" class="input-field">
                            <option value="">Tous les paiements</option>
                            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>En
                                attente</option>
                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Payé
                            </option>
                            <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Échoué
                            </option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="btn-primary w-full">
                            Appliquer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="card">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Commande</th>
                            <th>Client</th>
                            <th>Produits</th>
                            <th>Montant</th>
                            <th>Paiement</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr class="group hover:bg-neutral-50">
                                <td>
                                    <div>
                                        <p class="font-semibold text-neutral-900">{{ $order->order_number }}</p>
                                        <p class="text-xs text-neutral-400">{{ $order->items->count() }} article(s)</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center">
                                            <span class="text-sm font-semibold text-primary-500">
                                                {{ substr($order->user->name, 0, 2) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-neutral-900">{{ $order->user->name }}</p>
                                            <p class="text-xs text-neutral-400">{{ $order->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex -space-x-2">
                                        @foreach ($order->items->take(3) as $item)
                                            @if ($item->product && $item->product->main_image)
                                                <img src="{{ asset('storage/' . $item->product->main_image) }}"
                                                    alt="{{ $item->product_name }}"
                                                    class="w-8 h-8 rounded-lg object-cover ring-2 ring-white"
                                                    title="{{ $item->product_name }}">
                                            @else
                                                <div class="w-8 h-8 rounded-lg bg-neutral-200 ring-2 ring-white"></div>
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
                                    <p class="font-semibold text-neutral-900">
                                        {{ number_format($order->total, 0, ',', ' ') }} €</p>
                                </td>
                                <td>
                                    @if ($order->payment_status === 'paid')
                                        <span class="badge badge-success">Payé</span>
                                    @elseif($order->payment_status === 'pending')
                                        <span class="badge badge-warning">En attente</span>
                                    @else
                                        <span class="badge badge-danger">Échoué</span>
                                    @endif
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
                                <td class="text-sm text-neutral-400">
                                    <div>
                                        <p>{{ $order->created_at->format('d/m/Y') }}</p>
                                        <p class="text-xs">{{ $order->created_at->format('H:i') }}</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                            class="p-2 text-neutral-400 hover:text-primary-500 hover:bg-primary-50 rounded-lg transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-12">
                                    <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-neutral-400 text-lg mb-2">Aucune commande trouvée</p>
                                    <p class="text-sm text-neutral-400">Les commandes apparaîtront ici</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($orders->hasPages())
                <div class="px-6 py-4 border-t border-neutral-200">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
