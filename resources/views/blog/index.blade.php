@extends('layouts.public')

@section('title', 'Blog - La Maison P2A')

@section('content')
    <!-- Hero Section Coloré -->
    <div class="relative bg-gradient-to-br from-primary-50 via-white to-purple-50 border-b border-neutral-100 overflow-hidden">
        <!-- Decorative circles -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-primary-200/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-purple-200/20 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-4 py-20 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-flex items-center gap-2 px-5 py-2.5 bg-neutral-400 rounded-full mb-6 shadow-lg">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    <span class="text-sm font-bold text-white">{{ __('blog.hero_badge') }}</span>
                </div>

                <h1 class="text-5xl md:text-6xl font-extrabold mb-6">
                    <span class="bg-neutral-400  bg-clip-text text-transparent">{{ __('blog.hero_title') }}</span>
                </h1>

                <p class="text-xl text-neutral-600 leading-relaxed max-w-2xl mx-auto">
                    {!! __('blog.hero_description', [
                        'expert' => '<span class="text-primary-600 font-semibold">' . __('blog.expert_advice') . '</span>',
                        'trends' => '<span class="text-neutral-400 font-semibold">' . __('blog.latest_trends') . '</span>'
                    ]) !!}
                </p>
            </div>
        </div>
    </div>

    <!-- Featured Post Coloré -->
    @if($featuredPosts->count() > 0)
        @php $featured = $featuredPosts->first(); @endphp
        <div class="bg-gradient-to-br from-neutral-50 to-primary-50/30 py-12">
            <div class="container mx-auto px-4">
                <div class="max-w-6xl mx-auto">
                    <a href="{{ route('blog.show', $featured->slug) }}"
                        class="group block bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 border border-primary-100/50 hover:border-primary-200">
                        <div class="grid md:grid-cols-2 gap-0">
                            <!-- Image -->
                            <div class="relative overflow-hidden h-80 md:h-auto">
                                @if($featured->featured_image)
                                    <img src="{{ asset('storage/' . $featured->featured_image) }}" alt="{{ $featured->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    <div class="absolute inset-0 bg-gradient-to-t from-primary-900/60 via-transparent to-transparent"></div>
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-primary-400 via-primary-300 to-purple-300 flex items-center justify-center">
                                        <svg class="w-24 h-24 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif

                                <div class="absolute top-6 left-6">
                                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-amber-400 to-orange-500 text-white shadow-2xl">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        {{ __('blog.featured') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-10 flex flex-col justify-center bg-gradient-to-br from-white to-primary-50/20">
                                @if($featured->category)
                                    <span class="inline-block px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-amber-400 to-orange-500 text-white w-fit mb-5 shadow-lg">
                                        {{ $featured->category->name }}
                                    </span>
                                @endif

                                <h2 class="text-2xl md:text-3xl font-extrabold text-neutral-900 mb-4 group-hover:text-primary transition-colors leading-tight">
                                    {{ $featured->title }}
                                </h2>

                                <p class="text-neutral-600 mb-6 line-clamp-3 leading-relaxed">
                                    {{ $featured->excerpt ?? Str::limit(strip_tags($featured->content), 150) }}
                                </p>

                                <div class="flex items-center gap-4 pt-6 border-t border-primary-100">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-full bg-neutral-900 flex items-center justify-center shadow-lg">
                                            <span class="text-base font-bold text-white">{{ substr($featured->author->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-neutral-900">{{ $featured->author->name }}</p>
                                            <p class="text-xs text-neutral-500">{{ $featured->published_at->translatedFormat('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="ml-auto flex items-center gap-4 text-sm text-neutral-600">
                                        <span class="flex items-center gap-1.5 bg-primary-50 px-3 py-1.5 rounded-lg">
                                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $featured->reading_time }} min
                                        </span>
                                        <span class="flex items-center gap-1.5 bg-purple-50 px-3 py-1.5 rounded-lg">
                                            <svg class="w-4 h-4 text-neutral-900 " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            {{ number_format($featured->views) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="bg-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Posts Grid -->
                <div class="lg:col-span-2">
                    <!-- Search & Filter Bar Coloré -->
                    <div class="bg-gradient-to-br from-white via-primary-50/30 to-purple-50/30 border-2 border-primary-100 rounded-2xl p-6 mb-8 shadow-lg">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 rounded-xl bg-neutral-400  flex items-center justify-center shadow-md">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-neutral-900">{{ __('blog.search_filter_title') }}</h3>
                        </div>

                        <form method="GET" action="{{ route('blog.index') }}" id="filterForm">
                            <div class="grid md:grid-cols-4 gap-4">
                                <!-- Recherche avec icône -->
                                <div class="md:col-span-2">
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            placeholder="{{ __('blog.search_placeholder') }}"
                                            class="w-full pl-12 pr-4 py-3 border-2 border-primary-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white shadow-sm transition-all">
                                    </div>
                                </div>

                                <!-- Catégorie avec icône -->
                                <div>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                        </div>
                                        <select name="category" onchange="document.getElementById('filterForm').submit()"
                                            class="w-full pl-12 pr-4 py-3 border-2 border-purple-200 rounded-xl focus:ring-2 focus:ring-neutral-400 focus:border-neutral-400 bg-white shadow-sm appearance-none cursor-pointer transition-all">
                                            <option value="">{{ __('blog.all_categories') }}</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tri avec icône -->
                                <div>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                            </svg>
                                        </div>
                                        <select name="sort" onchange="document.getElementById('filterForm').submit()"
                                            class="w-full pl-12 pr-4 py-3 border-2 border-amber-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 bg-white shadow-sm appearance-none cursor-pointer transition-all">
                                            <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>{{ __('blog.newest') }}</option>
                                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>{{ __('blog.popular') }}</option>
                                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>{{ __('blog.oldest') }}</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 flex gap-3">
                                <button type="submit" class="px-8 py-3 bg-neutral-400 text-white rounded-xl hover:from-primary-600 hover:to-purple-600 transition-all font-bold shadow-lg hover:shadow-xl flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    {{ __('blog.search_button') }}
                                </button>
                                @if(request('search') || request('category') || request('sort'))
                                    <a href="{{ route('blog.index') }}" class="px-6 py-3 bg-white border-2 border-neutral-200 text-neutral-700 rounded-xl hover:bg-neutral-50 transition-all font-medium shadow-sm flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        {{ __('blog.reset_button') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                <!-- Articles Grid Colorés -->
                <div class="grid grid-cols-1 gap-6">
                    @forelse($posts as $post)
                        <article class="group bg-white border-2 border-neutral-100 rounded-2xl overflow-hidden hover:shadow-2xl hover:border-primary-200 transition-all duration-500">
                            <a href="{{ route('blog.show', $post->slug) }}" class="block md:flex">
                                <!-- Image -->
                                <div class="relative overflow-hidden md:w-72 h-56 md:h-auto flex-shrink-0">
                                    @if($post->featured_image)
                                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        <div class="absolute inset-0 bg-gradient-to-t from-neutral-900/40 via-transparent to-transparent"></div>
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-primary-200 via-purple-200 to-amber-200 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif

                                    @if($post->category)
                                        <span class="absolute top-4 left-4 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-gradient-to-r from-primary-500 to-purple-500 text-white shadow-xl">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            {{ $post->category->name }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="p-8 flex-1 bg-gradient-to-br from-white to-primary-50/20">
                                    <h3 class="text-xl md:text-2xl font-bold text-neutral-900 mb-3 group-hover:bg-gradient-to-r group-hover:from-primary-600 group-hover:to-purple-600 group-hover:bg-clip-text group-hover:text-transparent transition-all duration-300 line-clamp-2 leading-tight">
                                        {{ $post->title }}
                                    </h3>
                                    <p class="text-neutral-600 mb-5 line-clamp-2 text-sm leading-relaxed">
                                        {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}
                                    </p>

                                    <!-- Meta Info Colorée -->
                                    <div class="flex flex-wrap items-center gap-3 pt-5 border-t-2 border-primary-100/50">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-10 h-10 rounded-xl bg-neutral-400 flex items-center justify-center shadow-md">
                                                <span class="text-sm font-bold text-white">{{ substr($post->author->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-neutral-900">{{ $post->author->name }}</p>
                                                <p class="text-xs text-neutral-500">{{ $post->published_at->translatedFormat('d M Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="ml-auto flex flex-wrap items-center gap-2 text-sm">
                                            <span class="flex items-center gap-1.5 bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 px-3 py-1.5 rounded-lg font-medium">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                {{ number_format($post->views) }}
                                            </span>
                                            <span class="flex items-center gap-1.5 bg-gradient-to-r from-amber-50 to-amber-100 text-amber-700 px-3 py-1.5 rounded-lg font-medium">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $post->reading_time }} min
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </article>
                    @empty
                        <div class="text-center py-20 bg-gradient-to-br from-neutral-50 to-primary-50/30 rounded-2xl border-2 border-dashed border-neutral-200">
                            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-primary-100 to-purple-100 flex items-center justify-center">
                                <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-neutral-900 mb-2">{{ __('blog.no_posts_title') }}</h3>
                            <p class="text-neutral-500 mb-6">{{ __('blog.no_posts_description') }}</p>
                            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-neutral-400 text-white rounded-xl hover:bg-neutral-400 transition-all font-bold shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                {{ __('blog.view_all_posts') }}
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($posts->hasPages())
                    <div class="mt-8">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>

            <!-- Sidebar Coloré -->
            <aside class="space-y-6">
                <!-- Newsletter Colorée -->
                <div class="relative bg-neutral-400 rounded-2xl p-8 text-white overflow-hidden shadow-2xl">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-purple-400/20 rounded-full blur-2xl"></div>

                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">{{ __('blog.newsletter_title') }}</h3>
                        <p class="text-white/90 text-sm mb-5 leading-relaxed">{{ __('blog.newsletter_description') }}</p>
                        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-3">
                            @csrf
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <input type="email" name="email" required
                                    placeholder="{{ __('blog.email_placeholder') }}"
                                    class="w-full pl-12 pr-4 py-3.5 rounded-xl text-neutral-900 border-0 shadow-lg focus:ring-4 focus:ring-white/30 transition-all">
                            </div>
                            <button type="submit" class="w-full px-4 py-3.5 bg-white text-primary rounded-xl hover:bg-neutral-50 transition-all font-bold shadow-xl hover:shadow-2xl flex items-center justify-center gap-2 group">
                                <span>{{ __('blog.subscribe_button') }}</span>
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Popular Posts Colorés -->
                <div class="bg-white border-2 border-purple-100 rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-neutral-900">{{ __('blog.popular_posts') }}</h3>
                    </div>
                    <div class="space-y-4">
                        @foreach($popularPosts as $popular)
                            <a href="{{ route('blog.show', $popular->slug) }}" class="group flex gap-3 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 p-3 rounded-xl transition-all border-2 border-transparent hover:border-purple-100">
                                @if($popular->featured_image)
                                    <img src="{{ asset('storage/' . $popular->featured_image) }}" alt="{{ $popular->title }}"
                                        class="w-20 h-20 rounded-xl object-cover shadow-md group-hover:shadow-lg transition-shadow">
                                @else
                                    <div class="w-20 h-20 rounded-xl bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center flex-shrink-0 shadow-md">
                                        <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-sm text-neutral-900 line-clamp-2 group-hover:text-purple-600 transition-colors leading-tight mb-2">
                                        {{ $popular->title }}
                                    </h4>
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center gap-1 text-xs text-purple-600 bg-purple-50 px-2 py-1 rounded-lg font-medium">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            {{ number_format($popular->views) }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Categories Colorées -->
                <div class="bg-white border-2 border-amber-100 rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-neutral-900">{{ __('blog.categories') }}</h3>
                    </div>
                    <div class="space-y-2">
                        @foreach($categories as $category)
                            <a href="{{ route('blog.category', $category->slug) }}"
                                class="flex items-center justify-between p-3 rounded-xl hover:bg-gradient-to-r hover:from-amber-50 hover:to-orange-50 transition-all group border-2 border-transparent hover:border-amber-100">
                                <span class="font-medium text-neutral-700 group-hover:text-amber-600 group-hover:font-bold transition-all">{{ $category->name }}</span>
                                <span class="text-xs font-bold text-amber-600 bg-gradient-to-r from-amber-50 to-orange-50 px-3 py-1.5 rounded-lg group-hover:from-amber-100 group-hover:to-orange-100 transition-all shadow-sm">
                                    {{ $category->published_posts_count }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Tags Colorés -->
                <div class="bg-gradient-to-br from-white to-primary-50/50 border-2 border-primary-100 rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-blue-500 flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-neutral-900">{{ __('blog.popular_tags') }}</h3>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                            <a href="{{ route('blog.tag', $tag->slug) }}"
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold bg-white border-2 border-primary-100 text-primary-600 hover:bg-gradient-to-r hover:from-primary-500 hover:to-blue-500 hover:text-white hover:border-primary-500 transition-all shadow-sm hover:shadow-md">
                                <span>#</span>
                                <span>{{ $tag->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection
