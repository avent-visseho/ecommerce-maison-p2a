@extends('layouts.admin')

@section('title', 'Produits')
@section('page-title', 'Gestion des Produits')

@section('content')
    <div class="space-y-6" x-data="{ showFilters: false }">
        <!-- Header Actions -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-neutral-900">Produits</h2>
                <p class="text-sm text-neutral-400 mt-1">Gérez votre catalogue de produits</p>
            </div>
            <div class="flex items-center gap-3">
                <button @click="showFilters = !showFilters" class="btn-secondary flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span>Filtres</span>
                </button>
                <a href="{{ route('admin.products.create') }}" class="btn-primary flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Nouveau Produit</span>
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-5 border border-neutral-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Total Produits</p>
                        <h3 class="text-2xl font-bold text-neutral-900">{{ \App\Models\Product::count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-neutral-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Actifs</p>
                        <h3 class="text-2xl font-bold text-green-600">{{ \App\Models\Product::active()->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-neutral-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Stock Bas</p>
                        <h3 class="text-2xl font-bold text-orange-600">{{ \App\Models\Product::lowStock()->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-neutral-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">En Promo</p>
                        <h3 class="text-2xl font-bold text-purple-600">
                            {{ \App\Models\Product::whereNotNull('sale_price')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
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
                <form method="GET" action="{{ route('admin.products.index') }}"
                    class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="label">Recherche</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, SKU..."
                            class="input-field">
                    </div>

                    <div>
                        <label class="label">Catégorie</label>
                        <select name="category" class="input-field">
                            <option value="">Toutes les catégories</option>
                            @foreach (\App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="label">Marque</label>
                        <select name="brand" class="input-field">
                            <option value="">Toutes les marques</option>
                            @foreach (\App\Models\Brand::all() as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="label">Statut</label>
                        <select name="status" class="input-field">
                            <option value="">Tous les statuts</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactif
                            </option>
                            <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>Stock bas
                            </option>
                        </select>
                    </div>

                    <div class="md:col-span-4 flex items-center gap-3">
                        <button type="submit" class="btn-primary">
                            <span>Appliquer les filtres</span>
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn-secondary">
                            <span>Réinitialiser</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Products Table -->
        <div class="card">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-20">
                                <input type="checkbox" class="rounded border-neutral-300 text-primary-500">
                            </th>
                            <th>Produit</th>
                            <th>Catégorie</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr class="group">
                                <td>
                                    <input type="checkbox" class="rounded border-neutral-300 text-primary-500">
                                </td>
                                <td>
                                    <div class="flex items-center space-x-3">
                                        @if ($product->main_image)
                                            <img src="{{ asset('storage/' . $product->main_image) }}"
                                                alt="{{ $product->name }}"
                                                class="w-12 h-12 rounded-lg object-cover ring-2 ring-neutral-100">
                                        @else
                                            <div
                                                class="w-12 h-12 bg-neutral-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-neutral-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <p
                                                class="font-semibold text-neutral-900 group-hover:text-primary-500 transition-colors">
                                                {{ $product->name }}
                                            </p>
                                            <p class="text-xs text-neutral-400">SKU: {{ $product->sku }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-primary">{{ $product->category->name }}</span>
                                </td>
                                <td>
                                    <div>
                                        @if ($product->sale_price)
                                            <p class="font-semibold text-green-600">
                                                {{ number_format($product->sale_price, 0, ',', ' ') }} FCFA</p>
                                            <p class="text-xs text-neutral-400 line-through">
                                                {{ number_format($product->price, 0, ',', ' ') }} FCFA</p>
                                        @else
                                            <p class="font-semibold text-neutral-900">
                                                {{ number_format($product->price, 0, ',', ' ') }} FCFA</p>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if ($product->stock <= 0)
                                        <span class="badge badge-danger">Rupture</span>
                                    @elseif($product->isLowStock())
                                        <span class="badge badge-warning">{{ $product->stock }} unités</span>
                                    @else
                                        <span class="badge badge-success">{{ $product->stock }} unités</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($product->is_active)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2"></span>
                                            Actif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <span class="w-1.5 h-1.5 bg-gray-500 rounded-full mr-2"></span>
                                            Inactif
                                        </span>
                                    @endif
                                </td>
                                <td class="text-sm text-neutral-400">
                                    {{ $product->created_at->format('d/m/Y') }}
                                </td>
                                <td>
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.products.edit', $product) }}"
                                            class="p-2 text-neutral-400 hover:text-primary-500 hover:bg-primary-50 rounded-lg transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-neutral-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
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
                                <td colspan="8" class="text-center py-12">
                                    <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-neutral-400 text-lg mb-2">Aucun produit trouvé</p>
                                    <p class="text-sm text-neutral-400">Commencez par ajouter votre premier produit</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($products->hasPages())
                <div class="px-6 py-4 border-t border-neutral-200">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
