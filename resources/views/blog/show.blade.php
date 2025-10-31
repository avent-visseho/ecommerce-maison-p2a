@extends('layouts.public')

@section('title', $post->meta_title ?? $post->title)
@section('meta_description', $post->meta_description ?? $post->excerpt)

@section('content')
    <!-- Article Hero -->
    <article class="bg-white">
        <!-- Featured Image -->
        @if($post->featured_image)
            <div class="relative h-96 md:h-[32rem] overflow-hidden bg-neutral-900">
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                    class="w-full h-full object-cover opacity-90">
                <div class="absolute inset-0 bg-gradient-to-t from-neutral-900 via-neutral-900/50 to-transparent"></div>
            </div>
        @endif

        <!-- Article Header -->
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto {{ $post->featured_image ? '-mt-32 relative z-10' : 'pt-16' }}">
                <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12">
                    <!-- Category & Reading Time -->
                    <div class="flex items-center gap-4 mb-6">
                        @if($post->category)
                            <a href="{{ route('blog.category', $post->category->slug) }}"
                                class="inline-block px-4 py-2 rounded-full text-sm font-semibold bg-primary/10 text-primary hover:bg-primary hover:text-white transition-colors">
                                {{ $post->category->name }}
                            </a>
                        @endif
                        <span class="flex items-center text-sm text-neutral-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $post->reading_time }} min de lecture
                        </span>
                        <span class="flex items-center text-sm text-neutral-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ number_format($post->views) }} vues
                        </span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 mb-6 leading-tight">{{ $post->title }}</h1>

                    <!-- Author & Date -->
                    <div class="flex items-center justify-between pb-8 border-b border-neutral-200">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-primary/20 to-primary/10 flex items-center justify-center">
                                <span class="text-xl font-bold text-primary">{{ substr($post->author->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <a href="{{ route('blog.author', $post->author->id) }}" class="font-semibold text-neutral-900 hover:text-primary transition-colors">
                                    {{ $post->author->name }}
                                </a>
                                <p class="text-sm text-neutral-500">{{ $post->published_at->format('d F Y') }}</p>
                            </div>
                        </div>

                        <!-- Social Share Buttons -->
                        <div class="flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug)) }}" target="_blank"
                                class="p-3 rounded-full bg-neutral-100 hover:bg-blue-600 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $post->slug)) }}&text={{ urlencode($post->title) }}" target="_blank"
                                class="p-3 rounded-full bg-neutral-100 hover:bg-sky-500 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blog.show', $post->slug)) }}&title={{ urlencode($post->title) }}" target="_blank"
                                class="p-3 rounded-full bg-neutral-100 hover:bg-blue-700 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                            <button onclick="copyLink()" class="p-3 rounded-full bg-neutral-100 hover:bg-neutral-800 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Article Content -->
        <div class="container mx-auto px-4 py-16">
            <div class="max-w-4xl mx-auto">
                <div class="prose prose-lg max-w-none">
                    {!! $post->content !!}
                </div>

                <!-- Tags -->
                @if($post->tags->count() > 0)
                    <div class="mt-12 pt-8 border-t border-neutral-200">
                        <h3 class="text-lg font-semibold text-neutral-900 mb-4">Tags</h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($post->tags as $tag)
                                <a href="{{ route('blog.tag', $tag->slug) }}"
                                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-neutral-100 text-neutral-700 hover:bg-primary hover:text-white transition-colors">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Related Posts -->
                @if($relatedPosts->count() > 0)
                    <div class="mt-16">
                        <h2 class="text-3xl font-bold text-neutral-900 mb-8">Articles similaires</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($relatedPosts as $related)
                                <a href="{{ route('blog.show', $related->slug) }}"
                                    class="group bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300">
                                    @if($related->featured_image)
                                        <img src="{{ asset('storage/' . $related->featured_image) }}" alt="{{ $related->title }}"
                                            class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-40 bg-gradient-to-br from-primary/10 to-primary/5"></div>
                                    @endif
                                    <div class="p-4">
                                        <h3 class="font-semibold text-neutral-900 group-hover:text-primary transition-colors line-clamp-2 mb-2">
                                            {{ $related->title }}
                                        </h3>
                                        <p class="text-xs text-neutral-500">{{ $related->published_at->format('d M Y') }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Comments Section -->
                @if($post->allow_comments)
                    <div class="mt-16 bg-neutral-50 rounded-2xl p-8">
                        <h2 class="text-3xl font-bold text-neutral-900 mb-8">
                            Commentaires ({{ $post->approvedComments->count() }})
                        </h2>

                        <!-- Comment Form -->
                        @auth
                            <form action="{{ route('blog.comments.store') }}" method="POST" class="mb-12 bg-white rounded-xl p-6 shadow-sm">
                                @csrf
                                <input type="hidden" name="blog_post_id" value="{{ $post->id }}">
                                <div class="mb-4">
                                    <label for="content" class="block text-sm font-medium text-neutral-700 mb-2">Votre commentaire</label>
                                    <textarea id="content" name="content" rows="4" required
                                        class="w-full px-4 py-3 border border-neutral-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent"
                                        placeholder="Partagez votre avis..."></textarea>
                                    @error('content')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex items-center gap-4">
                                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-primary/80 text-white rounded-xl hover:shadow-lg hover:scale-105 transition-all font-semibold">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                        </svg>
                                        Publier le commentaire
                                    </button>
                                    <p class="text-xs text-neutral-500">Votre commentaire sera visible après modération</p>
                                </div>
                            </form>
                        @else
                            <div class="mb-12 bg-white rounded-xl p-6 shadow-sm text-center">
                                <p class="text-neutral-600 mb-4">Connectez-vous pour laisser un commentaire</p>
                                <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-primary text-white rounded-xl hover:bg-primary/90 transition-colors font-semibold">
                                    Se connecter
                                </a>
                            </div>
                        @endauth

                        <!-- Comments List -->
                        <div class="space-y-6">
                            @forelse($post->approvedComments as $comment)
                                <div class="bg-white rounded-xl p-6 shadow-sm">
                                    <div class="flex items-start gap-4">
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary/20 to-primary/10 flex items-center justify-center flex-shrink-0">
                                            <span class="text-lg font-bold text-primary">{{ substr($comment->user->name, 0, 1) }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <h4 class="font-semibold text-neutral-900">{{ $comment->user->name }}</h4>
                                                <span class="text-sm text-neutral-500">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-neutral-700 leading-relaxed">{{ $comment->content }}</p>

                                            <!-- Replies -->
                                            @if($comment->replies->count() > 0)
                                                <div class="mt-6 pl-8 border-l-2 border-neutral-200 space-y-4">
                                                    @foreach($comment->replies as $reply)
                                                        <div class="flex items-start gap-3">
                                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary/10 to-primary/5 flex items-center justify-center flex-shrink-0">
                                                                <span class="text-sm font-bold text-primary">{{ substr($reply->user->name, 0, 1) }}</span>
                                                            </div>
                                                            <div class="flex-1">
                                                                <div class="flex items-center gap-2 mb-1">
                                                                    <h5 class="font-medium text-neutral-900">{{ $reply->user->name }}</h5>
                                                                    <span class="text-xs text-neutral-500">{{ $reply->created_at->diffForHumans() }}</span>
                                                                </div>
                                                                <p class="text-sm text-neutral-700">{{ $reply->content }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                    </svg>
                                    <p class="text-neutral-500">Aucun commentaire pour le moment. Soyez le premier à commenter !</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </article>

    @push('scripts')
    <script>
        function copyLink() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                alert('Lien copié dans le presse-papier !');
            });
        }
    </script>
    @endpush
@endsection
