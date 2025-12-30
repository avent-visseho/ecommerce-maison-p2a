@extends('layouts.admin')

@section('title', 'Nouvel Article de Location')
@section('page-title', 'Nouvel Article de Location')

@section('content')
    <form action="{{ route('admin.rental-items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-neutral-900">Nouvel Article de Location</h2>
                <p class="text-sm text-neutral-400 mt-1">Ajoutez un nouvel article disponible à la location</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.rental-items.index') }}" class="btn-secondary">Annuler</a>
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Enregistrer
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-neutral-900">Informations Générales</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div>
                            <label for="name" class="label">Nom de l'article <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="input-field"
                                required>
                            @error('name')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sku" class="label">SKU</label>
                            <input type="text" id="sku" name="sku" value="{{ old('sku') }}" class="input-field"
                                placeholder="Auto-généré si vide (RENT-XXXXX)">
                            @error('sku')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-neutral-400 mt-1">Laissez vide pour générer automatiquement</p>
                        </div>

                        <div>
                            <label for="description" class="label">Description courte</label>
                            <textarea id="description" name="description" rows="3"
                                class="input-field">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror>
                        </div>

                        <div>
                            <label for="long_description" class="label">Description détaillée</label>
                            <input id="long_description" type="hidden" name="long_description"
                                value="{{ old('long_description') }}">
                            <trix-editor input="long_description" class="trix-content"></trix-editor>
                            @error('long_description')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-neutral-900">Tarification</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="daily_rate" class="label">Tarif Journalier (€) <span
                                        class="text-red-500">*</span></label>
                                <input type="number" id="daily_rate" name="daily_rate" value="{{ old('daily_rate') }}"
                                    step="0.01" min="0" class="input-field" required>
                                @error('daily_rate')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="weekly_rate" class="label">Tarif Hebdomadaire (€)</label>
                                <input type="number" id="weekly_rate" name="weekly_rate" value="{{ old('weekly_rate') }}"
                                    step="0.01" min="0" class="input-field">
                                @error('weekly_rate')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-neutral-400 mt-1">Optionnel</p>
                            </div>

                            <div>
                                <label for="monthly_rate" class="label">Tarif Mensuel (€)</label>
                                <input type="number" id="monthly_rate" name="monthly_rate"
                                    value="{{ old('monthly_rate') }}" step="0.01" min="0" class="input-field">
                                @error('monthly_rate')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-neutral-400 mt-1">Optionnel</p>
                            </div>
                        </div>

                        <div>
                            <label for="deposit_amount" class="label">Montant de la Caution (€) <span
                                    class="text-red-500">*</span></label>
                            <input type="number" id="deposit_amount" name="deposit_amount"
                                value="{{ old('deposit_amount', 0) }}" step="0.01" min="0" class="input-field"
                                required>
                            @error('deposit_amount')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-neutral-400 mt-1">Caution remboursable après retour de l'article</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="min_rental_days" class="label">Durée Minimum (jours)</label>
                                <input type="number" id="min_rental_days" name="min_rental_days"
                                    value="{{ old('min_rental_days') }}" min="1" class="input-field">
                                @error('min_rental_days')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-neutral-400 mt-1">Optionnel</p>
                            </div>

                            <div>
                                <label for="max_rental_days" class="label">Durée Maximum (jours)</label>
                                <input type="number" id="max_rental_days" name="max_rental_days"
                                    value="{{ old('max_rental_days') }}" min="1" class="input-field">
                                @error('max_rental_days')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-neutral-400 mt-1">Optionnel</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Images -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-neutral-900">Images</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <!-- Main Image -->
                        <div>
                            <label for="main_image" class="label">Image Principale</label>
                            <div class="mt-2" x-data="imagePreview()">
                                <div class="flex items-center space-x-4">
                                    <label for="main_image"
                                        class="btn-secondary cursor-pointer inline-flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Choisir une image
                                    </label>
                                    <input id="main_image" name="main_image" type="file" class="sr-only"
                                        accept="image/*" @change="handleFileSelect">
                                    <span class="text-sm text-neutral-400" x-text="fileName"></span>
                                </div>
                                <div x-show="imageUrl" class="mt-4">
                                    <img :src="imageUrl" class="w-48 h-48 object-cover rounded-lg">
                                </div>
                            </div>
                            @error('main_image')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-neutral-400 mt-1">Taille max: 10MB. Formats: JPG, PNG, WebP</p>
                        </div>

                        <!-- Additional Images -->
                        <div>
                            <label for="images" class="label">Images Supplémentaires</label>
                            <input type="file" id="images" name="images[]" class="input-field" multiple
                                accept="image/*">
                            @error('images')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-neutral-400 mt-1">Vous pouvez sélectionner plusieurs images (max 10MB
                                chacune)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Category & Settings -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-neutral-900">Organisation</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div>
                            <label for="rental_category_id" class="label">Catégorie <span
                                    class="text-red-500">*</span></label>
                            <select id="rental_category_id" name="rental_category_id" class="input-field" required>
                                <option value="">Sélectionnez une catégorie</option>
                                @foreach (\App\Models\RentalCategory::active()->orderBy('name')->get() as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('rental_category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('rental_category_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="quantity" class="label">Quantité Disponible <span
                                    class="text-red-500">*</span></label>
                            <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 1) }}"
                                min="0" class="input-field" required>
                            @error('quantity')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-neutral-400 mt-1">Nombre d'unités disponibles à la location</p>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-neutral-900">Statut</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="flex items-center justify-between">
                            <label for="is_active" class="label mb-0">Actif</label>
                            <input type="checkbox" id="is_active" name="is_active" value="1"
                                {{ old('is_active', true) ? 'checked' : '' }} class="toggle">
                        </div>

                        <div class="flex items-center justify-between">
                            <label for="is_featured" class="label mb-0">En Vedette</label>
                            <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                {{ old('is_featured') ? 'checked' : '' }} class="toggle">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
@endpush

@push('scripts')
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <script>
        function imagePreview() {
            return {
                imageUrl: '',
                fileName: 'Aucun fichier sélectionné',
                handleFileSelect(event) {
                    const file = event.target.files[0];
                    if (file) {
                        // Vérifier la taille (10MB max)
                        if (file.size > 10 * 1024 * 1024) {
                            alert('La taille du fichier ne doit pas dépasser 10MB');
                            event.target.value = '';
                            return;
                        }
                        this.fileName = file.name;
                        this.imageUrl = URL.createObjectURL(file);
                    }
                }
            }
        }
    </script>
@endpush
