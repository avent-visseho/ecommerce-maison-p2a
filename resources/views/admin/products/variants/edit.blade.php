@extends('layouts.admin')

@section('title', 'Modifier Variante - ' . $product->name)
@section('page-title', 'Modifier Variante')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.products.variants.index', $product) }}" class="text-neutral-400 hover:text-neutral-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-neutral-900">Modifier Variante</h2>
                <p class="text-sm text-neutral-400 mt-1">{{ $product->name }} - {{ $variant->display_name }}</p>
            </div>
        </div>

        <form action="{{ route('admin.products.variants.update', [$product, $variant]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Attributes Selection -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Attributs de la Variante</h3>
                    <p class="text-sm text-neutral-400 mt-1">Sélectionnez les valeurs pour chaque attribut</p>
                </div>
                <div class="card-body space-y-4">
                    @foreach($attributes as $attribute)
                        @php
                            $selectedValue = $variant->attributeValues->where('product_attribute_id', $attribute->id)->first();
                        @endphp
                        <div>
                            <label class="label">{{ $attribute->name }}</label>

                            @if($attribute->type === 'color')
                                <div class="flex flex-wrap gap-3">
                                    @foreach($attribute->activeValues as $value)
                                        <label class="flex items-center cursor-pointer group">
                                            <input type="radio" name="attribute_values[{{ $attribute->id }}]"
                                                value="{{ $value->id }}"
                                                class="sr-only peer"
                                                {{ old('attribute_values.' . $attribute->id, $selectedValue?->id) == $value->id ? 'checked' : '' }}>
                                            <div class="relative">
                                                <div class="w-12 h-12 rounded-lg border-2 border-neutral-300 peer-checked:border-primary-500 peer-checked:ring-2 peer-checked:ring-primary-200 transition-all duration-200 flex items-center justify-center"
                                                    style="background-color: {{ $value->color_hex }}">
                                                    <svg class="w-6 h-6 text-white drop-shadow-lg opacity-0 peer-checked:opacity-100 transition-opacity"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                            d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                                <span class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-xs text-neutral-600 whitespace-nowrap">
                                                    {{ $value->value }}
                                                </span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <select name="attribute_values[{{ $attribute->id }}]" class="input-field" required>
                                    <option value="">Sélectionner {{ $attribute->name }}</option>
                                    @foreach($attribute->activeValues as $value)
                                        <option value="{{ $value->id }}"
                                            {{ old('attribute_values.' . $attribute->id, $selectedValue?->id) == $value->id ? 'selected' : '' }}>
                                            {{ $value->value }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif

                            @error('attribute_values.' . $attribute->id)
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Pricing -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Tarification</h3>
                    <p class="text-sm text-neutral-400 mt-1">Laissez vide pour hériter du prix du produit ({{ number_format($product->effective_price, 0, ',', ' ') }} €)</p>
                </div>
                <div class="card-body grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="label">Prix (€)</label>
                        <input type="number" name="price" step="0.01" min="0" class="input-field"
                            placeholder="{{ $product->price }}" value="{{ old('price', $variant->price) }}">
                        <p class="text-xs text-neutral-400 mt-1">Prix normal de cette variante</p>
                        @error('price')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="label">Prix Promo (€)</label>
                        <input type="number" name="sale_price" step="0.01" min="0" class="input-field"
                            placeholder="Prix en promotion" value="{{ old('sale_price', $variant->sale_price) }}">
                        <p class="text-xs text-neutral-400 mt-1">Prix promotionnel optionnel</p>
                        @error('sale_price')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Stock -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Stock</h3>
                </div>
                <div class="card-body grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="label">Quantité en Stock *</label>
                        <input type="number" name="stock" min="0" class="input-field"
                            value="{{ old('stock', $variant->stock) }}" required>
                        @error('stock')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="label">Seuil d'Alerte Stock Bas</label>
                        <input type="number" name="low_stock_alert" min="0" class="input-field"
                            value="{{ old('low_stock_alert', $variant->low_stock_alert) }}">
                        <p class="text-xs text-neutral-400 mt-1">Alerte si stock ≤ ce nombre</p>
                        @error('low_stock_alert')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Image -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Image de la Variante</h3>
                    <p class="text-sm text-neutral-400 mt-1">Optionnel - Image spécifique à cette variante</p>
                </div>
                <div class="card-body">
                    <div class="flex items-start space-x-4">
                        <div id="imagePreview" class="w-32 h-32 bg-neutral-100 rounded-xl border-2 border-dashed border-neutral-300 flex items-center justify-center overflow-hidden">
                            @if($variant->image)
                                <img src="{{ asset('storage/' . $variant->image) }}" alt="{{ $variant->display_name }}"
                                    class="w-full h-full object-cover">
                            @elseif($product->main_image)
                                <img src="{{ asset('storage/' . $product->main_image) }}" alt="Produit"
                                    class="w-full h-full object-cover opacity-30">
                            @else
                                <svg class="w-12 h-12 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1 space-y-3">
                            <input type="file" name="image" id="imageInput" accept="image/*" class="input-field">
                            <p class="text-xs text-neutral-400">JPG, PNG, WebP - Max 10MB. Si non fournie, l'image du produit sera utilisée.</p>

                            @if($variant->image)
                                <div class="flex items-center">
                                    <input type="checkbox" name="remove_image" id="remove_image" value="1"
                                        class="w-4 h-4 text-red-500 border-neutral-300 rounded focus:ring-red-500">
                                    <label for="remove_image" class="ml-2 text-sm text-red-600">
                                        Supprimer l'image actuelle
                                    </label>
                                </div>
                            @endif

                            @error('image')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Paramètres</h3>
                </div>
                <div class="card-body space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                            {{ old('is_active', $variant->is_active) ? 'checked' : '' }}
                            class="w-4 h-4 text-primary-500 border-neutral-300 rounded focus:ring-primary-500">
                        <label for="is_active" class="ml-2 text-sm text-neutral-700">
                            Variante active (visible sur le site)
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_default" id="is_default" value="1"
                            {{ old('is_default', $variant->is_default) ? 'checked' : '' }}
                            class="w-4 h-4 text-primary-500 border-neutral-300 rounded focus:ring-primary-500">
                        <label for="is_default" class="ml-2 text-sm text-neutral-700">
                            Définir comme variante par défaut
                        </label>
                        <p class="ml-2 text-xs text-neutral-400">(Pré-sélectionnée sur la page produit)</p>
                    </div>

                    <div>
                        <label class="label">Ordre d'Affichage</label>
                        <input type="number" name="sort_order" min="0" class="input-field"
                            value="{{ old('sort_order', $variant->sort_order) }}">
                        <p class="text-xs text-neutral-400 mt-1">Plus le nombre est petit, plus la variante apparaît en premier</p>
                    </div>
                </div>
            </div>

            <!-- SKU Info -->
            <div class="card bg-neutral-50">
                <div class="card-body">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="text-sm text-neutral-600">SKU actuel: <span class="font-mono font-semibold">{{ $variant->sku }}</span></p>
                            <p class="text-xs text-neutral-400 mt-1">Le SKU est généré automatiquement et ne peut pas être modifié</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('admin.products.variants.index', $product) }}" class="btn-secondary">
                    Annuler
                </a>
                <button type="submit" class="btn-primary">
                    Sauvegarder les Modifications
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            // Image preview
            const imageInput = document.getElementById('imageInput');
            const imagePreview = document.getElementById('imagePreview');

            if (imageInput && imagePreview) {
                imageInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover" alt="Preview">`;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        </script>
    @endpush
@endsection
