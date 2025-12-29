@extends('layouts.admin')

@section('title', 'Variantes - ' . $product->name)
@section('page-title', 'Gestion des Variantes')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.products.index') }}" class="text-neutral-400 hover:text-neutral-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-neutral-900">Variantes : {{ $product->name }}</h2>
                <p class="text-sm text-neutral-400 mt-1">SKU: {{ $product->sku }} | Stock produit: {{ $product->stock }}</p>
            </div>
            <a href="{{ route('admin.products.variants.create', $product) }}" class="btn-primary flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Nouvelle Variante</span>
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-5 border border-neutral-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Total Variantes</p>
                        <h3 class="text-2xl font-bold text-neutral-900">{{ $variants->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-neutral-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Actives</p>
                        <h3 class="text-2xl font-bold text-green-600">{{ $variants->where('is_active', true)->count() }}</h3>
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
                        <p class="text-sm text-neutral-400 mb-1">Stock Total</p>
                        <h3 class="text-2xl font-bold text-blue-600">{{ $variants->sum('stock') }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-neutral-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Stock Bas</p>
                        <h3 class="text-2xl font-bold text-orange-600">
                            {{ $variants->filter(fn($v) => $v->stock > 0 && $v->stock <= $v->low_stock_alert)->count() }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Variants Table -->
        <div class="card">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Image
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    SKU
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Attributs
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Prix
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Stock
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-neutral-200">
                            @forelse($variants as $variant)
                                <tr class="hover:bg-neutral-50 {{ $variant->is_default ? 'bg-primary-50/30' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($variant->image)
                                            <img src="{{ asset('storage/' . $variant->image) }}" alt="{{ $variant->display_name }}"
                                                class="w-16 h-16 object-cover rounded-lg border border-neutral-200">
                                        @elseif($product->main_image)
                                            <div class="w-16 h-16 rounded-lg border-2 border-dashed border-neutral-300 flex items-center justify-center bg-neutral-50">
                                                <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}"
                                                    class="w-full h-full object-cover rounded-lg opacity-50">
                                            </div>
                                        @else
                                            <div class="w-16 h-16 bg-neutral-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-8 h-8 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-mono text-neutral-900">{{ $variant->sku }}</span>
                                        @if($variant->is_default)
                                            <span class="ml-2 badge badge-primary">Par défaut</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($variant->attributeValues as $attributeValue)
                                                @if($attributeValue->attribute->type === 'color' && $attributeValue->color_hex)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-lg bg-neutral-50 text-xs">
                                                        <div class="w-3 h-3 rounded-full border border-neutral-300 mr-1"
                                                            style="background-color: {{ $attributeValue->color_hex }}"></div>
                                                        {{ $attributeValue->value }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-neutral">{{ $attributeValue->value }}</span>
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            @if($variant->sale_price)
                                                <div class="text-red-600 font-semibold">{{ number_format($variant->sale_price, 0, ',', ' ') }} €</div>
                                                <div class="text-neutral-400 line-through text-xs">{{ number_format($variant->price ?? $product->price, 0, ',', ' ') }} €</div>
                                            @elseif($variant->price)
                                                <div class="text-neutral-900 font-semibold">{{ number_format($variant->price, 0, ',', ' ') }} €</div>
                                            @else
                                                <div class="text-neutral-400 italic text-xs">Hérite du produit</div>
                                                <div class="text-neutral-600 text-xs">{{ number_format($product->effective_price, 0, ',', ' ') }} €</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            @if($variant->stock <= 0)
                                                <span class="badge badge-danger">Rupture ({{ $variant->stock }})</span>
                                            @elseif($variant->stock <= $variant->low_stock_alert)
                                                <span class="badge badge-warning">Stock bas ({{ $variant->stock }})</span>
                                            @else
                                                <span class="text-green-600 font-semibold">{{ $variant->stock }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($variant->is_active)
                                            <span class="badge badge-success">Actif</span>
                                        @else
                                            <span class="badge badge-danger">Inactif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('admin.products.variants.edit', [$product, $variant]) }}"
                                                class="text-primary-500 hover:text-primary-700">
                                                Modifier
                                            </a>
                                            @if(!$variant->is_default)
                                                <form action="{{ route('admin.products.variants.destroy', [$product, $variant]) }}" method="POST"
                                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette variante ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-neutral-300" title="La variante par défaut ne peut pas être supprimée">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                    </svg>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                        </svg>
                                        <p class="text-neutral-400 text-lg mb-2">Aucune variante trouvée</p>
                                        <p class="text-sm text-neutral-400 mb-4">Créez votre première variante pour ce produit</p>
                                        <a href="{{ route('admin.products.variants.create', $product) }}"
                                            class="btn-primary inline-flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Créer une variante
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($variants->isEmpty())
            <div class="card bg-blue-50 border-blue-200">
                <div class="card-body">
                    <div class="flex items-start space-x-3">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="flex-1">
                            <h4 class="text-lg font-semibold text-blue-900 mb-2">Besoin de créer des attributs d'abord ?</h4>
                            <p class="text-sm text-blue-700 mb-3">
                                Avant de créer des variantes, assurez-vous d'avoir défini vos attributs (Couleur, Taille, etc.) et leurs valeurs.
                            </p>
                            <a href="{{ route('admin.attributes.index') }}" class="btn-secondary inline-flex items-center text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Gérer les attributs
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
