@extends('layouts.admin')

@section('title', 'Nouvelle Catégorie')
@section('page-title', 'Créer une Catégorie')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6">
            <a href="{{ route('admin.blog.categories.index') }}"
                class="inline-flex items-center text-sm text-neutral-400 hover:text-neutral-900">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
        </div>

        <form action="{{ route('admin.blog.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Informations Générales</h3>
                </div>
                <div class="card-body space-y-5">
                    <!-- Name -->
                    <div>
                        <label for="name" class="label">Nom <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="input-field @error('name') border-red-500 @enderror"
                            placeholder="Ex: Décoration d'intérieur">
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="label">Slug</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                            class="input-field @error('slug') border-red-500 @enderror"
                            placeholder="decoration-interieur (généré automatiquement si vide)">
                        <p class="mt-1 text-xs text-neutral-500">Laissez vide pour générer automatiquement à partir du nom</p>
                        @error('slug')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="label">Description</label>
                        <textarea id="description" name="description" rows="4"
                            class="input-field @error('description') border-red-500 @enderror"
                            placeholder="Description de la catégorie...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image -->
                    <div>
                        <label for="image" class="label">Image</label>
                        <input type="file" id="image" name="image" accept="image/*"
                            class="input-field @error('image') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-neutral-500">Formats acceptés : JPG, PNG, WebP (max 2 Mo)</p>
                        @error('image')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Hierarchy & Settings -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Hiérarchie & Paramètres</h3>
                </div>
                <div class="card-body space-y-5">
                    <!-- Parent Category -->
                    <div>
                        <label for="parent_id" class="label">Catégorie Parente</label>
                        <select id="parent_id" name="parent_id"
                            class="input-field @error('parent_id') border-red-500 @enderror">
                            <option value="">Aucune (catégorie racine)</option>
                            @foreach ($parentCategories as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-neutral-500">Créez des sous-catégories en sélectionnant une catégorie parente</p>
                        @error('parent_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Order -->
                    <div>
                        <label for="order" class="label">Ordre d'Affichage</label>
                        <input type="number" id="order" name="order" value="{{ old('order', 0) }}" min="0"
                            class="input-field @error('order') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-neutral-500">Les catégories avec un ordre plus faible apparaissent en premier</p>
                        @error('order')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                class="rounded border-neutral-300 text-primary focus:ring-primary">
                            <span class="ml-2 text-sm font-medium text-neutral-700">Catégorie Active</span>
                        </label>
                        <p class="mt-1 text-xs text-neutral-500">Les catégories inactives ne sont pas visibles publiquement</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('admin.blog.categories.index') }}" class="btn-outline">Annuler</a>
                <button type="submit" class="btn-primary">Créer la catégorie</button>
            </div>
        </form>
    </div>
@endsection
