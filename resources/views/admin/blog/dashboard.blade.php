@extends('layouts.admin')

@section('title', 'Tableau de bord Blog')
@section('page-title', 'Tableau de bord Blog')

@section('content')
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Posts -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Articles Total</p>
                    <h3 class="text-3xl font-bold">{{ $stats['total_posts'] }}</h3>
                    <p class="text-blue-100 text-xs mt-2">
                        <span class="font-semibold">{{ $stats['published_posts'] }}</span> publiés
                    </p>
                </div>
                <div class="bg-white/20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Published Posts -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium mb-1">Articles Publiés</p>
                    <h3 class="text-3xl font-bold">{{ $stats['published_posts'] }}</h3>
                    <p class="text-green-100 text-xs mt-2">
                        <span class="font-semibold">{{ $stats['draft_posts'] }}</span> brouillons
                    </p>
                </div>
                <div class="bg-white/20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Comments -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium mb-1">Commentaires</p>
                    <h3 class="text-3xl font-bold">{{ $stats['total_comments'] }}</h3>
                    <p class="text-purple-100 text-xs mt-2">
                        <span class="font-semibold">{{ $stats['pending_comments'] }}</span> en attente
                    </p>
                </div>
                <div class="bg-white/20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Newsletter Subscribers -->
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium mb-1">Abonnés Newsletter</p>
                    <h3 class="text-3xl font-bold">{{ $stats['newsletter_subscribers'] }}</h3>
                    <p class="text-orange-100 text-xs mt-2">Actifs et vérifiés</p>
                </div>
                <div class="bg-white/20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Recent Posts -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-neutral-200 bg-gradient-to-r from-neutral-50 to-white">
                <h3 class="text-lg font-bold text-neutral-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Articles Récents
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recentPosts as $post)
                        <div class="flex items-start space-x-4 p-4 rounded-xl hover:bg-neutral-50 transition-colors duration-200">
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
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-neutral-900 truncate">{{ $post->title }}</h4>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="text-xs text-neutral-500">{{ $post->author->name }}</span>
                                    <span class="text-xs text-neutral-400">•</span>
                                    <span class="text-xs text-neutral-500">{{ $post->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex items-center gap-2 mt-2">
                                    @if($post->status === 'published')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Publié
                                        </span>
                                    @elseif($post->status === 'draft')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-neutral-100 text-neutral-800">
                                            Brouillon
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Planifié
                                        </span>
                                    @endif
                                    <span class="text-xs text-neutral-400">{{ $post->views }} vues</span>
                                </div>
                            </div>
                            <a href="{{ route('admin.blog.posts.edit', $post) }}" class="text-primary hover:text-primary/80 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-neutral-500">Aucun article pour le moment</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Popular Posts -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-neutral-200 bg-gradient-to-r from-neutral-50 to-white">
                <h3 class="text-lg font-bold text-neutral-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    Articles Populaires
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($popularPosts as $post)
                        <div class="flex items-start space-x-4 p-4 rounded-xl hover:bg-neutral-50 transition-colors duration-200">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                                    class="w-16 h-16 rounded-lg object-cover">
                            @else
                                <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-primary/20 to-primary/10 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-neutral-900 truncate">{{ $post->title }}</h4>
                                <div class="flex items-center gap-2 mt-2">
                                    <div class="flex items-center text-xs text-neutral-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        {{ number_format($post->views) }} vues
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('admin.blog.posts.edit', $post) }}" class="text-primary hover:text-primary/80 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-neutral-500">Aucun article populaire</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Comments -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-neutral-200 bg-gradient-to-r from-neutral-50 to-white">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-neutral-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                    Commentaires Récents
                </h3>
                <a href="{{ route('admin.blog.comments.index') }}" class="text-sm text-primary hover:text-primary/80 font-medium">
                    Voir tout →
                </a>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($recentComments as $comment)
                    <div class="flex items-start space-x-4 p-4 rounded-xl hover:bg-neutral-50 transition-colors duration-200">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary/20 to-primary/10 flex items-center justify-center">
                                <span class="text-sm font-bold text-primary">{{ substr($comment->user->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="text-sm font-semibold text-neutral-900">{{ $comment->user->name }}</h4>
                                @if($comment->status === 'pending')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        En attente
                                    </span>
                                @elseif($comment->status === 'approved')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Approuvé
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Spam
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm text-neutral-600 line-clamp-2">{{ $comment->content }}</p>
                            <div class="flex items-center gap-3 mt-2">
                                <a href="{{ route('blog.show', $comment->post->slug) }}" target="_blank" class="text-xs text-primary hover:text-primary/80">
                                    {{ $comment->post->title }}
                                </a>
                                <span class="text-xs text-neutral-400">•</span>
                                <span class="text-xs text-neutral-500">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @if($comment->status === 'pending')
                            <div class="flex gap-2">
                                <form action="{{ route('admin.blog.comments.approve', $comment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-green-600 hover:text-green-700 transition-colors" title="Approuver">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                </form>
                                <form action="{{ route('admin.blog.comments.reject', $comment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-red-600 hover:text-red-700 transition-colors" title="Rejeter">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        <p class="text-neutral-500">Aucun commentaire pour le moment</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.blog.posts.create') }}" class="group bg-gradient-to-br from-primary to-primary/90 rounded-2xl shadow-lg p-6 text-white hover:shadow-xl transition-all duration-300 transform hover:scale-105">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="font-semibold mb-1">Nouvel Article</h4>
                    <p class="text-sm text-white/80">Créer un nouvel article</p>
                </div>
                <svg class="w-8 h-8 opacity-75 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </div>
        </a>

        <a href="{{ route('admin.blog.categories.index') }}" class="group bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white hover:shadow-xl transition-all duration-300 transform hover:scale-105">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="font-semibold mb-1">Catégories</h4>
                    <p class="text-sm text-white/80">{{ $stats['total_categories'] }} catégories</p>
                </div>
                <svg class="w-8 h-8 opacity-75 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
            </div>
        </a>

        <a href="{{ route('blog.index') }}" target="_blank" class="group bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white hover:shadow-xl transition-all duration-300 transform hover:scale-105">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="font-semibold mb-1">Voir le Blog</h4>
                    <p class="text-sm text-white/80">Aperçu public</p>
                </div>
                <svg class="w-8 h-8 opacity-75 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </div>
        </a>
    </div>
@endsection
