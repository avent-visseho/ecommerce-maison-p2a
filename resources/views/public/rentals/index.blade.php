@extends('layouts.public')

@section('title', 'Location d\'Objets de Décoration')
@section('description', 'Louez des objets de décoration pour vos événements')

@section('content')
    <!-- Page Header -->
    <section class="bg-gradient-to-br from-primary-50 to-neutral-50 py-12 border-b border-neutral-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-neutral-900 mb-2">Location d'Objets</h1>
                    <p class="text-neutral-400">Découvrez {{ $rentalItems->total() }} objets disponibles à la location</p>
                </div>

                <!-- Breadcrumb -->
                <nav class="flex items-center space-x-2 text-sm text-neutral-400 mt-4 md:mt-0">
                    <a href="{{ route('home') }}" class="hover:text-neutral-900">Accueil</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-neutral-900 font-medium">Locations</span>
                </nav>
            </div>
        </div>
    </section>

    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-4 lg:gap-8">
                <!-- Filters Sidebar -->
                <aside class="hidden lg:block">
                    <div class="sticky top-24 space-y-6">
                        <!-- Search -->
                        <div class="card">
                            <div class="card-body">
                                <h3 class="text-lg font-semibold text-neutral-900 mb-4">Recherche</h3>
                                <form method="GET" action="{{ route('rentals.index') }}">
                                    <div class="relative">
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            placeholder="Rechercher..." class="input-field pl-10">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="card">
                            <div class="card-body">
                                <h3 class="text-lg font-semibold text-neutral-900 mb-4">Catégories</h3>
                                <div class="space-y-2">
                                    <a href="{{ route('rentals.index') }}"
                                        class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-neutral-50 transition-colors {{ !request('category') ? 'bg-primary-50 text-primary-500' : 'text-neutral-900' }}">
                                        <span class="text-sm font-medium">Toutes les catégories</span>
                                        <span class="badge badge-primary">{{ \App\Models\RentalItem::active()->count() }}</span>
                                    </a>
                                    @foreach ($categories as $category)
                                        <a href="{{ route('rentals.index', ['category' => $category->id]) }}"
                                            class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-neutral-50 transition-colors {{ request('category') == $category->id ? 'bg-primary-50 text-primary-500' : 'text-neutral-900' }}">
                                            <span class="text-sm font-medium">{{ $category->name }}</span>
                                            <span class="text-xs text-neutral-400">{{ $category->rentalItems()->count() }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="card">
                            <div class="card-body">
                                <h3 class="text-lg font-semibold text-neutral-900 mb-4">Tarif Journalier</h3>
                                <form method="GET" action="{{ route('rentals.index') }}" class="space-y-4">
                                    @if (request('category'))
                                        <input type="hidden" name="category" value="{{ request('category') }}">
                                    @endif
                                    @if (request('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif

                                    <div>
                                        <label class="label text-xs">Prix min (€/jour)</label>
                                        <input type="number" name="min_price" value="{{ request('min_price') }}"
                                            placeholder="0" class="input-field text-sm">
                                    </div>
                                    <div>
                                        <label class="label text-xs">Prix max (€/jour)</label>
                                        <input type="number" name="max_price" value="{{ request('max_price') }}"
                                            placeholder="1000" class="input-field text-sm">
                                    </div>
                                    <button type="submit" class="w-full btn-primary text-sm">
                                        Appliquer
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Reset Filters -->
                        @if (request()->hasAny(['category', 'min_price', 'max_price', 'search']))
                            <a href="{{ route('rentals.index') }}"
                                class="block text-center text-sm text-red-500 hover:text-red-600 font-medium">
                                Réinitialiser les filtres
                            </a>
                        @endif
                    </div>
                </aside>

                <!-- Items Grid -->
                <div class="lg:col-span-3">
                    <!-- Sorting & Results Count -->
                    <div class="flex items-center justify-between mb-6">
                        <p class="text-sm text-neutral-400">
                            {{ $rentalItems->total() }} objet(s) trouvé(s)
                        </p>
                        <form method="GET" action="{{ route('rentals.index') }}">
                            @if (request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if (request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            @if (request('min_price'))
                                <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                            @endif
                            @if (request('max_price'))
                                <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                            @endif

                            <select name="sort" onchange="this.form.submit()"
                                class="input-field text-sm py-2 pr-10">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Plus récents</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nom A-Z</option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nom Z-A</option>
                            </select>
                        </form>
                    </div>

                    <!-- Items Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($rentalItems as $item)
                            <a href="{{ route('rentals.show', $item->slug) }}"
                                class="group card hover:shadow-lg transition-all duration-300 overflow-hidden">
                                <!-- Image -->
                                <div class="relative h-64 overflow-hidden bg-neutral-100">
                                    @if ($item->main_image)
                                        <img src="{{ asset('storage/' . $item->main_image) }}" alt="{{ $item->name }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-20 h-20 text-neutral-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif

                                    @if ($item->quantity <= 2)
                                        <div class="absolute top-3 right-3">
                                            <span class="badge badge-warning">Stock limité</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="card-body">
                                    <p class="text-xs text-neutral-400 mb-1">{{ $item->rentalCategory->name }}</p>
                                    <h3 class="text-lg font-semibold text-neutral-900 mb-2 group-hover:text-primary-500 transition-colors">
                                        {{ $item->name }}
                                    </h3>

                                    @if ($item->description)
                                        <p class="text-sm text-neutral-400 mb-4 line-clamp-2">{{ $item->description }}</p>
                                    @endif

                                    <div class="flex items-center justify-between mt-auto">
                                        <div>
                                            <p class="text-2xl font-bold text-primary-500">{{ number_format($item->daily_rate, 0, ',', ' ') }} €</p>
                                            <p class="text-xs text-neutral-400">par jour</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm text-neutral-600">{{ $item->quantity }} dispo.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-full">
                                <div class="card">
                                    <div class="card-body text-center py-12">
                                        <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="text-neutral-400 text-lg mb-2">Aucun objet de location trouvé</p>
                                        <p class="text-sm text-neutral-400 mb-4">Essayez de modifier vos filtres</p>
                                        <a href="{{ route('rentals.index') }}" class="btn-primary inline-flex items-center">
                                            Voir tous les objets
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if ($rentalItems->hasPages())
                        <div class="mt-8 flex justify-center">
                            {{ $rentalItems->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
