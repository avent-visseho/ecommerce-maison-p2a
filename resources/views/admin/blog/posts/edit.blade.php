@extends('layouts.admin')

@section('title', 'Modifier Article')
@section('page-title', 'Modifier l\'Article')

@section('content')
    <div class="max-w-5xl">
        <div class="mb-6">
            <a href="{{ route('admin.blog.posts.index') }}"
                class="inline-flex items-center text-sm text-neutral-400 hover:text-neutral-900">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
        </div>

        <form action="{{ route('admin.blog.posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Informations Générales</h3>
                </div>
                <div class="card-body space-y-5">
                    <!-- Title -->
                    <div>
                        <label for="title" class="label">Titre <span class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required
                            class="input-field @error('title') border-red-500 @enderror">
                        @error('title')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="label">Slug</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $post->slug) }}"
                            class="input-field @error('slug') border-red-500 @enderror">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Excerpt -->
                    <div>
                        <label for="excerpt" class="label">Extrait</label>
                        <textarea id="excerpt" name="excerpt" rows="3"
                            class="input-field @error('excerpt') border-red-500 @enderror"
                            placeholder="Résumé court de l'article (max 500 caractères)">{{ old('excerpt', $post->excerpt) }}</textarea>
                        @error('excerpt')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="label">Contenu <span class="text-red-500">*</span></label>
                        <input id="content" type="hidden" name="content" value="{{ old('content', $post->content) }}">
                        <trix-editor input="content" class="trix-content @error('content') border-red-500 @enderror"></trix-editor>
                        @error('content')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Category & Tags -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Catégorie & Tags</h3>
                </div>
                <div class="card-body space-y-5">
                    <!-- Category -->
                    <div>
                        <label for="blog_category_id" class="label">Catégorie</label>
                        <select id="blog_category_id" name="blog_category_id"
                            class="input-field @error('blog_category_id') border-red-500 @enderror">
                            <option value="">Aucune catégorie</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('blog_category_id', $post->blog_category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('blog_category_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tags -->
                    <div>
                        <label class="label">Tags</label>
                        <div class="space-y-2">
                            @foreach ($tags as $tag)
                                <label class="inline-flex items-center mr-4">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                        {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'checked' : '' }}
                                        class="rounded border-neutral-300 text-primary focus:ring-primary">
                                    <span class="ml-2">{{ $tag->name }}</span>
                                </label>
                            @endforeach
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
                    <!-- Featured Image -->
                    <div>
                        <label for="featured_image" class="label">Image à la une</label>
                        @if($post->featured_image)
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                                    class="w-48 h-32 object-cover rounded-lg">
                                <label class="inline-flex items-center mt-2">
                                    <input type="checkbox" name="delete_featured_image" value="1"
                                        class="rounded border-neutral-300 text-red-600 focus:ring-red-500">
                                    <span class="ml-2 text-sm text-red-600">Supprimer cette image</span>
                                </label>
                            </div>
                        @endif
                        <input type="file" id="featured_image" name="featured_image" accept="image/*"
                            class="input-field @error('featured_image') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-neutral-500">Taille max : 5 Mo. Formats : JPG, PNG, WebP</p>
                        @error('featured_image')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gallery Images -->
                    <div>
                        <label for="images" class="label">Galerie d'images</label>
                        <input type="file" id="images" name="images[]" accept="image/*" multiple
                            class="input-field @error('images.*') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-neutral-500">Taille max par image : 5 Mo. Maximum 10 images.</p>
                        @error('images.*')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Publication Settings -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">Paramètres de Publication</h3>
                </div>
                <div class="card-body space-y-5">
                    <!-- Status -->
                    <div>
                        <label for="status" class="label">Statut <span class="text-red-500">*</span></label>
                        <select id="status" name="status" required
                            class="input-field @error('status') border-red-500 @enderror">
                            <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Brouillon</option>
                            <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Publié</option>
                            <option value="scheduled" {{ old('status', $post->status) == 'scheduled' ? 'selected' : '' }}>Planifié</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Published At -->
                    <div id="published_at_field">
                        <label for="published_at" class="label">Date de publication</label>
                        <input type="datetime-local" id="published_at" name="published_at"
                            value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}"
                            class="input-field @error('published_at') border-red-500 @enderror">
                        @error('published_at')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Scheduled At -->
                    <div id="scheduled_at_field" style="display: none;">
                        <label for="scheduled_at" class="label">Date de publication planifiée <span class="text-red-500">*</span></label>
                        <input type="datetime-local" id="scheduled_at" name="scheduled_at"
                            value="{{ old('scheduled_at', $post->scheduled_at ? $post->scheduled_at->format('Y-m-d\TH:i') : '') }}"
                            class="input-field @error('scheduled_at') border-red-500 @enderror">
                        @error('scheduled_at')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Options -->
                    <div class="space-y-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}
                                class="rounded border-neutral-300 text-primary focus:ring-primary">
                            <span class="ml-2">Article à la une</span>
                        </label>
                        <br>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="allow_comments" value="1" {{ old('allow_comments', $post->allow_comments) ? 'checked' : '' }}
                                class="rounded border-neutral-300 text-primary focus:ring-primary">
                            <span class="ml-2">Autoriser les commentaires</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- SEO -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-neutral-900">SEO</h3>
                </div>
                <div class="card-body space-y-5">
                    <!-- Meta Title -->
                    <div>
                        <label for="meta_title" class="label">Titre SEO</label>
                        <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}"
                            class="input-field @error('meta_title') border-red-500 @enderror">
                        @error('meta_title')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Meta Description -->
                    <div>
                        <label for="meta_description" class="label">Description SEO</label>
                        <textarea id="meta_description" name="meta_description" rows="3"
                            class="input-field @error('meta_description') border-red-500 @enderror">{{ old('meta_description', $post->meta_description) }}</textarea>
                        @error('meta_description')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Meta Keywords -->
                    <div>
                        <label for="meta_keywords" class="label">Mots-clés SEO</label>
                        <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $post->meta_keywords) }}"
                            class="input-field @error('meta_keywords') border-red-500 @enderror"
                            placeholder="mot1, mot2, mot3">
                        @error('meta_keywords')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('admin.blog.posts.index') }}" class="btn-outline">Annuler</a>
                <button type="submit" class="btn-primary">Mettre à jour l'article</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<!-- Trix Editor CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<script src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

<style>
    trix-toolbar .trix-button-group--file-tools {
        display: none;
    }
    .trix-content {
        min-height: 400px;
        max-height: 600px;
        overflow-y: auto;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1rem;
    }
    .trix-content:focus {
        outline: none;
        border-color: #2725a9;
        box-shadow: 0 0 0 3px rgba(39, 37, 169, 0.1);
    }
</style>

<script>
    // Validation de la taille des fichiers
    function validateFileSize(input, maxSizeMB = 5) {
        const maxSize = maxSizeMB * 1024 * 1024; // Convertir en bytes
        const files = input.files;

        for (let i = 0; i < files.length; i++) {
            if (files[i].size > maxSize) {
                alert(`Le fichier "${files[i].name}" est trop volumineux (${(files[i].size / 1024 / 1024).toFixed(2)} Mo). Taille maximale : ${maxSizeMB} Mo.`);
                input.value = ''; // Réinitialiser l'input
                return false;
            }
        }
        return true;
    }

    // Valider l'image à la une
    document.getElementById('featured_image').addEventListener('change', function() {
        validateFileSize(this, 5);
    });

    // Valider les images de galerie
    document.getElementById('images').addEventListener('change', function() {
        if (this.files.length > 10) {
            alert('Vous ne pouvez pas uploader plus de 10 images à la fois.');
            this.value = '';
            return;
        }
        validateFileSize(this, 5);
    });

    // Status change logic
    document.getElementById('status').addEventListener('change', function() {
        const publishedField = document.getElementById('published_at_field');
        const scheduledField = document.getElementById('scheduled_at_field');

        if (this.value === 'scheduled') {
            publishedField.style.display = 'none';
            scheduledField.style.display = 'block';
        } else if (this.value === 'published') {
            publishedField.style.display = 'block';
            scheduledField.style.display = 'none';
        } else {
            publishedField.style.display = 'none';
            scheduledField.style.display = 'none';
        }
    });

    // Trigger on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('status').dispatchEvent(new Event('change'));
    });
</script>
@endpush
