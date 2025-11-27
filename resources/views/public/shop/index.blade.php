@extends('layouts.public')

@section('title', 'Boutique')
@section('description', 'Explorez notre collection complète de produits de décoration d\'intérieur')

@section('content')
    <!-- Page Header -->
    <section class="bg-gradient-to-br from-primary-50 to-neutral-50 py-12 border-b border-neutral-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-neutral-900 mb-2">Notre Boutique</h1>
                    <p class="text-neutral-400">Découvrez {{ $products->total() }} produits exceptionnels</p>
                </div>

                <!-- Breadcrumb -->
                <nav class="flex items-center space-x-2 text-sm text-neutral-400 mt-4 md:mt-0">
                    <a href="{{ route('home') }}" class="hover:text-neutral-900">Accueil</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-neutral-900 font-medium">Boutique</span>
                </nav>
            </div>
        </div>
    </section>

    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-4 lg:gap-8" x-data="{ mobileFiltersOpen: false }">
                <!-- Filters Sidebar -->
                <aside class="hidden lg:block">
                    <div class="sticky top-24 space-y-6">
                        <!-- Search -->
                        <div class="card">
                            <div class="card-body">
                                <h3 class="text-lg font-semibold text-neutral-900 mb-4">Rechercher</h3>
                                <form method="GET" action="{{ route('shop.index') }}">
                                    <div class="relative">
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            placeholder="Rechercher un produit..." class="input-field pl-10">
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
                                    <a href="{{ route('shop.index') }}"
                                        class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-neutral-50 transition-colors {{ !request('category') ? 'bg-primary-50 text-primary-500' : 'text-neutral-900' }}">
                                        <span class="text-sm font-medium">Toutes les catégories</span>
                                        <span
                                            class="badge badge-primary">{{ \App\Models\Product::active()->count() }}</span>
                                    </a>
                                    @foreach ($categories as $category)
                                        <a href="{{ route('shop.index', ['category' => $category->id]) }}"
                                            class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-neutral-50 transition-colors {{ request('category') == $category->id ? 'bg-primary-50 text-primary-500' : 'text-neutral-900' }}">
                                            <span class="text-sm font-medium">{{ $category->name }}</span>
                                            <span
                                                class="text-xs text-neutral-400">{{ $category->products->count() }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Brands -->
                        <div class="card">
                            <div class="card-body">
                                <h3 class="text-lg font-semibold text-neutral-900 mb-4">Marques</h3>
                                <div class="space-y-2">
                                    @foreach ($brands as $brand)
                                        <label
                                            class="flex items-center px-3 py-2 rounded-lg hover:bg-neutral-50 transition-colors cursor-pointer">
                                            <input type="checkbox" value="{{ $brand->id }}"
                                                {{ request('brand') == $brand->id ? 'checked' : '' }}
                                                onchange="window.location.href='{{ route('shop.index', array_merge(request()->except('brand'), ['brand' => $brand->id])) }}'"
                                                class="rounded border-neutral-300 text-primary-500 focus:ring-primary-500">
                                            <span class="ml-3 text-sm text-neutral-900">{{ $brand->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="card">
                            <div class="card-body">
                                <h3 class="text-lg font-semibold text-neutral-900 mb-4">Prix</h3>
                                <form method="GET" action="{{ route('shop.index') }}" class="space-y-4">
                                    @if (request('category'))
                                        <input type="hidden" name="category" value="{{ request('category') }}">
                                    @endif
                                    @if (request('brand'))
                                        <input type="hidden" name="brand" value="{{ request('brand') }}">
                                    @endif
                                    @if (request('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif

                                    <div>
                                        <label class="label text-xs">Prix minimum</label>
                                        <input type="number" name="min_price" value="{{ request('min_price') }}"
                                            placeholder="0" class="input-field text-sm">
                                    </div>
                                    <div>
                                        <label class="label text-xs">Prix maximum</label>
                                        <input type="number" name="max_price" value="{{ request('max_price') }}"
                                            placeholder="1000000" class="input-field text-sm">
                                    </div>
                                    <button type="submit" class="w-full btn-primary text-sm">
                                        Appliquer
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Reset Filters -->
                        @if (request()->hasAny(['category', 'brand', 'min_price', 'max_price', 'search']))
                            <a href="{{ route('shop.index') }}"
                                class="block text-center text-sm text-red-500 hover:text-red-600 font-medium">
                                Réinitialiser les filtres
                            </a>
                        @endif
                    </div>
                </aside>

                <!-- Mobile Filter Button -->
                <div class="lg:hidden mb-6">
                    <button @click="mobileFiltersOpen = true"
                        class="w-full btn-secondary flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <span>Filtres</span>
                    </button>
                </div>

                <!-- Products Grid -->
                <div class="lg:col-span-3 space-y-6">
                    <!-- Toolbar -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <p class="text-sm text-neutral-400">
                            Affichage de <span
                                class="font-semibold text-neutral-900">{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</span>
                            sur <span class="font-semibold text-neutral-900">{{ $products->total() }}</span> produits
                        </p>

                        <form method="GET" action="{{ route('shop.index') }}" class="flex items-center space-x-2">
                            @foreach (request()->except('sort') as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach

                            <label class="text-sm text-neutral-400 whitespace-nowrap">Trier par:</label>
                            <select name="sort" onchange="this.form.submit()" class="input-field text-sm py-2">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Plus récents
                                </option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix
                                    croissant</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix
                                    décroissant</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nom A-Z
                                </option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nom Z-A
                                </option>
                            </select>
                        </form>
                    </div>

                    <!-- Products -->
                    @if ($products->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($products as $product)
                                <div
                                    class="group bg-white rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 border border-neutral-200">
                                    <div class="relative aspect-square overflow-hidden bg-neutral-50">
                                        @if ($product->main_image)
                                            <img src="{{ asset('storage/' . $product->main_image) }}"
                                                alt="{{ $product->name }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-16 h-16 text-neutral-300" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif

                                        @if ($product->isOnSale())
                                            <span
                                                class="absolute top-4 left-4 px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full">
                                                -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                            </span>
                                        @endif

                                        @if ($product->is_featured)
                                            <span
                                                class="absolute top-4 right-4 px-3 py-1 bg-primary-500 text-white text-xs font-bold rounded-full">
                                                ⭐ Vedette
                                            </span>
                                        @endif

                                        @if ($product->isOutOfStock())
                                            <div
                                                class="absolute inset-0 bg-neutral-900/80 flex items-center justify-center">
                                                <span
                                                    class="px-4 py-2 bg-white text-neutral-900 rounded-lg font-semibold">Rupture</span>
                                            </div>
                                        @endif

                                        <a href="{{ route('shop.show', $product->slug) }}"
                                            class="absolute inset-0 z-10"></a>

                                        <div
                                            class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity z-20">
                                            <button
                                                class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-primary-500 hover:text-white transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="p-5">
                                        <span
                                            class="text-xs text-primary-500 font-medium">{{ $product->category->name }}</span>
                                        <h3 class="font-semibold text-neutral-900 mt-2 mb-3 line-clamp-2">
                                            <a href="{{ route('shop.show', $product->slug) }}"
                                                class="hover:text-primary-500 transition-colors">
                                                {{ $product->name }}
                                            </a>
                                        </h3>

                                        @if ($product->brand)
                                            <p class="text-xs text-neutral-400 mb-3">{{ $product->brand->name }}</p>
                                        @endif

                                        <div class="flex items-center justify-between">
                                            <div>
                                                @if ($product->isOnSale())
                                                    <div class="flex items-center space-x-2">
                                                        <span
                                                            class="text-lg font-bold text-primary-500">{{ number_format($product->sale_price, 0, ',', ' ') }}
                                                            €</span>
                                                        <span
                                                            class="text-sm text-neutral-400 line-through">{{ number_format($product->price, 0, ',', ' ') }}</span>
                                                    </div>
                                                @else
                                                    <span
                                                        class="text-lg font-bold text-neutral-900">{{ number_format($product->price, 0, ',', ' ') }}
                                                        €</span>
                                                @endif
                                            </div>

                                            @if (!$product->isOutOfStock())
                                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="p-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if ($products->hasPages())
                            <div class="mt-8">
                                {{ $products->links() }}
                            </div>
                        @endif
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-20">
                            <svg class="w-24 h-24 mx-auto text-neutral-300 mb-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <h3 class="text-2xl font-bold text-neutral-900 mb-2">Aucun produit trouvé</h3>
                            <p class="text-neutral-400 mb-6">Essayez d'ajuster vos filtres pour trouver ce que vous
                                cherchez</p>
                            <a href="{{ route('shop.index') }}" class="btn-primary inline-flex items-center">
                                Voir tous les produits
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Mobile Filters Modal -->
    <div x-show="mobileFiltersOpen" class="fixed inset-0 z-50 lg:hidden" style="display: none;">
        <div class="fixed inset-0 bg-neutral-900/50" @click="mobileFiltersOpen = false"></div>
        <div class="fixed inset-y-0 right-0 max-w-sm w-full bg-white shadow-xl overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-neutral-900">Filtres</h2>
                    <button @click="mobileFiltersOpen = false" class="p-2 hover:bg-neutral-100 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Mobile filter content (same as sidebar) -->
                <div class="space-y-6">
                    <!-- Copy the filter sections from sidebar here -->
                </div>
            </div>
        </div>
    </div>
@endsection
