@extends('layouts.admin')

@section('title', 'Détails Commande')
@section('page-title', 'Commande #' . $order->order_number)

@section('content')
    <div class="max-w-6xl space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.orders.index') }}"
                class="inline-flex items-center text-sm text-neutral-400 hover:text-neutral-900">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour aux commandes
            </a>
            <div class="flex items-center space-x-3">
                <button onclick="window.print()" class="btn-secondary flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    <span>Imprimer</span>
                </button>
            </div>
        </div>

        <!-- Order Info Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Order Status Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Statut de la Commande</h3>
                </div>
                <div class="card-body space-y-4">
                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <label class="label">Statut</label>
                        <select name="status" class="input-field mb-3" onchange="this.form.submit()">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>En attente</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>En cours
                            </option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Complété
                            </option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Annulé</option>
                        </select>
                    </form>

                    <div class="pt-4 border-t border-neutral-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-neutral-400">Créé le</span>
                            <span
                                class="text-sm font-medium text-neutral-900">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if ($order->paid_at)
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-neutral-400">Payé le</span>
                                <span
                                    class="text-sm font-medium text-neutral-900">{{ $order->paid_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                        @if ($order->completed_at)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-neutral-400">Complété le</span>
                                <span
                                    class="text-sm font-medium text-neutral-900">{{ $order->completed_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Payment Status Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Statut de Paiement</h3>
                </div>
                <div class="card-body space-y-4">
                    <form action="{{ route('admin.orders.updatePaymentStatus', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <label class="label">Paiement</label>
                        <select name="payment_status" class="input-field mb-3" onchange="this.form.submit()">
                            <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>En attente
                            </option>
                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Payé</option>
                            <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Échoué
                            </option>
                            <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>
                                Remboursé</option>
                        </select>
                    </form>

                    <div class="pt-4 border-t border-neutral-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-neutral-400">Méthode</span>
                            <span
                                class="text-sm font-medium text-neutral-900 capitalize">{{ $order->payment_method ?? 'N/A' }}</span>
                        </div>
                        @if ($order->transaction_id)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-neutral-400">Transaction ID</span>
                                <span class="text-xs font-mono text-neutral-900">{{ $order->transaction_id }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Customer Info Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Informations Client</h3>
                </div>
                <div class="card-body">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center">
                            <span
                                class="text-lg font-semibold text-primary-500">{{ substr($order->user->name, 0, 2) }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-neutral-900">{{ $order->user->name }}</p>
                            <p class="text-sm text-neutral-400">{{ $order->user->email }}</p>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-neutral-200 space-y-2">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-neutral-400 mr-3 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-neutral-900">{{ $order->shipping_phone }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-neutral-400 mr-3 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-neutral-900">{{ $order->shipping_address }}</p>
                                <p class="text-sm text-neutral-400">{{ $order->shipping_city }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-neutral-900">Articles Commandés</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>SKU</th>
                            <th>Prix Unitaire</th>
                            <th>Quantité</th>
                            <th class="text-right">Sous-total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>
                                    <div class="flex items-center space-x-3">
                                        @if ($item->product && $item->product->main_image)
                                            <img src="{{ asset('storage/' . $item->product->main_image) }}"
                                                alt="{{ $item->product_name }}"
                                                class="w-12 h-12 rounded-lg object-cover">
                                        @else
                                            <div class="w-12 h-12 bg-neutral-200 rounded-lg"></div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-neutral-900">{{ $item->product_name }}</p>
                                            @if ($item->product)
                                                <a href="{{ route('admin.products.edit', $item->product) }}"
                                                    class="text-xs text-primary-500 hover:text-primary-600">
                                                    Voir le produit
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-sm font-mono text-neutral-400">{{ $item->product_sku }}</span>
                                </td>
                                <td>
                                    <span
                                        class="font-medium text-neutral-900">{{ number_format($item->price, 0, ',', ' ') }}
                                        €</span>
                                </td>
                                <td>
                                    <span class="badge badge-primary">x{{ $item->quantity }}</span>
                                </td>
                                <td class="text-right">
                                    <span
                                        class="font-semibold text-neutral-900">{{ number_format($item->subtotal, 0, ',', ' ') }}
                                        €</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Order Total -->
            <div class="px-6 py-4 border-t border-neutral-200">
                <div class="flex justify-end">
                    <div class="w-full max-w-sm space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-neutral-400">Sous-total</span>
                            <span class="font-medium text-neutral-900">{{ number_format($order->subtotal, 0, ',', ' ') }}
                                €</span>
                        </div>
                        @if ($order->tax > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-neutral-400">Taxes</span>
                                <span class="font-medium text-neutral-900">{{ number_format($order->tax, 0, ',', ' ') }}
                                    €</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-sm">
                            <span class="text-neutral-400">Livraison</span>
                            <span class="font-medium text-neutral-900">{{ number_format($order->shipping, 0, ',', ' ') }}
                                €</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold pt-2 border-t border-neutral-200">
                            <span class="text-neutral-900">Total</span>
                            <span class="text-primary-500">{{ number_format($order->total, 0, ',', ' ') }} €</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes -->
        @if ($order->notes)
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Notes de la Commande</h3>
                </div>
                <div class="card-body">
                    <div class="bg-neutral-50 rounded-lg p-4">
                        <p class="text-sm text-neutral-900">{{ $order->notes }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
