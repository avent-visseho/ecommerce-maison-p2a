@extends('layouts.admin')

@section('title', 'Articles de Location')
@section('page-title', 'Articles de Location')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-neutral-900">Articles de Location</h2>
            <p class="text-sm text-neutral-400 mt-1">Gérez vos articles disponibles à la location</p>
        </div>
        <a href="{{ route('admin.rental-items.create') }}" class="btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nouvel Article
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="card">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Total Articles</p>
                        <p class="text-2xl font-bold text-neutral-900">{{ \App\Models\RentalItem::count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Actifs</p>
                        <p class="text-2xl font-bold text-green-600">{{ \App\Models\RentalItem::active()->count() }}</p>
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

        <div class="card">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">En Vedette</p>
                        <p class="text-2xl font-bold text-purple-600">{{ \App\Models\RentalItem::where('is_featured', true)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Catégories</p>
                        <p class="text-2xl font-bold text-blue-600">{{ \App\Models\RentalCategory::count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rental Items Table -->
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <h3 class="text-lg font-semibold text-neutral-900">Liste des Articles</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Article</th>
                        <th>Catégorie</th>
                        <th>Tarif Journalier</th>
                        <th>Tarif Hebdo</th>
                        <th>Tarif Mensuel</th>
                        <th>Caution</th>
                        <th>Quantité</th>
                        <th>Statut</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rentalItems as $item)
                        <tr>
                            <td>
                                <div class="flex items-center space-x-3">
                                    @if ($item->main_image)
                                        <img src="{{ asset('storage/' . $item->main_image) }}" alt="{{ $item->name }}"
                                            class="w-12 h-12 rounded-lg object-cover">
                                    @else
                                        <div class="w-12 h-12 bg-neutral-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-neutral-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-neutral-900">{{ $item->name }}</p>
                                        <p class="text-sm text-neutral-400">{{ $item->sku }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-secondary">{{ $item->rentalCategory->name }}</span>
                            </td>
                            <td>
                                <span class="font-semibold text-primary-500">{{ number_format($item->daily_rate, 0, ',', ' ') }} €</span>
                            </td>
                            <td>
                                @if ($item->weekly_rate)
                                    <span class="text-neutral-600">{{ number_format($item->weekly_rate, 0, ',', ' ') }} €</span>
                                @else
                                    <span class="text-neutral-400">-</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->monthly_rate)
                                    <span class="text-neutral-600">{{ number_format($item->monthly_rate, 0, ',', ' ') }} €</span>
                                @else
                                    <span class="text-neutral-400">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-amber-600 font-medium">{{ number_format($item->deposit_amount, 0, ',', ' ') }} €</span>
                            </td>
                            <td>
                                <span class="badge {{ $item->quantity > 0 ? 'badge-success' : 'badge-danger' }}">
                                    {{ $item->quantity }}
                                </span>
                            </td>
                            <td>
                                @if ($item->is_active)
                                    <span class="badge badge-success">Actif</span>
                                @else
                                    <span class="badge badge-danger">Inactif</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.rental-items.edit', $item) }}"
                                        class="btn-icon btn-secondary" title="Modifier">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.rental-items.destroy', $item) }}" method="POST"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-danger" title="Supprimer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-12">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-neutral-300 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-neutral-400 mb-4">Aucun article de location trouvé</p>
                                    <a href="{{ route('admin.rental-items.create') }}" class="btn-primary">
                                        Créer votre premier article
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($rentalItems->hasPages())
            <div class="card-footer">
                {{ $rentalItems->links() }}
            </div>
        @endif
    </div>
@endsection
