@extends('layouts.admin')

@section('title', 'Nouveau Produit')
@section('page-title', 'Créer un Produit')

@section('content')
    <div class="max-w-5xl">
        <div class="mb-6">
            <a href="{{ route('admin.products.index') }}"
                class="inline-flex items-center text-sm text-neutral-400 hover:text-neutral-900">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Informations Générales</h3>
                </div>
                <div class="card-body space-y-5">
                    <!-- Name -->
                    <div>
                        <label for="name" class="label">Nom du produit <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="input-field @error('name') border-red-500 @enderror"
                            placeholder="Ex: Canapé Scandinave 3 places">
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="label">Description courte</label>
                        <textarea id="description" name="description" rows="3"
                            class="input-field @error('description') border-red-500 @enderror" placeholder="Description brève du produit">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Long Description -->
                    <div>
                        <label for="long_description" class="label">Description détaillée</label>
                        <textarea id="long_description" name="long_description" rows="6"
                            class="input-field @error('long_description') border-red-500 @enderror"
                            placeholder="Description complète avec caractéristiques et détails">{{ old('long_description') }}</textarea>
                        @error('long_description')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category & Brand -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="category_id" class="label">Catégorie <span class="text-red-500">*</span></label>
                            <select id="category_id" name="category_id" required
                                class="input-field @error('category_id') border-red-500 @enderror">
                                <option value="">Sélectionner une catégorie</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                        {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
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
                        <!-- Price -->
                        <div>
                            <label for="price" class="label">Prix (€) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="number" id="price" name="price" value="{{ old('price') }}" required
                                    min="0" step="1"
                                    class="input-field @error('price') border-red-500 @enderror" placeholder="0">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-neutral-400 text-sm">€</span>
                                </div>
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sale Price -->
                        <div>
                            <label for="sale_price" class="label">Prix Promo (€)</label>
                            <div class="relative">
                                <input type="number" id="sale_price" name="sale_price" value="{{ old('sale_price') }}"
                                    min="0" step="1"
                                    class="input-field @error('sale_price') border-red-500 @enderror" placeholder="0">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-neutral-400 text-sm">€</span>
                                </div>
                            </div>
                            @error('sale_price')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <!-- SKU -->
                        <div>
                            <label for="sku" class="label">SKU</label>
                            <input type="text" id="sku" name="sku" value="{{ old('sku') }}"
                                class="input-field @error('sku') border-red-500 @enderror"
                                placeholder="Auto-généré si vide">
                            @error('sku')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock -->
                        <div>
                            <label for="stock" class="label">Stock <span class="text-red-500">*</span></label>
                            <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}" required
                                min="0" class="input-field @error('stock') border-red-500 @enderror"
                                placeholder="0">
                            @error('stock')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Low Stock Alert -->
                        <div>
                            <label for="low_stock_alert" class="label">Alerte Stock Bas <span
                                    class="text-red-500">*</span></label>
                            <input type="number" id="low_stock_alert" name="low_stock_alert"
                                value="{{ old('low_stock_alert', 10) }}" required min="0"
                                class="input-field @error('low_stock_alert') border-red-500 @enderror" placeholder="10">
                            @error('low_stock_alert')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Images -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Images</h3>
                </div>
                <div class="card-body space-y-5">
                    <!-- Main Image -->
                    <div>
                        <label for="main_image" class="label">Image principale</label>
                        <div id="mainImagePreviewContainer"
                            class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-neutral-200 border-dashed rounded-xl hover:border-primary-500 transition-colors">
                            <div class="space-y-2 text-center">
                                <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <div class="flex text-sm text-neutral-400">
                                    <label for="main_image"
                                        class="relative cursor-pointer rounded-md font-medium text-primary-500 hover:text-primary-600">
                                        <span>Télécharger un fichier</span>
                                        <input id="main_image" name="main_image" type="file" class="sr-only"
                                            accept="image/*">
                                    </label>
                                    <p class="pl-1">ou glisser-déposer</p>
                                </div>
                                <p class="text-xs text-neutral-400">PNG, JPG, WEBP jusqu'à 2MB</p>
                            </div>
                        </div>
                        @error('main_image')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Additional Images -->
                    <div>
                        <label for="images" class="label">Images supplémentaires (Galerie)</label>
                        <div
                            class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-neutral-200 border-dashed rounded-xl hover:border-primary-500 transition-colors">
                            <div class="space-y-2 text-center">
                                <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <div class="flex text-sm text-neutral-400">
                                    <label for="images"
                                        class="relative cursor-pointer rounded-md font-medium text-primary-500 hover:text-primary-600">
                                        <span>Télécharger des fichiers</span>
                                        <input id="images" name="images[]" type="file" class="sr-only"
                                            accept="image/*" multiple>
                                    </label>
                                    <p class="pl-1">ou glisser-déposer</p>
                                </div>
                                <p class="text-xs text-neutral-400">Plusieurs images PNG, JPG, WEBP jusqu'à 2MB chacune</p>
                            </div>
                        </div>
                        <div id="galleryPreviewContainer" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 hidden"></div>
                        @error('images')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            @push('scripts')
                <script>
                    // Preview main image
                    document.getElementById('main_image').addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        const container = document.getElementById('mainImagePreviewContainer');

                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                container.innerHTML = `
                                    <div class="relative">
                                        <img src="${e.target.result}" class="max-h-64 rounded-lg" alt="Preview">
                                        <button type="button" onclick="clearMainImage()"
                                            class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-2 hover:bg-red-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                `;
                            };
                            reader.readAsDataURL(file);
                        }
                    });

                    // Preview gallery images
                    document.getElementById('images').addEventListener('change', function(e) {
                        const files = e.target.files;
                        const container = document.getElementById('galleryPreviewContainer');
                        container.innerHTML = '';

                        if (files.length > 0) {
                            container.classList.remove('hidden');
                            Array.from(files).forEach((file, index) => {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    const div = document.createElement('div');
                                    div.className = 'relative group';
                                    div.innerHTML = `
                                        <img src="${e.target.result}" class="h-32 w-full object-cover rounded-lg" alt="Preview ${index + 1}">
                                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                            <span class="text-white text-sm font-medium">Image ${index + 1}</span>
                                        </div>
                                    `;
                                    container.appendChild(div);
                                };
                                reader.readAsDataURL(file);
                            });
                        } else {
                            container.classList.add('hidden');
                        }
                    });

                    function clearMainImage() {
                        document.getElementById('main_image').value = '';
                        const container = document.getElementById('mainImagePreviewContainer');
                        container.innerHTML = `
                            <div class="space-y-2 text-center">
                                <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <div class="flex text-sm text-neutral-400">
                                    <label for="main_image"
                                        class="relative cursor-pointer rounded-md font-medium text-primary-500 hover:text-primary-600">
                                        <span>Télécharger un fichier</span>
                                        <input id="main_image" name="main_image" type="file" class="sr-only"
                                            accept="image/*">
                                    </label>
                                    <p class="pl-1">ou glisser-déposer</p>
                                </div>
                                <p class="text-xs text-neutral-400">PNG, JPG, WEBP jusqu'à 2MB</p>
                            </div>
                        `;
                        // Re-attach event listener
                        document.getElementById('main_image').addEventListener('change', arguments.callee.caller);
                    }
                </script>
            @endpush

            <!-- Options -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Options</h3>
                </div>
                <div class="card-body space-y-4">
                    <!-- Is Active -->
                    <div class="flex items-center justify-between p-4 bg-neutral-50 rounded-lg">
                        <div>
                            <label for="is_active" class="text-sm font-medium text-neutral-900">Produit actif</label>
                            <p class="text-sm text-neutral-400">Le produit sera visible sur le site</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="is_active" name="is_active" value="1"
                                {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-500">
                            </div>
                        </label>
                    </div>

                    <!-- Is Featured -->
                    <div class="flex items-center justify-between p-4 bg-neutral-50 rounded-lg">
                        <div>
                            <label for="is_featured" class="text-sm font-medium text-neutral-900">Produit en
                                vedette</label>
                            <p class="text-sm text-neutral-400">Afficher sur la page d'accueil</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                {{ old('is_featured') ? 'checked' : '' }} class="sr-only peer">
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
                    Créer le produit
                </button>
            </div>
        </form>
    </div>
@endsection
