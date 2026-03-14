@extends('layouts.admin')

@section('title', 'Modifier Marque')
@section('page-title', 'Modifier la Marque')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6">
            <a href="{{ route('admin.brands.index') }}"
                class="inline-flex items-center text-sm text-neutral-400 hover:text-neutral-900">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
        </div>

        <form action="{{ route('admin.brands.update', $brand) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Informations de la Marque</h3>
                </div>
                <div class="card-body space-y-5">
                    <!-- Name -->
                    <div>
                        <label for="name" class="label">Nom de la marque <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $brand->name) }}" required
                            class="input-field @error('name') border-red-500 @enderror" placeholder="Ex: Nordic Home">
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Website -->
                    <div>
                        <label for="website" class="label">Site web</label>
                        <input type="url" id="website" name="website" value="{{ old('website', $brand->website) }}"
                            class="input-field @error('website') border-red-500 @enderror"
                            placeholder="https://www.example.com">
                        <p class="mt-1 text-xs text-neutral-400">URL complète du site web de la marque</p>
                        @error('website')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="label">Description</label>
                        <textarea id="description" name="description" rows="4"
                            class="input-field @error('description') border-red-500 @enderror" placeholder="Description de la marque">{{ old('description', $brand->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Logo -->
                    @if ($brand->logo)
                        <div>
                            <label class="label">Logo actuel</label>
                            <div class="mt-2 flex items-center space-x-4">
                                <div
                                    class="w-32 h-32 rounded-xl border-2 border-neutral-200 bg-white flex items-center justify-center p-3">
                                    <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}"
                                        class="max-w-full max-h-full object-contain">
                                </div>
                                <div>
                                    <p class="text-sm text-neutral-600 mb-2">Téléchargez un nouveau logo pour remplacer
                                        celui-ci</p>
                                    <label for="remove_logo" class="inline-flex items-center">
                                        <input type="checkbox" id="remove_logo" name="remove_logo" value="1"
                                            class="rounded border-neutral-300 text-primary-500 focus:ring-primary-500">
                                        <span class="ml-2 text-sm text-neutral-600">Supprimer le logo actuel</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Logo Upload -->
                    <div>
                        <label for="logo"
                            class="label">{{ $brand->logo ? 'Nouveau logo' : 'Logo de la marque' }}</label>
                        <div
                            class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-neutral-200 border-dashed rounded-xl hover:border-primary-500 transition-colors">
                            <div class="space-y-2 text-center">
                                <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <div class="flex text-sm text-neutral-400">
                                    <label for="logo"
                                        class="relative cursor-pointer rounded-md font-medium text-primary-500 hover:text-primary-600">
                                        <span>Télécharger un fichier</span>
                                        <input id="logo" name="logo" type="file" class="sr-only" accept="image/*"
                                            onchange="previewLogo(event)">
                                    </label>
                                    <p class="pl-1">ou glisser-déposer</p>
                                </div>
                                <p class="text-xs text-neutral-400">PNG, JPG, WEBP jusqu'à 10MB</p>
                                <p class="text-xs text-neutral-400">Recommandé : fond transparent, format carré</p>
                            </div>
                        </div>

                        <!-- Preview -->
                        <div id="logo-preview" class="mt-4 hidden">
                            <p class="text-sm text-neutral-600 mb-2">Aperçu du nouveau logo :</p>
                            <div
                                class="w-32 h-32 rounded-xl border-2 border-neutral-200 bg-white flex items-center justify-center p-3">
                                <img id="preview-image" src="" alt="Aperçu"
                                    class="max-w-full max-h-full object-contain">
                            </div>
                        </div>

                        @error('logo')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Is Active -->
                    <div class="flex items-center justify-between p-4 bg-neutral-50 rounded-lg">
                        <div>
                            <label for="is_active" class="text-sm font-medium text-neutral-900">Marque active</label>
                            <p class="text-sm text-neutral-400">La marque sera visible sur le site</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="is_active" name="is_active" value="1"
                                {{ old('is_active', $brand->is_active) ? 'checked' : '' }} class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-500">
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('admin.brands.index') }}" class="btn-secondary">
                    Annuler
                </a>
                <button type="submit" class="btn-primary">
                    Mettre à jour
                </button>
            </div>
        </form>

        <!-- Delete Section -->
        <div class="card mt-6 border-red-200">
            <div class="card-body">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-red-600 mb-2">Zone de danger</h3>
                        <p class="text-sm text-neutral-600">
                            La suppression de cette marque est irréversible.
                            @if ($brand->products_count > 0)
                                <strong class="text-red-600">Attention : {{ $brand->products_count }} produit(s) sont liés
                                    à cette marque.</strong>
                            @endif
                        </p>
                    </div>
                    <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST"
                        onsubmit="return confirm('Êtes-vous absolument sûr de vouloir supprimer cette marque ? Cette action est irréversible.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                            Supprimer la marque
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewLogo(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('logo-preview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
