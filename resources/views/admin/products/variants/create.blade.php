@extends('layouts.admin')

@section('title', 'Créer une Variante - ' . $product->name)
@section('page-title', 'Nouvelle Variante')

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
                <h2 class="text-2xl font-bold text-neutral-900">Créer une Variante</h2>
                <p class="text-sm text-neutral-400 mt-1">Produit: {{ $product->name }}</p>
            </div>
        </div>

        <form action="{{ route('admin.products.variants.store', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Attributes Selection -->
            <div class="card" x-data="variantGenerator()">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Attributs de la Variante</h3>
                    <p class="text-sm text-neutral-400 mt-1">Sélectionnez les valeurs pour chaque attribut (optionnel - sélection multiple possible)</p>
                </div>
                <div class="card-body space-y-6">
                    @forelse($attributes as $attribute)
                        <div>
                            <label class="label">{{ $attribute->name }} <span class="text-xs text-neutral-400">(Optionnel)</span></label>

                            @if($attribute->type === 'color')
                                <!-- Couleurs avec indication visuelle améliorée -->
                                <div class="space-y-3">
                                    <div class="flex flex-wrap gap-4">
                                        @foreach($attribute->activeValues as $value)
                                            <label class="cursor-pointer group">
                                                <input type="checkbox"
                                                    name="attribute_values[{{ $attribute->id }}][]"
                                                    value="{{ $value->id }}"
                                                    class="sr-only peer"
                                                    @change="updateVariantCount()"
                                                    {{ is_array(old('attribute_values.' . $attribute->id)) && in_array($value->id, old('attribute_values.' . $attribute->id)) ? 'checked' : '' }}>
                                                <div class="text-center">
                                                    <div class="w-16 h-16 rounded-lg border-2 border-neutral-300 peer-checked:border-primary-500 peer-checked:ring-4 peer-checked:ring-primary-200 transition-all duration-200 flex items-center justify-center mb-2"
                                                        style="background-color: {{ $value->color_hex }}">
                                                        <svg class="w-8 h-8 text-white drop-shadow-lg opacity-0 peer-checked:opacity-100 transition-opacity"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                                d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </div>
                                                    <span class="text-xs font-medium text-neutral-700 peer-checked:text-primary-600 block">
                                                        {{ $value->value }}
                                                    </span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <!-- Autres attributs avec checkboxes -->
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    @foreach($attribute->activeValues as $value)
                                        <label class="flex items-center p-3 border-2 border-neutral-200 rounded-lg cursor-pointer hover:border-primary-300 transition-colors has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50">
                                            <input type="checkbox"
                                                name="attribute_values[{{ $attribute->id }}][]"
                                                value="{{ $value->id }}"
                                                @change="updateVariantCount()"
                                                class="w-4 h-4 text-primary-500 border-neutral-300 rounded focus:ring-primary-500"
                                                {{ is_array(old('attribute_values.' . $attribute->id)) && in_array($value->id, old('attribute_values.' . $attribute->id)) ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm font-medium text-neutral-700">{{ $value->value }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif

                            @error('attribute_values.' . $attribute->id)
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @empty
                        <div class="text-center py-8 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <svg class="w-12 h-12 mx-auto text-yellow-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <p class="text-yellow-800 font-medium mb-2">Aucun attribut disponible</p>
                            <p class="text-sm text-yellow-700 mb-4">Vous devez créer des attributs avant de pouvoir créer des variantes.</p>
                            <a href="{{ route('admin.attributes.index') }}" class="btn-primary inline-flex items-center">
                                Créer des attributs
                            </a>
                        </div>
                    @endforelse

                    <!-- Compteur de variantes -->
                    <div x-show="variantCount > 0" class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm font-medium text-blue-900">
                                <span x-text="variantCount"></span> variante<span x-show="variantCount > 1">s</span> sera<span x-show="variantCount > 1">ont</span> créée<span x-show="variantCount > 1">s</span> automatiquement
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            @if($attributes->isNotEmpty())
                <!-- Pricing -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-neutral-900">Tarification</h3>
                        <p class="text-sm text-neutral-400 mt-1">Prix appliqué à toutes les variantes créées. Laissez vide pour hériter du prix du produit ({{ number_format($product->effective_price, 0, ',', ' ') }} €)</p>
                    </div>
                    <div class="card-body grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="label">Prix (€)</label>
                            <input type="number" name="price" step="0.01" min="0" class="input-field"
                                placeholder="{{ $product->price }}" value="{{ old('price') }}">
                            <p class="text-xs text-neutral-400 mt-1">Prix normal de cette variante</p>
                            @error('price')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="label">Prix Promo (€)</label>
                            <input type="number" name="sale_price" step="0.01" min="0" class="input-field"
                                placeholder="Prix en promotion" value="{{ old('sale_price') }}">
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
                                value="{{ old('stock', 0) }}" required>
                            @error('stock')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="label">Seuil d'Alerte Stock Bas</label>
                            <input type="number" name="low_stock_alert" min="0" class="input-field"
                                value="{{ old('low_stock_alert', 10) }}">
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
                                @if($product->main_image)
                                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="Produit"
                                        class="w-full h-full object-cover opacity-30">
                                @else
                                    <svg class="w-12 h-12 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <input type="file" name="image" id="imageInput" accept="image/*" class="input-field">
                                <p class="text-xs text-neutral-400 mt-2">JPG, PNG, WebP - Max 2MB. Si non fournie, l'image du produit sera utilisée.</p>
                                @error('image')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
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
                                {{ old('is_active', true) ? 'checked' : '' }}
                                class="w-4 h-4 text-primary-500 border-neutral-300 rounded focus:ring-primary-500">
                            <label for="is_active" class="ml-2 text-sm text-neutral-700">
                                Variante active (visible sur le site)
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="is_default" id="is_default" value="1"
                                {{ old('is_default', false) ? 'checked' : '' }}
                                class="w-4 h-4 text-primary-500 border-neutral-300 rounded focus:ring-primary-500">
                            <label for="is_default" class="ml-2 text-sm text-neutral-700">
                                Définir comme variante par défaut
                            </label>
                            <p class="ml-2 text-xs text-neutral-400">(Pré-sélectionnée sur la page produit)</p>
                        </div>

                        <div>
                            <label class="label">Ordre d'Affichage</label>
                            <input type="number" name="sort_order" min="0" class="input-field"
                                value="{{ old('sort_order', 0) }}">
                            <p class="text-xs text-neutral-400 mt-1">Plus le nombre est petit, plus la variante apparaît en premier</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('admin.products.variants.index', $product) }}" class="btn-secondary">
                        Annuler
                    </a>
                    <button type="submit" class="btn-primary">
                        Créer les Variantes
                    </button>
                </div>
            @endif
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

            // Alpine.js component for variant generator
            function variantGenerator() {
                return {
                    variantCount: 0,

                    init() {
                        this.updateVariantCount();
                    },

                    updateVariantCount() {
                        // Compter les checkboxes cochées pour chaque attribut
                        const attributeGroups = document.querySelectorAll('[name^="attribute_values"]');
                        const selectedCounts = {};

                        attributeGroups.forEach(checkbox => {
                            if (checkbox.checked) {
                                const match = checkbox.name.match(/attribute_values\[(\d+)\]/);
                                if (match) {
                                    const attributeId = match[1];
                                    selectedCounts[attributeId] = (selectedCounts[attributeId] || 0) + 1;
                                }
                            }
                        });

                        // Calculer le produit cartésien (nombre total de combinaisons)
                        const counts = Object.values(selectedCounts);
                        this.variantCount = counts.length > 0 ? counts.reduce((a, b) => a * b, 1) : 0;
                    }
                }
            }
        </script>
    @endpush
@endsection
