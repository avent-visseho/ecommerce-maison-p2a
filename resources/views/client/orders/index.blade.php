@extends('layouts.client')

@section('title', 'Mes Commandes')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="card">
            <div class="card-body">
                <h1 class="text-2xl font-bold text-neutral-900 mb-2">Mes Commandes</h1>
                <p class="text-neutral-400">Suivez l'état de toutes vos commandes</p>
            </div>
        </div>

        <!-- Orders List -->
        @if ($orders->count() > 0)
            <div class="space-y-4">
                @foreach ($orders as $order)
                    <div class="card hover:shadow-lg transition-all duration-200">
                        <div class="card-body">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                                <!-- Order Info -->
                                <div class="flex-1">
                                    <div class="flex items-start justify-between mb-4">
                                        <div>
                                            <h3 class="text-lg font-semibold text-neutral-900 mb-1">
                                                Commande {{ $order->order_number }}
                                            </h3>
                                            <p class="text-sm text-neutral-400">
                                                Passée le {{ $order->created_at->format('d/m/Y à H:i') }}
                                            </p>
                                        </div>
                                        <div class="flex flex-col items-end space-y-2">
                                            @if ($order->status === 'pending')
                                                <span class="badge badge-warning">En attente</span>
                                            @elseif($order->status === 'processing')
                                                <span class="badge badge-info">En cours</span>
                                            @elseif($order->status === 'completed')
                                                <span class="badge badge-success">Complété</span>
                                            @else
                                                <span class="badge badge-danger">Annulé</span>
                                            @endif

                                            @if ($order->payment_status === 'paid')
                                                <span class="badge badge-success">Payé</span>
                                            @elseif($order->payment_status === 'pending')
                                                <span class="badge badge-warning">Paiement en attente</span>
                                            @else
                                                <span class="badge badge-danger">Paiement échoué</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Products Preview -->
                                    <div class="flex items-center space-x-4 mb-4">
                                        <div class="flex -space-x-3">
                                            @foreach ($order->items->take(4) as $item)
                                                @if ($item->product && $item->product->main_image)
                                                    <div class="w-12 h-12 rounded-lg overflow-hidden ring-2 ring-white">
                                                        <img src="{{ asset('storage/' . $item->product->main_image) }}"
                                                            alt="{{ $item->product_name }}"
                                                            class="w-full h-full object-cover"
                                                            title="{{ $item->product_name }}">
                                                    </div>
                                                @else
                                                    <div
                                                        class="w-12 h-12 rounded-lg bg-neutral-100 ring-2 ring-white flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-neutral-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            @endforeach
                                            @if ($order->items->count() > 4)
                                                <div
                                                    class="w-12 h-12 rounded-lg bg-primary-100 ring-2 ring-white flex items-center justify-center">
                                                    <span
                                                        class="text-xs font-semibold text-primary-500">+{{ $order->items->count() - 4 }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <p class="text-sm text-neutral-600">
                                            {{ $order->items->count() }} article{{ $order->items->count() > 1 ? 's' : '' }}
                                        </p>
                                    </div>

                                    <!-- Order Summary -->
                                    <div class="flex items-center space-x-6 text-sm">
                                        <div class="flex items-center text-neutral-600">
                                            <svg class="w-4 h-4 mr-2 text-neutral-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span>{{ $order->shipping_city }}</span>
                                        </div>
                                        <div class="flex items-center font-semibold text-neutral-900">
                                            <svg class="w-4 h-4 mr-2 text-neutral-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>{{ number_format($order->total, 0, ',', ' ') }} €</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex flex-col space-y-2 lg:w-auto w-full">
                                    <a href="{{ route('client.orders.show', $order) }}"
                                        class="btn-primary text-center whitespace-nowrap">
                                        Voir les détails
                                    </a>
                                    @if ($order->status === 'completed')
                                        <button class="btn-secondary text-center whitespace-nowrap">
                                            Télécharger facture
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            @if ($order->status !== 'cancelled')
                                <div class="mt-6 pt-6 border-t border-neutral-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center space-x-2">
                                            <div
                                                class="w-2 h-2 rounded-full {{ $order->status === 'pending' ? 'bg-orange-500 animate-pulse' : 'bg-green-500' }}">
                                            </div>
                                            <span class="text-sm font-medium text-neutral-900">
                                                @if ($order->status === 'pending')
                                                    Commande en attente de traitement
                                                @elseif($order->status === 'processing')
                                                    Commande en préparation
                                                @else
                                                    Commande livrée
                                                @endif
                                            </span>
                                        </div>
                                        @if ($order->status === 'processing')
                                            <span class="text-xs text-neutral-400">Livraison estimée: 2-5 jours</span>
                                        @endif
                                    </div>
                                    <div class="w-full bg-neutral-200 rounded-full h-2">
                                        <div class="bg-primary-500 h-2 rounded-full transition-all duration-500"
                                            style="width: {{ $order->status === 'pending' ? '33%' : ($order->status === 'processing' ? '66%' : '100%') }}">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($orders->hasPages())
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="card">
                <div class="card-body text-center py-16">
                    <div class="w-24 h-24 bg-neutral-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-neutral-900 mb-2">Aucune commande</h3>
                    <p class="text-neutral-400 mb-6 max-w-md mx-auto">
                        Vous n'avez pas encore passé de commande. Découvrez notre collection de produits.
                    </p>
                    <a href="{{ route('shop.index') }}" class="btn-primary inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Découvrir la boutique
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
