@extends('layouts.admin')

@section('title', 'Créer des Variantes - ' . $product->name)
@section('page-title', 'Nouvelles Variantes')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6" x-data="variantCreator()">
        <!-- Header -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.products.variants.index', $product) }}" class="text-neutral-400 hover:text-neutral-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-neutral-900">Créer des Variantes</h2>
                <p class="text-sm text-neutral-400 mt-1">Produit: {{ $product->name }} — Prix de base: {{ number_format($product->effective_price, 0, ',', ' ') }} €</p>
            </div>
        </div>

        <form action="{{ route('admin.products.variants.store', $product) }}" method="POST" enctype="multipart/form-data"
              @submit.prevent="submitForm($event)">
            @csrf

            <!-- Étape 1 : Sélection des attributs -->
            <div class="card mb-6">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">1. Sélectionnez les attributs</h3>
                    <p class="text-sm text-neutral-400 mt-1">Cochez les valeurs souhaitées pour chaque attribut. Les combinaisons seront générées automatiquement.</p>
                </div>
                <div class="card-body space-y-6">
                    @forelse($attributes as $attribute)
                        <div>
                            <label class="label text-base font-semibold">{{ $attribute->name }}</label>

                            @if($attribute->type === 'color')
                                <div class="flex flex-wrap gap-4 mt-2">
                                    @foreach($attribute->activeValues as $value)
                                        <label class="relative cursor-pointer">
                                            <input type="checkbox"
                                                value="{{ $value->id }}"
                                                data-attribute-id="{{ $attribute->id }}"
                                                data-attribute-name="{{ $attribute->name }}"
                                                data-value-name="{{ $value->value }}"
                                                class="sr-only peer attribute-checkbox"
                                                @change="onAttributeChange()">
                                            <div class="w-14 h-14 rounded-lg border-2 border-neutral-300 peer-checked:border-primary-500 peer-checked:ring-4 peer-checked:ring-primary-200 transition-all duration-200"
                                                style="background-color: {{ $value->color_hex }}">
                                            </div>
                                            <svg class="w-7 h-7 text-white drop-shadow-lg absolute top-3.5 left-1/2 -translate-x-1/2 opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span class="text-xs font-medium text-neutral-700 peer-checked:text-primary-600 block text-center mt-1">{{ $value->value }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-2">
                                    @foreach($attribute->activeValues as $value)
                                        <label class="flex items-center p-3 border-2 border-neutral-200 rounded-lg cursor-pointer hover:border-primary-300 transition-colors has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50">
                                            <input type="checkbox"
                                                value="{{ $value->id }}"
                                                data-attribute-id="{{ $attribute->id }}"
                                                data-attribute-name="{{ $attribute->name }}"
                                                data-value-name="{{ $value->value }}"
                                                class="w-4 h-4 text-primary-500 border-neutral-300 rounded focus:ring-primary-500 attribute-checkbox"
                                                @change="onAttributeChange()">
                                            <span class="ml-2 text-sm font-medium text-neutral-700">{{ $value->value }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-8 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-yellow-800 font-medium mb-2">Aucun attribut disponible</p>
                            <a href="{{ route('admin.attributes.index') }}" class="btn-primary inline-flex items-center">Créer des attributs</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Étape 2 : Prévisualisation et configuration des combinaisons -->
            <div class="card mb-6" x-show="combinations.length > 0" x-cloak>
                <div class="card-header flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-neutral-900">2. Configurez chaque variante</h3>
                        <p class="text-sm text-neutral-400 mt-1">
                            <span x-text="combinations.length"></span> variante(s) seront créées. Définissez prix et stock pour chacune.
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="applyToAll()" class="text-sm text-primary-500 hover:text-primary-700 font-medium">
                            Appliquer à toutes
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Appliquer en masse -->
                    <div class="bg-neutral-50 rounded-xl p-4 mb-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <label class="text-xs font-medium text-neutral-500">Prix commun (€)</label>
                            <input type="number" step="0.01" min="0" x-model="bulkPrice" class="input-field mt-1" placeholder="{{ $product->price }}">
                        </div>
                        <div>
                            <label class="text-xs font-medium text-neutral-500">Prix promo commun (€)</label>
                            <input type="number" step="0.01" min="0" x-model="bulkSalePrice" class="input-field mt-1" placeholder="Optionnel">
                        </div>
                        <div>
                            <label class="text-xs font-medium text-neutral-500">Stock commun</label>
                            <input type="number" min="0" x-model="bulkStock" class="input-field mt-1" placeholder="0">
                        </div>
                        <div>
                            <label class="text-xs font-medium text-neutral-500">Alerte stock</label>
                            <input type="number" min="0" x-model="bulkLowStock" class="input-field mt-1" placeholder="10">
                        </div>
                    </div>

                    <!-- Liste des variantes -->
                    <div class="space-y-3">
                        <template x-for="(combo, index) in combinations" :key="index">
                            <div class="border border-neutral-200 rounded-xl p-4 hover:border-primary-200 transition-colors">
                                <div class="flex items-start gap-4">
                                    <!-- Nom de la combinaison -->
                                    <div class="flex-shrink-0 min-w-[200px]">
                                        <div class="flex flex-wrap gap-2">
                                            <template x-for="attr in combo.attributes" :key="attr.valueId">
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-primary-50 text-primary-700">
                                                    <span class="text-neutral-400" x-text="attr.attributeName + ':'"></span>
                                                    <span x-text="attr.valueName"></span>
                                                </span>
                                            </template>
                                        </div>
                                    </div>

                                    <!-- Prix / Stock -->
                                    <div class="flex-1 grid grid-cols-2 md:grid-cols-4 gap-3">
                                        <div>
                                            <label class="text-xs text-neutral-400">Prix (€)</label>
                                            <input type="number" step="0.01" min="0"
                                                :name="'variant_data[' + index + '][price]'"
                                                x-model="combo.price"
                                                class="input-field mt-1 text-sm"
                                                placeholder="{{ $product->price }}">
                                        </div>
                                        <div>
                                            <label class="text-xs text-neutral-400">Prix promo (€)</label>
                                            <input type="number" step="0.01" min="0"
                                                :name="'variant_data[' + index + '][sale_price]'"
                                                x-model="combo.sale_price"
                                                class="input-field mt-1 text-sm"
                                                placeholder="—">
                                        </div>
                                        <div>
                                            <label class="text-xs text-neutral-400">Stock *</label>
                                            <input type="number" min="0"
                                                :name="'variant_data[' + index + '][stock]'"
                                                x-model="combo.stock"
                                                class="input-field mt-1 text-sm"
                                                required>
                                        </div>
                                        <div>
                                            <label class="text-xs text-neutral-400">Alerte stock</label>
                                            <input type="number" min="0"
                                                :name="'variant_data[' + index + '][low_stock_alert]'"
                                                x-model="combo.low_stock_alert"
                                                class="input-field mt-1 text-sm">
                                        </div>
                                    </div>

                                    <!-- Image de la variante -->
                                    <div class="flex-shrink-0">
                                        <label class="text-xs text-neutral-400 block mb-1">Image</label>
                                        <label class="relative cursor-pointer group">
                                            <input type="file"
                                                :name="'variant_data[' + index + '][image]'"
                                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                                class="sr-only"
                                                @change="previewImage($event, index)">
                                            <div class="w-16 h-16 rounded-lg border-2 border-dashed border-neutral-300 group-hover:border-primary-400 flex items-center justify-center overflow-hidden transition-colors">
                                                <template x-if="combo.imagePreview">
                                                    <img :src="combo.imagePreview" class="w-full h-full object-cover rounded-lg">
                                                </template>
                                                <template x-if="!combo.imagePreview">
                                                    <svg class="w-6 h-6 text-neutral-400 group-hover:text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </template>
                                            </div>
                                        </label>
                                        <button type="button" x-show="combo.imagePreview" @click="removeImage(index)" class="text-xs text-red-500 hover:text-red-700 mt-1">Retirer</button>
                                    </div>

                                    <!-- Supprimer cette combinaison -->
                                    <button type="button" @click="removeCombination(index)" class="text-neutral-300 hover:text-red-500 transition-colors mt-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Hidden fields pour les attribute_values -->
                                <template x-for="attr in combo.attributes" :key="attr.valueId">
                                    <input type="hidden"
                                        :name="'variant_data[' + index + '][attribute_values][' + attr.attributeId + ']'"
                                        :value="attr.valueId">
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Paramètres communs -->
            <div class="card mb-6" x-show="combinations.length > 0" x-cloak>
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">3. Paramètres communs</h3>
                </div>
                <div class="card-body space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" checked
                            class="w-4 h-4 text-primary-500 border-neutral-300 rounded focus:ring-primary-500">
                        <label for="is_active" class="ml-2 text-sm text-neutral-700">Variantes actives (visibles sur le site)</label>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4" x-show="combinations.length > 0" x-cloak>
                <a href="{{ route('admin.products.variants.index', $product) }}" class="btn-secondary">Annuler</a>
                <button type="submit" class="btn-primary">
                    Créer <span x-text="combinations.length"></span> variante(s)
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
    function variantCreator() {
        return {
            combinations: [],
            bulkPrice: '',
            bulkSalePrice: '',
            bulkStock: '0',
            bulkLowStock: '10',

            onAttributeChange() {
                this.generateCombinations();
            },

            generateCombinations() {
                const checkboxes = document.querySelectorAll('.attribute-checkbox:checked');
                const attributeGroups = {};

                checkboxes.forEach(cb => {
                    const attrId = cb.dataset.attributeId;
                    if (!attributeGroups[attrId]) {
                        attributeGroups[attrId] = [];
                    }
                    attributeGroups[attrId].push({
                        attributeId: attrId,
                        attributeName: cb.dataset.attributeName,
                        valueId: cb.value,
                        valueName: cb.dataset.valueName,
                    });
                });

                const groups = Object.values(attributeGroups);
                if (groups.length === 0) {
                    this.combinations = [];
                    return;
                }

                // Produit cartésien
                let combos = [[]];
                for (const group of groups) {
                    const temp = [];
                    for (const combo of combos) {
                        for (const item of group) {
                            temp.push([...combo, item]);
                        }
                    }
                    combos = temp;
                }

                // Conserver les prix existants si la combinaison existait déjà
                const oldCombos = {};
                this.combinations.forEach(c => {
                    const key = c.attributes.map(a => a.valueId).sort().join('-');
                    oldCombos[key] = c;
                });

                this.combinations = combos.map(attrs => {
                    const key = attrs.map(a => a.valueId).sort().join('-');
                    const existing = oldCombos[key];
                    return {
                        attributes: attrs,
                        price: existing?.price || '',
                        sale_price: existing?.sale_price || '',
                        stock: existing?.stock || this.bulkStock || '0',
                        low_stock_alert: existing?.low_stock_alert || this.bulkLowStock || '10',
                        imagePreview: existing?.imagePreview || null,
                    };
                });
            },

            applyToAll() {
                this.combinations.forEach(combo => {
                    if (this.bulkPrice) combo.price = this.bulkPrice;
                    if (this.bulkSalePrice) combo.sale_price = this.bulkSalePrice;
                    if (this.bulkStock) combo.stock = this.bulkStock;
                    if (this.bulkLowStock) combo.low_stock_alert = this.bulkLowStock;
                });
            },

            removeCombination(index) {
                this.combinations.splice(index, 1);
            },

            previewImage(event, index) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.combinations[index].imagePreview = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            },

            removeImage(index) {
                this.combinations[index].imagePreview = null;
                // Réinitialiser l'input file
                const form = document.querySelector('form');
                const input = form.querySelector(`input[name="variant_data[${index}][image]"]`);
                if (input) input.value = '';
            },

            submitForm(event) {
                if (this.combinations.length === 0) return;
                event.target.submit();
            }
        }
    }
    </script>
    @endpush
@endsection
