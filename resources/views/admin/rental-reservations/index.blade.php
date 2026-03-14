@extends('layouts.admin')

@section('title', 'Réservations de Location')
@section('page-title', 'Réservations de Location')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-neutral-900">Réservations de Location</h2>
        <p class="text-sm text-neutral-400 mt-1">Gérez toutes les réservations d'articles de location</p>
    </div>

    <!-- Stats Cards -->
    <div class="flex flex-wrap gap-4 mb-6 justify-between">
        <div class="card flex-1 min-w-[180px]">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Total</p>
                        <p class="text-2xl font-bold text-neutral-900">{{ \App\Models\RentalReservation::count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-neutral-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="card flex-1 min-w-[180px]">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">En Attente</p>
                        <p class="text-2xl font-bold text-orange-600">{{ \App\Models\RentalReservation::where('status', 'pending')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="card flex-1 min-w-[180px]">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Confirmées</p>
                        <p class="text-2xl font-bold text-green-600">{{ \App\Models\RentalReservation::where('status', 'confirmed')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="card flex-1 min-w-[180px]">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">En Cours</p>
                        <p class="text-2xl font-bold text-blue-600">{{ \App\Models\RentalReservation::where('status', 'active')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="card flex-1 min-w-[180px]">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Terminées</p>
                        <p class="text-2xl font-bold text-purple-600">{{ \App\Models\RentalReservation::where('status', 'completed')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-6">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.rental-reservations.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="status" class="label">Statut</label>
                    <select id="status" name="status" class="input-field">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En Attente</option>
                        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmées</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>En Cours</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Terminées</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Annulées</option>
                    </select>
                </div>

                <div>
                    <label for="start_date" class="label">Date de début</label>
                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="input-field">
                </div>

                <div>
                    <label for="end_date" class="label">Date de fin</label>
                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="input-field">
                </div>

                <div class="flex items-end">
                    <button type="submit" class="btn-primary w-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filtrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reservations Table -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>N° Réservation</th>
                        <th>Article</th>
                        <th>Client</th>
                        <th>Dates</th>
                        <th>Durée</th>
                        <th>Quantité</th>
                        <th>Montant</th>
                        <th>Caution</th>
                        <th>Statut</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reservations as $reservation)
                        <tr>
                            <td>
                                <span class="font-mono text-sm font-medium text-neutral-900">{{ $reservation->reservation_number }}</span>
                            </td>
                            <td>
                                <div class="flex items-center space-x-3">
                                    @if ($reservation->rentalItem->main_image)
                                        <img src="{{ asset('storage/' . $reservation->rentalItem->main_image) }}"
                                            alt="{{ $reservation->rentalItem->name }}"
                                            class="w-12 h-12 rounded-lg object-cover">
                                    @else
                                        <div class="w-12 h-12 bg-neutral-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-neutral-900">{{ $reservation->rentalItem->name }}</p>
                                        <p class="text-sm text-neutral-400">{{ $reservation->rentalItem->sku }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <p class="font-medium text-neutral-900">{{ $reservation->order->shipping_name }}</p>
                                    <p class="text-sm text-neutral-400">{{ $reservation->order->shipping_email }}</p>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm">
                                    <p class="text-neutral-900">{{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }}</p>
                                    <p class="text-neutral-400">{{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}</p>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-secondary">{{ $reservation->duration_days }} jour(s)</span>
                            </td>
                            <td>
                                <span class="font-semibold text-neutral-900">{{ $reservation->quantity_reserved }}</span>
                            </td>
                            <td>
                                <span class="font-semibold text-primary-500">{{ number_format($reservation->subtotal, 0, ',', ' ') }} €</span>
                            </td>
                            <td>
                                <span class="text-amber-600 font-medium">{{ number_format($reservation->deposit, 0, ',', ' ') }} €</span>
                            </td>
                            <td>
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
                            </td>
                            <td>
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.rental-reservations.show', $reservation) }}"
                                        class="btn-icon btn-secondary" title="Voir les détails">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <td colspan="10" class="text-center py-12">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-neutral-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="text-neutral-400 mb-4">Aucune réservation trouvée</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($reservations->hasPages())
            <div class="card-footer">
                {{ $reservations->links() }}
            </div>
        @endif
    </div>
@endsection
