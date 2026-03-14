@extends('layouts.admin')

@section('title', 'Modifier Catégorie')
@section('page-title', 'Modifier la Catégorie')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}"
                class="inline-flex items-center text-sm text-neutral-400 hover:text-neutral-900">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
        </div>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Informations de la Catégorie</h3>
                </div>
                <div class="card-body space-y-5">
                    <!-- Name -->
                    <div>
                        <label for="name" class="label">Nom de la catégorie <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                            required class="input-field @error('name') border-red-500 @enderror" placeholder="Ex: Mobilier">
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="label">Description</label>
                        <textarea id="description" name="description" rows="3"
                            class="input-field @error('description') border-red-500 @enderror" placeholder="Description de la catégorie">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Parent Category -->
                    <div>
                        <label for="parent_id" class="label">Catégorie Parent</label>
                        <select id="parent_id" name="parent_id"
                            class="input-field @error('parent_id') border-red-500 @enderror">
                            <option value="">Aucune (Catégorie principale)</option>
                            @foreach ($parentCategories as $parent)
                                <option value="{{ $parent->id }}"
                                    {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-neutral-400">Laissez vide pour créer une catégorie principale</p>
                        @error('parent_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Order -->
                    <div>
                        <label for="order" class="label">Ordre d'affichage</label>
                        <input type="number" id="order" name="order" value="{{ old('order', $category->order) }}"
                            min="0" class="input-field @error('order') border-red-500 @enderror" placeholder="0">
                        <p class="mt-1 text-xs text-neutral-400">Les catégories seront triées par ordre croissant</p>
                        @error('order')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Image -->
                    @if ($category->image)
                        <div>
                            <label class="label">Image actuelle</label>
                            <div class="mt-2 flex items-center space-x-4">
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                    class="w-32 h-32 object-cover rounded-xl border-2 border-neutral-200">
                                <div>
                                    <p class="text-sm text-neutral-600 mb-2">Téléchargez une nouvelle image pour remplacer
                                        celle-ci</p>
                                    <label for="remove_image" class="inline-flex items-center">
                                        <input type="checkbox" id="remove_image" name="remove_image" value="1"
                                            class="rounded border-neutral-300 text-primary-500 focus:ring-primary-500">
                                        <span class="ml-2 text-sm text-neutral-600">Supprimer l'image actuelle</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Image Upload -->
                    <div>
                        <label for="image"
                            class="label">{{ $category->image ? 'Nouvelle image' : 'Image de la catégorie' }}</label>

                        <!-- Image Preview -->
                        <div id="imagePreviewContainer" class="hidden mt-2 mb-4">
                            <div class="relative inline-block">
                                <img id="imagePreview" src="" alt="Aperçu" class="max-w-xs max-h-48 rounded-lg border-2 border-neutral-200">
                                <button type="button" id="removeImage" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Upload Area -->
                        <div id="uploadArea"
                            class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-neutral-200 border-dashed rounded-xl hover:border-primary-500 transition-colors">
                            <div class="space-y-2 text-center">
                                <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <div class="flex text-sm text-neutral-400">
                                    <label for="image"
                                        class="relative cursor-pointer rounded-md font-medium text-primary-500 hover:text-primary-600">
                                        <span>Télécharger un fichier</span>
                                        <input id="image" name="image" type="file" class="sr-only"
                                            accept="image/*">
                                    </label>
                                    <p class="pl-1">ou glisser-déposer</p>
                                </div>
                                <p class="text-xs text-neutral-400">PNG, JPG, WEBP jusqu'à 10MB</p>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Is Active -->
                    <div class="flex items-center justify-between p-4 bg-neutral-50 rounded-lg">
                        <div>
                            <label for="is_active" class="text-sm font-medium text-neutral-900">Catégorie active</label>
                            <p class="text-sm text-neutral-400">La catégorie sera visible sur le site</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="is_active" name="is_active" value="1"
                                {{ old('is_active', $category->is_active) ? 'checked' : '' }} class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-500">
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('admin.categories.index') }}" class="btn-secondary">
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
                            La suppression de cette catégorie est irréversible.
                            @if ($category->products_count > 0)
                                <strong class="text-red-600">Attention : {{ $category->products_count }} produit(s) sont
                                    liés à cette catégorie.</strong>
                            @endif
                        </p>
                    </div>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                        onsubmit="return confirm('Êtes-vous absolument sûr de vouloir supprimer cette catégorie ? Cette action est irréversible.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                            Supprimer la catégorie
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const uploadArea = document.getElementById('uploadArea');
            const removeImageBtn = document.getElementById('removeImage');
            const removeImageCheckbox = document.getElementById('remove_image');

            // Handle image selection
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (file) {
                    // Check if file is an image
                    if (!file.type.startsWith('image/')) {
                        alert('Veuillez sélectionner un fichier image valide');
                        return;
                    }

                    // Check file size (2MB = 10 * 1024 * 1024 bytes)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('La taille du fichier ne doit pas dépasser 10MB');
                        imageInput.value = '';
                        return;
                    }

                    // Create FileReader to preview image
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreviewContainer.classList.remove('hidden');
                        uploadArea.classList.add('hidden');

                        // Uncheck remove_image if a new image is selected
                        if (removeImageCheckbox) {
                            removeImageCheckbox.checked = false;
                        }
                    };

                    reader.readAsDataURL(file);
                }
            });

            // Handle image removal
            removeImageBtn.addEventListener('click', function() {
                imageInput.value = '';
                imagePreview.src = '';
                imagePreviewContainer.classList.add('hidden');
                uploadArea.classList.remove('hidden');
            });
        });
    </script>
    @endpush
@endsection
