@extends('layouts.admin')

@section('title', 'Catégories')
@section('page-title', 'Gestion des Catégories')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-neutral-900">Catégories</h2>
                <p class="text-sm text-neutral-400 mt-1">Organisez vos produits par catégorie</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="btn-primary flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Nouvelle Catégorie</span>
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl p-5 border border-neutral-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Total Catégories</p>
                        <h3 class="text-2xl font-bold text-neutral-900">{{ \App\Models\Category::count() }}</h3>
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
                        <h3 class="text-2xl font-bold text-green-600">{{ \App\Models\Category::active()->count() }}</h3>
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
                        <p class="text-sm text-neutral-400 mb-1">Sous-catégories</p>
                        <h3 class="text-2xl font-bold text-blue-600">
                            {{ \App\Models\Category::whereNotNull('parent_id')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($categories as $category)
                <div class="card group hover:shadow-md transition-all duration-200">
                    <div class="card-body">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                @if ($category->image)
                                    <div class="w-16 h-16 rounded-xl overflow-hidden mb-4">
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                            class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-16 h-16 bg-primary-100 rounded-xl flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                @endif

                                <h3 class="text-lg font-bold text-neutral-900 mb-1">{{ $category->name }}</h3>

                                @if ($category->parent)
                                    <p class="text-sm text-neutral-400 mb-2">
                                        <span class="inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                            </svg>
                                            {{ $category->parent->name }}
                                        </span>
                                    </p>
                                @endif

                                @if ($category->description)
                                    <p class="text-sm text-neutral-400 line-clamp-2 mb-3">{{ $category->description }}</p>
                                @endif

                                <div class="flex items-center space-x-4 text-sm">
                                    <span class="flex items-center text-neutral-400">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                        {{ $category->products_count }} produits
                                    </span>
                                    @if ($category->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2 pt-4 border-t border-neutral-200">
                            <a href="{{ route('admin.categories.edit', $category) }}"
                                class="flex-1 btn-secondary text-center text-sm py-2">
                                Modifier
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');"
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
                            <p class="text-neutral-400 text-lg mb-2">Aucune catégorie trouvée</p>
                            <p class="text-sm text-neutral-400 mb-4">Commencez par créer votre première catégorie</p>
                            <a href="{{ route('admin.categories.create') }}"
                                class="btn-primary inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Créer une catégorie
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        @if ($categories->hasPages())
            <div class="flex justify-center">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
@endsection
