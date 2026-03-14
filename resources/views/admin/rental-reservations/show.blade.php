@extends('layouts.admin')

@section('title', 'Détails Réservation')
@section('page-title', 'Détails Réservation')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-3 mb-2">
                <h2 class="text-2xl font-bold text-neutral-900">Réservation {{ $reservation->reservation_number }}</h2>
                @switch($reservation->status)
                    @case('pending')
                        <span class="badge badge-warning">En Attente</span>
                        @break
                    @case('confirmed')
                        <span class="badge badge-success">Confirmée</span>
                        @break
                    @case('active')
                        <span class="badge badge-primary">En Cours</span>
                        @break
                    @case('completed')
                        <span class="badge badge-secondary">Terminée</span>
                        @break
                    @case('cancelled')
                        <span class="badge badge-danger">Annulée</span>
                        @break
                @endswitch
            </div>
            <p class="text-sm text-neutral-400">Créée le {{ $reservation->created_at->format('d/m/Y à H:i') }}</p>
        </div>
        <a href="{{ route('admin.rental-reservations.index') }}" class="btn-secondary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour à la liste
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Rental Item Details -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Article Loué</h3>
                </div>
                <div class="card-body">
                    <div class="flex items-start space-x-4">
                        @if ($reservation->rentalItem->main_image)
                            <img src="{{ asset('storage/' . $reservation->rentalItem->main_image) }}"
                                alt="{{ $reservation->rentalItem->name }}"
                                class="w-32 h-32 rounded-lg object-cover">
                        @else
                            <div class="w-32 h-32 bg-neutral-100 rounded-lg flex items-center justify-center">
                                <svg class="w-16 h-16 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h4 class="text-xl font-semibold text-neutral-900 mb-2">{{ $reservation->rentalItem->name }}</h4>
                            <p class="text-sm text-neutral-400 mb-4">SKU: {{ $reservation->rentalItem->sku }}</p>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-neutral-400">Quantité réservée</p>
                                    <p class="text-lg font-semibold text-neutral-900">{{ $reservation->quantity_reserved }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-neutral-400">Tarif appliqué</p>
                                    <p class="text-lg font-semibold text-neutral-900">
                                        @switch($reservation->rate_type)
                                            @case('daily')
                                                Journalier
                                                @break
                                            @case('weekly')
                                                Hebdomadaire
                                                @break
                                            @case('monthly')
                                                Mensuel
                                                @break
                                        @endswitch
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-neutral-400">Prix unitaire</p>
                                    <p class="text-lg font-semibold text-primary-500">{{ number_format($reservation->rate_applied, 0, ',', ' ') }} €</p>
                                </div>
                                <div>
                                    <p class="text-sm text-neutral-400">Durée</p>
                                    <p class="text-lg font-semibold text-neutral-900">{{ $reservation->duration_days }} jour(s)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rental Period -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Période de Location</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-neutral-400">Date de début</p>
                                <p class="text-lg font-semibold text-neutral-900">{{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }}</p>
                                <p class="text-xs text-neutral-400">{{ \Carbon\Carbon::parse($reservation->start_date)->locale('fr')->isoFormat('dddd') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-neutral-400">Date de fin</p>
                                <p class="text-lg font-semibold text-neutral-900">{{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}</p>
                                <p class="text-xs text-neutral-400">{{ \Carbon\Carbon::parse($reservation->end_date)->locale('fr')->isoFormat('dddd') }}</p>
                            </div>
                        </div>
                    </div>

                    @if ($reservation->actual_return_date)
                        <div class="mt-4 pt-4 border-t border-neutral-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-neutral-400">Date de retour effective</p>
                                    <p class="text-lg font-semibold text-neutral-900">{{ \Carbon\Carbon::parse($reservation->actual_return_date)->format('d/m/Y à H:i') }}</p>
                                </div>
                            </div>
                            @if ($reservation->return_notes)
                                <div class="mt-3 p-3 bg-neutral-50 rounded-lg">
                                    <p class="text-sm text-neutral-600"><strong>Notes de retour:</strong> {{ $reservation->return_notes }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Customer Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Informations Client</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-neutral-400 mb-1">Nom</p>
                            <p class="font-medium text-neutral-900">{{ $reservation->order->shipping_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-neutral-400 mb-1">Email</p>
                            <p class="font-medium text-neutral-900">{{ $reservation->order->shipping_email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-neutral-400 mb-1">Téléphone</p>
                            <p class="font-medium text-neutral-900">{{ $reservation->order->shipping_phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-neutral-400 mb-1">Ville</p>
                            <p class="font-medium text-neutral-900">{{ $reservation->order->shipping_city }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-neutral-400 mb-1">Adresse</p>
                            <p class="font-medium text-neutral-900">{{ $reservation->order->shipping_address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Pricing Summary -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Résumé Financier</h3>
                </div>
                <div class="card-body space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-neutral-600">Sous-total location</span>
                        <span class="font-semibold">{{ number_format($reservation->subtotal, 0, ',', ' ') }} €</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-neutral-600">Caution</span>
                        <span class="font-semibold text-amber-600">{{ number_format($reservation->deposit, 0, ',', ' ') }} €</span>
                    </div>
                    <div class="pt-3 border-t border-neutral-200">
                        <div class="flex justify-between">
                            <span class="font-bold text-neutral-900">Total</span>
                            <span class="text-xl font-bold text-primary-500">{{ number_format($reservation->subtotal + $reservation->deposit, 0, ',', ' ') }} €</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Commande Associée</h3>
                </div>
                <div class="card-body space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-neutral-600">N° Commande</span>
                        <span class="font-mono font-semibold">{{ $reservation->order->order_number }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-neutral-600">Statut Paiement</span>
                        <span class="badge {{ $reservation->order->isPaid() ? 'badge-success' : 'badge-warning' }}">
                            {{ $reservation->order->isPaid() ? 'Payé' : 'En attente' }}
                        </span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-neutral-600">Statut Commande</span>
                        <span class="capitalize">{{ $reservation->order->status }}</span>
                    </div>
                    <div class="pt-3 border-t border-neutral-200">
                        <a href="{{ route('admin.orders.show', $reservation->order) }}" class="btn-secondary w-full text-center">
                            Voir la commande
                        </a>
                    </div>
                </div>
            </div>

            <!-- Status Actions -->
            @if ($reservation->status !== 'cancelled' && $reservation->status !== 'completed')
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-neutral-900">Actions</h3>
                    </div>
                    <div class="card-body space-y-3">
                        @if ($reservation->status === 'confirmed')
                            <form action="{{ route('admin.rental-reservations.updateStatus', $reservation) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="active">
                                <button type="submit" class="btn-primary w-full">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Marquer comme En Cours
                                </button>
                            </form>
                        @endif

                        @if ($reservation->status === 'active')
                            <form action="{{ route('admin.rental-reservations.updateStatus', $reservation) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn-success w-full">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Marquer comme Terminée
                                </button>
                            </form>
                        @endif

                        @if (in_array($reservation->status, ['pending', 'confirmed']))
                            <form action="{{ route('admin.rental-reservations.updateStatus', $reservation) }}" method="POST"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn-danger w-full">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Annuler la Réservation
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Timeline -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Historique</h3>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 mt-2 rounded-full bg-neutral-300"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-neutral-900">Réservation créée</p>
                                <p class="text-xs text-neutral-400">{{ $reservation->created_at->format('d/m/Y à H:i') }}</p>
                            </div>
                        </div>
                        @if ($reservation->order->paid_at)
                            <div class="flex items-start space-x-3">
                                <div class="w-2 h-2 mt-2 rounded-full bg-green-500"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-neutral-900">Paiement confirmé</p>
                                    <p class="text-xs text-neutral-400">{{ $reservation->order->paid_at->format('d/m/Y à H:i') }}</p>
                                </div>
                            </div>
                        @endif
                        @if ($reservation->actual_return_date)
                            <div class="flex items-start space-x-3">
                                <div class="w-2 h-2 mt-2 rounded-full bg-blue-500"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-neutral-900">Article retourné</p>
                                    <p class="text-xs text-neutral-400">{{ \Carbon\Carbon::parse($reservation->actual_return_date)->format('d/m/Y à H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
