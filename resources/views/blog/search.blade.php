@extends('layouts.public')

@section('title', 'Blog - La Maison P2A')

@section('content')
    <!-- Hero Section with Featured Post -->
    <div class="bg-gradient-to-br from-primary/5 via-white to-primary/5 py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center mb-12">
                <h1 class="text-5xl font-bold text-neutral-900 mb-4">Notre Blog</h1>
                <p class="text-xl text-neutral-600">Découvrez nos conseils, tendances et inspirations déco</p>
            </div>

            @if($featuredPosts->count() > 0)
                @php $featured = $featuredPosts->first(); @endphp
                <div class="max-w-6xl mx-auto">
                    <a href="{{ route('blog.show', $featured->slug) }}"
                        class="group block bg-white rounded-3xl shadow-2xl overflow-hidden hover:shadow-3xl transition-all duration-500 transform hover:-translate-y-2">
                        <div class="grid md:grid-cols-2 gap-0">
                            <div class="relative overflow-hidden h-80 md:h-auto">
                                @if($featured->featured_image)
                                    <img src="{{ asset('storage/' . $featured->featured_image) }}" alt="{{ $featured->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-primary/20 to-primary/5 flex items-center justify-center">
                                        <svg class="w-24 h-24 text-primary/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-6 left-6">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-yellow-400 text-yellow-900 shadow-lg">
                                        ⭐ Article vedette
                                    </span>
                                </div>
                            </div>
                            <div class="p-10 flex flex-col justify-center">
                                @if($featured->category)
                                    <span class="inline-block text-sm font-semibold text-primary mb-3">{{ $featured->category->name }}</span>
                                @endif
                                <h2 class="text-3xl font-bold text-neutral-900 mb-4 group-hover:text-primary transition-colors">
                                    {{ $featured->title }}
                                </h2>
                                <p class="text-neutral-600 mb-6 leading-relaxed">
                                    {{ $featured->excerpt ?? Str::limit(strip_tags($featured->content), 150) }}
                                </p>
                                <div class="flex items-center gap-6 text-sm text-neutral-500">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary/20 to-primary/10 flex items-center justify-center mr-3">
                                            <span class="text-sm font-bold text-primary">{{ substr($featured->author->name, 0, 1) }}</span>
                                        </div>
                                        <span class="font-medium">{{ $featured->author->name }}</span>
                                    </div>
                                    <span>{{ $featured->published_at->format('d M Y') }}</span>
                                    <span>{{ $featured->reading_time }} min de lecture</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Posts Grid -->
            <div class="lg:col-span-2">
                <!-- Search & Filter Bar -->
                <div class="bg-white rounded-2xl shadow-sm p-6 mb-8">
                    <form method="GET" action="{{ route('blog.index') }}" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Rechercher un article..."
                                class="w-full px-4 py-3 border border-neutral-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        <select name="category" class="px-4 py-3 border border-neutral-200 rounded-xl focus:ring-2 focus:ring-primary">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <select name="sort" class="px-4 py-3 border border-neutral-200 rounded-xl focus:ring-2 focus:ring-primary">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Plus récents</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Plus populaires</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Plus anciens</option>
                        </select>
                        <button type="submit" class="px-6 py-3 bg-primary text-white rounded-xl hover:bg-primary/90 transition-colors font-medium">
                            Filtrer
                        </button>
                    </form>
                </div>

                <!-- Articles Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @forelse($posts as $post)
                        <article class="group bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <a href="{{ route('blog.show', $post->slug) }}" class="block">
                                <div class="relative overflow-hidden h-56">
                                    @if($post->featured_image)
                                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-primary/10 to-primary/5 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-primary/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    @if($post->category)
                                        <span class="absolute top-4 left-4 inline-block px-3 py-1 rounded-full text-xs font-semibold bg-white/90 backdrop-blur-sm text-primary shadow-lg">
                                            {{ $post->category->name }}
                                        </span>
                                    @endif
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-neutral-900 mb-3 group-hover:text-primary transition-colors line-clamp-2">
                                        {{ $post->title }}
                                    </h3>
                                    <p class="text-neutral-600 mb-4 line-clamp-3 text-sm leading-relaxed">
                                        {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}
                                    </p>
                                    <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary/20 to-primary/10 flex items-center justify-center">
                                                <span class="text-xs font-bold text-primary">{{ substr($post->author->name, 0, 1) }}</span>
                                            </div>
                                            <span class="text-sm text-neutral-600">{{ $post->author->name }}</span>
                                        </div>
                                        <div class="flex items-center gap-3 text-xs text-neutral-500">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                {{ number_format($post->views) }}
                                            </span>
                                            <span>{{ $post->published_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </article>
                    @empty
                        <div class="col-span-2 text-center py-20">
                            <svg class="w-20 h-20 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="text-2xl font-bold text-neutral-900 mb-2">Aucun article trouvé</h3>
                            <p class="text-neutral-500">Essayez de modifier vos filtres ou revenez plus tard</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($posts->hasPages())
                    <div class="mt-12">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <aside class="space-y-8">
                <!-- Newsletter Subscribe -->
                <div class="bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl p-8 text-white shadow-xl">
                    <h3 class="text-2xl font-bold mb-3">Newsletter</h3>
                    <p class="text-white/90 mb-6">Recevez nos derniers articles directement dans votre boîte mail</p>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST">
                        @csrf
                        <div class="space-y-3">
                            <input type="email" name="email" required
                                placeholder="Votre email"
                                class="w-full px-4 py-3 rounded-xl text-neutral-900 focus:ring-2 focus:ring-white border-0">
                            <button type="submit" class="w-full px-4 py-3 bg-white text-primary-600 rounded-xl hover:bg-neutral-50 transition-colors font-semibold">
                                S'abonner
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Popular Posts -->
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <h3 class="text-xl font-bold text-neutral-900 mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Articles Populaires
                    </h3>
                    <div class="space-y-4">
                        @foreach($popularPosts as $popular)
                            <a href="{{ route('blog.show', $popular->slug) }}" class="group flex gap-4 hover:bg-neutral-50 p-3 rounded-xl transition-colors">
                                @if($popular->featured_image)
                                    <img src="{{ asset('storage/' . $popular->featured_image) }}" alt="{{ $popular->title }}"
                                        class="w-20 h-20 rounded-lg object-cover">
                                @else
                                    <div class="w-20 h-20 rounded-lg bg-gradient-to-br from-primary/10 to-primary/5 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-8 h-8 text-primary/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-sm text-neutral-900 line-clamp-2 group-hover:text-primary transition-colors mb-2">
                                        {{ $popular->title }}
                                    </h4>
                                    <div class="flex items-center text-xs text-neutral-500">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        {{ number_format($popular->views) }} vues
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Categories -->
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <h3 class="text-xl font-bold text-neutral-900 mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Catégories
                    </h3>
                    <div class="space-y-2">
                        @foreach($categories as $category)
                            <a href="{{ route('blog.category', $category->slug) }}"
                                class="flex items-center justify-between p-3 rounded-lg hover:bg-neutral-50 transition-colors group">
                                <span class="font-medium text-neutral-700 group-hover:text-primary">{{ $category->name }}</span>
                                <span class="text-xs text-neutral-500 bg-neutral-100 px-2 py-1 rounded-full">
                                    {{ $category->published_posts_count }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Tags -->
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <h3 class="text-xl font-bold text-neutral-900 mb-6">Tags Populaires</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                            <a href="{{ route('blog.tag', $tag->slug) }}"
                                class="inline-block px-4 py-2 rounded-full text-sm font-medium bg-primary/10 text-primary hover:bg-primary hover:text-white transition-colors">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection
