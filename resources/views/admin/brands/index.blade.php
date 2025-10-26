@extends('layouts.admin')

@section('title', 'Marques')
@section('page-title', 'Gestion des Marques')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-neutral-900">Marques</h2>
                <p class="text-sm text-neutral-400 mt-1">Gérez les marques de vos produits</p>
            </div>
            <a href="{{ route('admin.brands.create') }}" class="btn-primary flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Nouvelle Marque</span>
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl p-5 border border-neutral-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Total Marques</p>
                        <h3 class="text-2xl font-bold text-neutral-900">{{ \App\Models\Brand::count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-neutral-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Actives</p>
                        <h3 class="text-2xl font-bold text-green-600">{{ \App\Models\Brand::active()->count() }}</h3>
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
                        <p class="text-sm text-neutral-400 mb-1">Avec Produits</p>
                        <h3 class="text-2xl font-bold text-blue-600">
                            {{ \App\Models\Brand::has('products')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Brands Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($brands as $brand)
                <div class="card group hover:shadow-md transition-all duration-200">
                    <div class="card-body">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                @if ($brand->logo)
                                    <div
                                        class="w-20 h-20 rounded-xl overflow-hidden mb-4 bg-white border border-neutral-200 flex items-center justify-center p-2">
                                        <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}"
                                            class="max-w-full max-h-full object-contain">
                                    </div>
                                @else
                                    <div
                                        class="w-20 h-20 bg-gradient-to-br from-primary-100 to-primary-200 rounded-xl flex items-center justify-center mb-4">
                                        <span
                                            class="text-2xl font-bold text-primary-600">{{ substr($brand->name, 0, 1) }}</span>
                                    </div>
                                @endif

                                <h3 class="text-lg font-bold text-neutral-900 mb-1">{{ $brand->name }}</h3>

                                @if ($brand->website)
                                    <a href="{{ $brand->website }}" target="_blank"
                                        class="text-sm text-primary-500 hover:text-primary-600 inline-flex items-center mb-2">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        Visiter le site
                                    </a>
                                @endif

                                @if ($brand->description)
                                    <p class="text-sm text-neutral-400 line-clamp-2 mb-3">{{ $brand->description }}</p>
                                @endif

                                <div class="flex items-center space-x-4 text-sm">
                                    <span class="flex items-center text-neutral-400">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                        {{ $brand->products_count }} produit{{ $brand->products_count > 1 ? 's' : '' }}
                                    </span>
                                    @if ($brand->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2 pt-4 border-t border-neutral-200">
                            <a href="{{ route('admin.brands.edit', $brand) }}"
                                class="flex-1 btn-secondary text-center text-sm py-2">
                                Modifier
                            </a>
                            <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette marque ?');"
                                class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full px-4 py-2 text-sm text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="card">
                        <div class="card-body text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            <p class="text-neutral-400 text-lg mb-2">Aucune marque trouvée</p>
                            <p class="text-sm text-neutral-400 mb-4">Commencez par créer votre première marque</p>
                            <a href="{{ route('admin.brands.create') }}" class="btn-primary inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Créer une marque
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        @if ($brands->hasPages())
            <div class="flex justify-center">
                {{ $brands->links() }}
            </div>
        @endif
    </div>
@endsection
