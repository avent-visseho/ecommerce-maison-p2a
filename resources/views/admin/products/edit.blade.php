@extends('layouts.admin')

@section('title', 'Modifier Produit')
@section('page-title', 'Modifier le Produit')

@section('content')
    <div class="max-w-5xl">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('admin.products.index') }}"
                class="inline-flex items-center text-sm text-neutral-400 hover:text-neutral-900">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
            <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium">
                    Supprimer ce produit
                </button>
            </form>
        </div>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Informations Générales</h3>
                </div>
                <div class="card-body space-y-5">
                    <div>
                        <label for="name" class="label">Nom du produit <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                            required class="input-field @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="label">Description courte</label>
                        <textarea id="description" name="description" rows="3"
                            class="input-field @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="long_description" class="label">Description détaillée</label>
                        <textarea id="long_description" name="long_description" rows="6"
                            class="input-field @error('long_description') border-red-500 @enderror">{{ old('long_description', $product->long_description) }}</textarea>
                        @error('long_description')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="category_id" class="label">Catégorie <span class="text-red-500">*</span></label>
                            <select id="category_id" name="category_id" required
                                class="input-field @error('category_id') border-red-500 @enderror">
                                <option value="">Sélectionner une catégorie</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="brand_id" class="label">Marque</label>
                            <select id="brand_id" name="brand_id"
                                class="input-field @error('brand_id') border-red-500 @enderror">
                                <option value="">Sélectionner une marque</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing & Stock -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Prix & Inventaire</h3>
                </div>
                <div class="card-body space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="price" class="label">Prix (FCFA) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="number" id="price" name="price"
                                    value="{{ old('price', $product->price) }}" required min="0" step="1"
                                    class="input-field @error('price') border-red-500 @enderror">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-neutral-400 text-sm">FCFA</span>
                                </div>
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sale_price" class="label">Prix Promo (FCFA)</label>
                            <div class="relative">
                                <input type="number" id="sale_price" name="sale_price"
                                    value="{{ old('sale_price', $product->sale_price) }}" min="0" step="1"
                                    class="input-field @error('sale_price') border-red-500 @enderror">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-neutral-400 text-sm">FCFA</span>
                                </div>
                            </div>
                            @error('sale_price')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label for="sku" class="label">SKU</label>
                            <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}"
                                class="input-field @error('sku') border-red-500 @enderror">
                            @error('sku')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stock" class="label">Stock <span class="text-red-500">*</span></label>
                            <input type="number" id="stock" name="stock"
                                value="{{ old('stock', $product->stock) }}" required min="0"
                                class="input-field @error('stock') border-red-500 @enderror">
                            @error('stock')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="low_stock_alert" class="label">Alerte Stock Bas <span
                                    class="text-red-500">*</span></label>
                            <input type="number" id="low_stock_alert" name="low_stock_alert"
                                value="{{ old('low_stock_alert', $product->low_stock_alert) }}" required min="0"
                                class="input-field @error('low_stock_alert') border-red-500 @enderror">
                            @error('low_stock_alert')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Images -->
            @if ($product->main_image || $product->images)
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-neutral-900">Images Actuelles</h3>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @if ($product->main_image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}"
                                        class="w-full h-32 object-cover rounded-lg">
                                    <div class="absolute top-2 right-2">
                                        <span class="badge badge-primary">Principale</span>
                                    </div>
                                </div>
                            @endif

                            @if ($product->images)
                                @foreach ($product->images as $image)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}"
                                            class="w-full h-32 object-cover rounded-lg">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Upload New Images -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Nouvelles Images</h3>
                </div>
                <div class="card-body space-y-5">
                    <div>
                        <label for="main_image" class="label">Nouvelle image principale</label>
                        <input type="file" id="main_image" name="main_image" accept="image/*"
                            class="input-field @error('main_image') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-neutral-400">Laissez vide pour conserver l'image actuelle</p>
                        @error('main_image')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="images" class="label">Nouvelles images de galerie</label>
                        <input type="file" id="images" name="images[]" accept="image/*" multiple
                            class="input-field @error('images') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-neutral-400">Remplacera toutes les images existantes de la galerie</p>
                        @error('images')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Options -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Options</h3>
                </div>
                <div class="card-body space-y-4">
                    <div class="flex items-center justify-between p-4 bg-neutral-50 rounded-lg">
                        <div>
                            <label for="is_active" class="text-sm font-medium text-neutral-900">Produit actif</label>
                            <p class="text-sm text-neutral-400">Le produit sera visible sur le site</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="is_active" name="is_active" value="1"
                                {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-500">
                            </div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-neutral-50 rounded-lg">
                        <div>
                            <label for="is_featured" class="text-sm font-medium text-neutral-900">Produit en
                                vedette</label>
                            <p class="text-sm text-neutral-400">Afficher sur la page d'accueil</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-500">
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('admin.products.index') }}" class="btn-secondary">
                    Annuler
                </a>
                <button type="submit" class="btn-primary">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
@endsection
