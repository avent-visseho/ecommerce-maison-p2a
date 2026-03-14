@extends('layouts.admin')

@section('title', 'Articles')
@section('page-title', 'Gestion des Articles')

@section('content')
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <div class="flex-1">
            <p class="text-neutral-600">Gérez tous vos articles de blog</p>
        </div>
        <a href="{{ route('admin.blog.posts.create') }}" class="btn-primary inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nouvel Article
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <form method="GET" action="{{ route('admin.blog.posts.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <label for="search" class="block text-sm font-medium text-neutral-700 mb-2">Rechercher</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}"
                    class="input-field" placeholder="Titre ou contenu...">
            </div>

            <!-- Status Filter -->
            <div>
                <label for="status" class="block text-sm font-medium text-neutral-700 mb-2">Statut</label>
                <select id="status" name="status" class="input-field">
                    <option value="">Tous les statuts</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Brouillon</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Publié</option>
                    <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Planifié</option>
                </select>
            </div>

            <!-- Category Filter -->
            <div>
                <label for="category" class="block text-sm font-medium text-neutral-700 mb-2">Catégorie</label>
                <select id="category" name="category" class="input-field">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Button -->
            <div class="md:col-span-4 flex gap-2">
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filtrer
                </button>
                <a href="{{ route('admin.blog.posts.index') }}" class="btn-outline">Réinitialiser</a>
            </div>
        </form>
    </div>

    <!-- Posts Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-neutral-50 to-white border-b border-neutral-200">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider">Article</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider">Catégorie</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider">Auteur</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider">Stats</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-neutral-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200">
                    @forelse($posts as $post)
                        <tr class="hover:bg-neutral-50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    @if($post->featured_image)
                                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                                            class="w-16 h-16 rounded-lg object-cover">
                                    @else
                                        <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-primary/20 to-primary/10 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <h3 class="text-sm font-semibold text-neutral-900 truncate">{{ $post->title }}</h3>
                                        <div class="flex items-center gap-2 mt-1">
                                            @if($post->is_featured)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    ⭐ Featured
                                                </span>
                                            @endif
                                            @if($post->tags->count() > 0)
                                                <div class="flex gap-1">
                                                    @foreach($post->tags->take(2) as $tag)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-primary/10 text-primary">
                                                            #{{ $tag->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($post->category)
                                    <span class="text-sm text-neutral-600">{{ $post->category->name }}</span>
                                @else
                                    <span class="text-sm text-neutral-400 italic">Sans catégorie</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary/20 to-primary/10 flex items-center justify-center mr-2">
                                        <span class="text-xs font-bold text-primary">{{ substr($post->author->name, 0, 1) }}</span>
                                    </div>
                                    <span class="text-sm text-neutral-600">{{ $post->author->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($post->status === 'published')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                        Publié
                                    </span>
                                @elseif($post->status === 'draft')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-neutral-100 text-neutral-800">
                                        <span class="w-2 h-2 bg-neutral-400 rounded-full mr-2"></span>
                                        Brouillon
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                        Planifié
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center text-xs text-neutral-600">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        {{ number_format($post->views) }}
                                    </div>
                                    <div class="flex items-center text-xs text-neutral-600">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                        </svg>
                                        {{ $post->allComments->count() }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-neutral-600">
                                    @if($post->status === 'published' && $post->published_at)
                                        <div class="font-medium">{{ $post->published_at->format('d/m/Y') }}</div>
                                        <div class="text-xs text-neutral-400">{{ $post->published_at->format('H:i') }}</div>
                                    @elseif($post->status === 'scheduled' && $post->scheduled_at)
                                        <div class="font-medium">{{ $post->scheduled_at->format('d/m/Y') }}</div>
                                        <div class="text-xs text-neutral-400">{{ $post->scheduled_at->format('H:i') }}</div>
                                    @else
                                        <div class="text-xs text-neutral-400">{{ $post->created_at->format('d/m/Y H:i') }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($post->status === 'published')
                                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank"
                                            class="text-neutral-400 hover:text-primary transition-colors" title="Voir">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.blog.posts.edit', $post) }}"
                                        class="text-neutral-400 hover:text-blue-600 transition-colors" title="Modifier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.blog.posts.destroy', $post) }}" method="POST"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-neutral-400 hover:text-red-600 transition-colors" title="Supprimer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12">
                                <div class="text-center">
                                    <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-neutral-900 mb-2">Aucun article trouvé</h3>
                                    <p class="text-neutral-500 mb-4">Commencez par créer votre premier article</p>
                                    <a href="{{ route('admin.blog.posts.create') }}" class="btn-primary inline-flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Créer un article
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="px-6 py-4 border-t border-neutral-200 bg-neutral-50">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endsection
