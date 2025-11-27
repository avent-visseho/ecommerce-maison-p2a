@extends('layouts.client')

@section('title', 'Commande #' . $order->order_number)

@section('content')
    <div class="space-y-6">
        <!-- Back Button -->
        <a href="{{ route('client.orders.index') }}"
            class="inline-flex items-center text-sm text-neutral-400 hover:text-neutral-900">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour à mes commandes
        </a>

        <!-- Order Header -->
        <div class="card">
            <div class="card-body">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-neutral-900 mb-2">Commande {{ $order->order_number }}</h1>
                        <p class="text-neutral-400">Passée le {{ $order->created_at->format('d F Y à H:i') }}</p>
                    </div>
                    <div class="flex flex-col items-start md:items-end space-y-2">
                        @if ($order->status === 'pending')
                            <span class="badge badge-warning text-base">En attente</span>
                        @elseif($order->status === 'processing')
                            <span class="badge badge-info text-base">En cours</span>
                        @elseif($order->status === 'completed')
                            <span class="badge badge-success text-base">Complété</span>
                        @else
                            <span class="badge badge-danger text-base">Annulé</span>
                        @endif

                        @if ($order->payment_status === 'paid')
                            <span class="badge badge-success">Payé</span>
                        @elseif($order->payment_status === 'pending')
                            <span class="badge badge-warning">Paiement en attente</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Progress -->
        @if ($order->status !== 'cancelled')
            <div class="card">
                <div class="card-body">
                    <h3 class="font-semibold text-neutral-900 mb-6">Suivi de commande</h3>
                    <div class="relative">
                        <div class="absolute top-5 left-0 right-0 h-0.5 bg-neutral-200">
                            <div class="h-full bg-primary-500 transition-all duration-500"
                                style="width: {{ $order->status === 'pending' ? '0%' : ($order->status === 'processing' ? '50%' : '100%') }}">
                            </div>
                        </div>
                        <div class="relative flex justify-between">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center text-white mb-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <p class="text-xs font-medium text-neutral-900">Confirmée</p>
                                <p class="text-xs text-neutral-400">{{ $order->created_at->format('d/m') }}</p>
                            </div>
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-10 h-10 rounded-full {{ $order->status === 'processing' || $order->status === 'completed' ? 'bg-primary-500' : 'bg-neutral-200' }} flex items-center justify-center text-white mb-2">
                                    @if ($order->status === 'processing' || $order->status === 'completed')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    @endif
                                </div>
                                <p class="text-xs font-medium text-neutral-900">En préparation</p>
                                @if ($order->status === 'processing' || $order->status === 'completed')
                                    <p class="text-xs text-neutral-400">En cours</p>
                                @endif
                            </div>
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-10 h-10 rounded-full {{ $order->status === 'completed' ? 'bg-primary-500' : 'bg-neutral-200' }} flex items-center justify-center text-white mb-2">
                                    @if ($order->status === 'completed')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    @endif
                                </div>
                                <p class="text-xs font-medium text-neutral-900">Livrée</p>
                                @if ($order->completed_at)
                                    <p class="text-xs text-neutral-400">{{ $order->completed_at->format('d/m') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Order Items -->
            <div class="lg:col-span-2 space-y-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-neutral-900">Articles commandés</h3>
                    </div>
                    <div class="divide-y divide-neutral-200">
                        @foreach ($order->items as $item)
                            <div class="p-6 hover:bg-neutral-50 transition-colors">
                                <div class="flex items-start space-x-4">
                                    <div class="w-20 h-20 flex-shrink-0 bg-neutral-100 rounded-xl overflow-hidden">
                                        @if ($item->product && $item->product->main_image)
                                            <img src="{{ asset('storage/' . $item->product->main_image) }}"
                                                alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-neutral-300" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-neutral-900 mb-1">{{ $item->product_name }}</h4>
                                        <p class="text-sm text-neutral-400 mb-2">SKU: {{ $item->product_sku }}</p>
                                        <div class="flex items-center space-x-4 text-sm">
                                            <span class="text-neutral-600">Quantité: <span
                                                    class="font-semibold">{{ $item->quantity }}</span></span>
                                            <span class="text-neutral-600">Prix: <span
                                                    class="font-semibold">{{ number_format($item->price, 0, ',', ' ') }}
                                                    €</span></span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-neutral-900">
                                            {{ number_format($item->subtotal, 0, ',', ' ') }} €</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-neutral-900">Adresse de livraison</h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-2">
                            <p class="font-semibold text-neutral-900">{{ $order->shipping_name }}</p>
                            <p class="text-neutral-600">{{ $order->shipping_address }}</p>
                            <p class="text-neutral-600">{{ $order->shipping_city }}</p>
                            <div class="pt-2 space-y-1">
                                <p class="text-sm text-neutral-600">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $order->shipping_email }}
                                </p>
                                <p class="text-sm text-neutral-600">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $order->shipping_phone }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="space-y-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-neutral-900">Résumé</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="flex justify-between text-neutral-600">
                            <span>Sous-total</span>
                            <span class="font-semibold">{{ number_format($order->subtotal, 0, ',', ' ') }} €</span>
                        </div>
                        <div class="flex justify-between text-neutral-600">
                            <span>Livraison</span>
                            <span class="font-semibold">{{ number_format($order->shipping, 0, ',', ' ') }} €</span>
                        </div>
                        @if ($order->tax > 0)
                            <div class="flex justify-between text-neutral-600">
                                <span>Taxes</span>
                                <span class="font-semibold">{{ number_format($order->tax, 0, ',', ' ') }} €</span>
                            </div>
                        @endif
                        <div class="pt-4 border-t border-neutral-200">
                            <div class="flex justify-between text-xl font-bold">
                                <span class="text-neutral-900">Total</span>
                                <span class="text-primary-500">{{ number_format($order->total, 0, ',', ' ') }} €</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-neutral-900">Paiement</h3>
                    </div>
                    <div class="card-body space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-neutral-600">Méthode</span>
                            <span
                                class="font-semibold text-neutral-900 capitalize">{{ $order->payment_method ?? 'FedaPay' }}</span>
                        </div>
                        @if ($order->transaction_id)
                            <div class="flex justify-between text-sm">
                                <span class="text-neutral-600">Transaction</span>
                                <span class="font-mono text-xs text-neutral-900">{{ $order->transaction_id }}</span>
                            </div>
                        @endif
                        @if ($order->paid_at)
                            <div class="flex justify-between text-sm">
                                <span class="text-neutral-600">Payé le</span>
                                <span
                                    class="font-semibold text-neutral-900">{{ $order->paid_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                @if ($order->status === 'completed')
                    <button class="w-full btn-primary flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Télécharger la facture</span>
                    </button>
                @endif

                <a href="{{ route('shop.index') }}" class="w-full btn-secondary text-center">
                    Continuer mes achats
                </a>
            </div>
        </div>
    </div>
@endsection
