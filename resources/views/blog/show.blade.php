@extends('layouts.public')

@section('title', $post->meta_title ?? $post->title)
@section('meta_description', $post->meta_description ?? $post->excerpt)

@section('content')
    <!-- Article -->
    <article class="bg-white">
        <!-- Featured Image -->
        @if($post->featured_image)
            <div class="relative h-96 overflow-hidden bg-neutral-900">
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            </div>
        @endif

        <!-- Article Header Coloré -->
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto {{ $post->featured_image ? '-mt-20 relative z-10' : 'pt-12' }}">
                <div class="bg-gradient-to-br from-white via-primary-50/30 to-purple-50/30 rounded-3xl shadow-2xl p-6 md:p-10 border-2 border-primary-100">
                    <!-- Breadcrumb Coloré -->
                    <nav class="flex flex-wrap items-center gap-2 text-sm mb-6">
                        <a href="{{ route('home') }}" class="text-neutral-600 hover:text-primary font-medium transition-colors">Accueil</a>
                        <svg class="w-4 h-4 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="{{ route('blog.index') }}" class="text-neutral-600 hover:text-primary font-medium transition-colors">Blog</a>
                        @if($post->category)
                            <svg class="w-4 h-4 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span class="bg-gradient-to-r from-primary-600 to-purple-600 bg-clip-text text-transparent font-bold">{{ $post->category->name }}</span>
                        @endif
                    </nav>

                    <!-- Meta Info Colorée -->
                    <div class="flex flex-wrap items-center gap-3 mb-6">
                        @if($post->category)
                            <a href="{{ route('blog.category', $post->category->slug) }}"
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-gradient-to-r from-primary-500 to-purple-500 text-white shadow-lg hover:shadow-xl hover:from-primary-600 hover:to-purple-600 transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                {{ $post->category->name }}
                            </a>
                        @endif
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium bg-gradient-to-r from-amber-50 to-amber-100 text-amber-700 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $post->reading_time }} min
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ number_format($post->views) }} vues
                        </span>
                    </div>

                    <!-- Title avec Gradient -->
                    <h1 class="text-3xl md:text-5xl font-extrabold mb-8 leading-tight">
                        <span class="bg-gradient-to-r from-neutral-900 via-primary-600 to-purple-600 bg-clip-text text-transparent">
                            {{ $post->title }}
                        </span>
                    </h1>

                    <!-- Author & Social Share -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 pb-6 border-t-2 border-primary-100/50 pt-6">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-purple-500 flex items-center justify-center shadow-lg">
                                <span class="text-xl font-bold text-white">{{ substr($post->author->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <a href="{{ route('blog.author', $post->author->id) }}" class="font-bold text-lg text-neutral-900 hover:bg-gradient-to-r hover:from-primary-600 hover:to-purple-600 hover:bg-clip-text hover:text-transparent transition-all">
                                    {{ $post->author->name }}
                                </a>
                                <p class="text-sm text-neutral-600 flex items-center gap-2 mt-1">
                                    <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $post->published_at->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>

                        <!-- Social Share Buttons Colorés -->
                        <div class="flex flex-wrap gap-2">
                            <span class="text-sm font-semibold text-neutral-600 mr-2 hidden md:block">Partager:</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug)) }}" target="_blank"
                                class="p-3 rounded-xl bg-white border-2 border-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all shadow-sm hover:shadow-lg">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $post->slug)) }}&text={{ urlencode($post->title) }}" target="_blank"
                                class="p-3 rounded-xl bg-white border-2 border-sky-100 text-sky-500 hover:bg-sky-500 hover:text-white hover:border-sky-500 transition-all shadow-sm hover:shadow-lg">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blog.show', $post->slug)) }}&title={{ urlencode($post->title) }}" target="_blank"
                                class="p-3 rounded-xl bg-white border-2 border-blue-100 text-blue-700 hover:bg-blue-700 hover:text-white hover:border-blue-700 transition-all shadow-sm hover:shadow-lg">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                            <button onclick="copyLink()" class="p-3 rounded-xl bg-white border-2 border-neutral-200 text-neutral-700 hover:bg-gradient-to-r hover:from-primary-500 hover:to-purple-500 hover:text-white hover:border-primary-500 transition-all shadow-sm hover:shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Article Content -->
        <div class="container mx-auto px-4 py-12">
            <div class="max-w-4xl mx-auto">
                <!-- Content -->
                <div class="prose prose-lg prose-headings:font-bold prose-headings:text-neutral-900 prose-p:text-neutral-700 prose-a:text-primary max-w-none">
                    {!! $post->content !!}
                </div>

                <!-- Tags Colorés -->
                @if($post->tags->count() > 0)
                    <div class="mt-12 pt-8 border-t-2 border-primary-100">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-blue-500 flex items-center justify-center shadow-md">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-neutral-900">Tags</h3>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($post->tags as $tag)
                                <a href="{{ route('blog.tag', $tag->slug) }}"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold bg-white border-2 border-primary-100 text-primary-600 hover:bg-gradient-to-r hover:from-primary-500 hover:to-blue-500 hover:text-white hover:border-primary-500 transition-all shadow-sm hover:shadow-md">
                                    <span>#</span>
                                    <span>{{ $tag->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Related Posts Colorés -->
                @if($relatedPosts->count() > 0)
                    <div class="mt-16">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <h2 class="text-2xl md:text-3xl font-extrabold">
                                <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Articles similaires</span>
                            </h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($relatedPosts as $related)
                                <a href="{{ route('blog.show', $related->slug) }}"
                                    class="group bg-white border-2 border-neutral-100 rounded-2xl overflow-hidden hover:shadow-2xl hover:border-primary-200 transition-all duration-500">
                                    <div class="relative overflow-hidden h-48">
                                        @if($related->featured_image)
                                            <img src="{{ asset('storage/' . $related->featured_image) }}" alt="{{ $related->title }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                            <div class="absolute inset-0 bg-gradient-to-t from-neutral-900/40 via-transparent to-transparent"></div>
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-primary-200 via-purple-200 to-pink-200 flex items-center justify-center">
                                                <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        @if($related->category)
                                            <span class="absolute top-3 left-3 px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-primary-500 to-purple-500 text-white shadow-lg">
                                                {{ $related->category->name }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="p-5 bg-gradient-to-br from-white to-primary-50/20">
                                        <h3 class="font-bold text-neutral-900 group-hover:bg-gradient-to-r group-hover:from-primary-600 group-hover:to-purple-600 group-hover:bg-clip-text group-hover:text-transparent transition-all line-clamp-2 mb-3 leading-tight">
                                            {{ $related->title }}
                                        </h3>
                                        <div class="flex items-center gap-2 text-xs">
                                            <span class="inline-flex items-center gap-1 text-primary-600 bg-primary-50 px-2 py-1 rounded-lg font-medium">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ $related->published_at->translatedFormat('d M Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Comments Section Colorée -->
                @if($post->allow_comments)
                    <div class="mt-16 bg-gradient-to-br from-neutral-50 to-primary-50/30 rounded-3xl p-6 md:p-10 border-2 border-primary-100 shadow-lg">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl md:text-3xl font-extrabold">
                                <span class="bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                                    Commentaires ({{ $post->approvedComments->count() }})
                                </span>
                            </h2>
                        </div>

                        <!-- Comment Form -->
                        @auth
                            <form action="{{ route('blog.comments.store') }}" method="POST" class="mb-8 bg-white rounded-2xl p-6 md:p-8 border-2 border-amber-100 shadow-lg">
                                @csrf
                                <input type="hidden" name="blog_post_id" value="{{ $post->id }}">
                                <div class="mb-5">
                                    <label for="content" class="flex items-center gap-2 text-sm font-bold text-neutral-900 mb-3">
                                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Votre commentaire
                                    </label>
                                    <textarea id="content" name="content" rows="4" required
                                        class="w-full px-5 py-4 border-2 border-amber-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 shadow-sm transition-all"
                                        placeholder="Partagez votre avis..."></textarea>
                                    @error('content')
                                        <p class="mt-2 text-sm text-red-600 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <button type="submit" class="px-8 py-3.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl hover:from-amber-600 hover:to-orange-600 transition-all font-bold shadow-lg hover:shadow-xl flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                    Publier le commentaire
                                </button>
                            </form>
                        @else
                            <div class="mb-8 bg-white rounded-2xl p-8 text-center border-2 border-dashed border-primary-200 shadow-lg">
                                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-primary-100 to-purple-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <p class="text-neutral-700 mb-5 font-medium">Connectez-vous pour laisser un commentaire</p>
                                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-primary-500 to-purple-500 text-white rounded-xl hover:from-primary-600 hover:to-purple-600 transition-all font-bold shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    Se connecter
                                </a>
                            </div>
                        @endauth

                        <!-- Comments List -->
                        <div class="space-y-6">
                            @forelse($post->approvedComments as $comment)
                                <div class="bg-white rounded-2xl p-6 md:p-8 border-2 border-neutral-100 hover:border-primary-100 transition-all shadow-md">
                                    <div class="flex items-start gap-4">
                                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-purple-500 flex items-center justify-center flex-shrink-0 shadow-lg">
                                            <span class="text-xl font-bold text-white">{{ substr($comment->user->name, 0, 1) }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex flex-wrap items-center gap-3 mb-3">
                                                <h4 class="font-bold text-lg text-neutral-900">{{ $comment->user->name }}</h4>
                                                <span class="inline-flex items-center gap-1 text-xs text-neutral-600 bg-neutral-100 px-3 py-1 rounded-lg">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    {{ $comment->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            <p class="text-neutral-700 leading-relaxed">{{ $comment->content }}</p>

                                            <!-- Replies -->
                                            @if($comment->replies->count() > 0)
                                                <div class="mt-6 pl-6 md:pl-10 border-l-4 border-primary-100 space-y-4">
                                                    @foreach($comment->replies as $reply)
                                                        <div class="flex items-start gap-3 bg-primary-50/30 p-4 rounded-xl">
                                                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center flex-shrink-0 shadow-md">
                                                                <span class="text-sm font-bold text-white">{{ substr($reply->user->name, 0, 1) }}</span>
                                                            </div>
                                                            <div class="flex-1">
                                                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                                                    <h5 class="font-bold text-neutral-900">{{ $reply->user->name }}</h5>
                                                                    <span class="text-xs text-neutral-500 bg-white px-2 py-1 rounded-lg">{{ $reply->created_at->diffForHumans() }}</span>
                                                                </div>
                                                                <p class="text-sm text-neutral-700 leading-relaxed">{{ $reply->content }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-16 bg-white rounded-2xl border-2 border-dashed border-neutral-200">
                                    <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-neutral-100 to-primary-100 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-neutral-900 mb-2">Aucun commentaire pour le moment</h3>
                                    <p class="text-neutral-500">Soyez le premier à partager votre avis!</p>
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
