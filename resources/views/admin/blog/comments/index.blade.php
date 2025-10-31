@extends('layouts.admin')

@section('title', 'Commentaires')
@section('page-title', 'Modération des Commentaires')

@section('content')
    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <form method="GET" action="{{ route('admin.blog.comments.index') }}" class="flex items-end gap-4">
            <div class="flex-1">
                <label for="status" class="block text-sm font-medium text-neutral-700 mb-2">Filtrer par statut</label>
                <select id="status" name="status" class="input-field">
                    <option value="">Tous les commentaires</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approuvés</option>
                    <option value="spam" {{ request('status') === 'spam' ? 'selected' : '' }}>Spam</option>
                </select>
            </div>
            <button type="submit" class="btn-primary">Filtrer</button>
            <a href="{{ route('admin.blog.comments.index') }}" class="btn-outline">Réinitialiser</a>
        </form>
    </div>

    <!-- Comments List -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="divide-y divide-neutral-200">
            @forelse($comments as $comment)
                <div class="p-6 hover:bg-neutral-50 transition-colors duration-150">
                    <div class="flex items-start gap-4">
                        <!-- User Avatar -->
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary/20 to-primary/10 flex items-center justify-center">
                                <span class="text-lg font-bold text-primary">{{ substr($comment->user->name, 0, 1) }}</span>
                            </div>
                        </div>

                        <!-- Comment Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-2">
                                <h4 class="text-sm font-semibold text-neutral-900">{{ $comment->user->name }}</h4>
                                <span class="text-sm text-neutral-500">{{ $comment->user->email }}</span>
                                <span class="text-xs text-neutral-400">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>

                            <p class="text-neutral-700 mb-3">{{ $comment->content }}</p>

                            <div class="flex items-center gap-4">
                                <a href="{{ route('blog.show', $comment->post->slug) }}" target="_blank"
                                    class="text-sm text-primary hover:text-primary/80 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    {{ Str::limit($comment->post->title, 50) }}
                                </a>

                                @if($comment->status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2 animate-pulse"></span>
                                        En attente
                                    </span>
                                @elseif($comment->status === 'approved')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                        Approuvé
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                        Spam
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col gap-2">
                            @if($comment->status === 'pending')
                                <form action="{{ route('admin.blog.comments.approve', $comment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Approuver
                                    </button>
                                </form>
                                <form action="{{ route('admin.blog.comments.reject', $comment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                        </svg>
                                        Marquer Spam
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.blog.comments.destroy', $comment) }}" method="POST"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                    <h3 class="text-lg font-medium text-neutral-900 mb-2">Aucun commentaire</h3>
                    <p class="text-neutral-500">Il n'y a aucun commentaire pour le moment</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($comments->hasPages())
            <div class="px-6 py-4 border-t border-neutral-200 bg-neutral-50">
                {{ $comments->links() }}
            </div>
        @endif
    </div>
@endsection
