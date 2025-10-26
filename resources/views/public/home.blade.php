@extends('layouts.public')

@section('title', 'Accueil')
@section('description', 'Découvrez La Maison P2A, votre spécialiste en décoration d\'intérieur et événementielle.
    Produits de qualité et services personnalisés.')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 overflow-hidden">
        <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="text-white space-y-8 animate-fade-in">
                    <div>
                        <span
                            class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium mb-4">
                            ✨ Nouveau : Collection Printemps 2025
                        </span>
                        <h1 class="text-5xl lg:text-6xl font-bold leading-tight mb-6">
                            Transformez votre
                            <span class="text-accent-light">espace de vie</span>
                        </h1>
                        <p class="text-xl text-primary-100 max-w-xl">
                            Découvrez notre collection exclusive de décoration d'intérieur et créez l'atmosphère parfaite
                            pour votre maison.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('shop.index') }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-white text-primary-500 rounded-xl font-semibold hover:bg-neutral-50 transition-all shadow-lg hover:shadow-xl">
                            <span>Explorer la boutique</span>
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                        <a href="{{ route('services') }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-white/10 backdrop-blur-sm text-white rounded-xl font-semibold hover:bg-white/20 transition-all border border-white/20">
                            Nos Services
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-8 pt-8 border-t border-white/20">
                        <div>
                            <p class="text-3xl font-bold">500+</p>
                            <p class="text-primary-100 text-sm">Clients Satisfaits</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold">{{ $featuredProducts->count() }}+</p>
                            <p class="text-primary-100 text-sm">Produits</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold">5⭐</p>
                            <p class="text-primary-100 text-sm">Note Moyenne</p>
                        </div>
                    </div>
                </div>

                <!-- Hero Image -->
                <div class="relative lg:h-[600px] hidden lg:block">
                    <div class="absolute inset-0 bg-gradient-to-tr from-primary-500/20 to-transparent rounded-3xl"></div>
                    <div class="relative h-full grid grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <div class="h-64 bg-white/10 backdrop-blur-sm rounded-2xl overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=400"
                                    alt="Décoration" class="w-full h-full object-cover">
                            </div>
                            <div class="h-48 bg-white/10 backdrop-blur-sm rounded-2xl overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=400"
                                    alt="Intérieur" class="w-full h-full object-cover">
                            </div>
                        </div>
                        <div class="space-y-4 pt-12">
                            <div class="h-48 bg-white/10 backdrop-blur-sm rounded-2xl overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1615529182904-14819c35db37?w=400" alt="Salon"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="h-64 bg-white/10 backdrop-blur-sm rounded-2xl overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1616486029423-aaa4789e8c9a?w=400" alt="Chambre"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wave Separator -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                <path
                    d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z"
                    fill="#f4f5f7" />
            </svg>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-20 bg-neutral-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-neutral-900 mb-4">Explorez nos Catégories</h2>
                <p class="text-lg text-neutral-400 max-w-2xl mx-auto">
                    Parcourez notre sélection soigneusement organisée pour trouver exactement ce dont vous avez besoin
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach ($categories as $category)
                    <a href="{{ route('shop.index', ['category' => $category->id]) }}"
                        class="group bg-white rounded-2xl p-6 hover:shadow-lg transition-all duration-300 border border-neutral-200 hover:border-primary-500">
                        <div
                            class="w-16 h-16 mx-auto mb-4 bg-primary-50 rounded-xl flex items-center justify-center group-hover:bg-primary-500 transition-colors">
                            @if ($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                    class="w-10 h-10 object-contain">
                            @else
                                <svg class="w-8 h-8 text-primary-500 group-hover:text-white transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            @endif
                        </div>
                        <h3
                            class="text-center font-semibold text-neutral-900 group-hover:text-primary-500 transition-colors">
                            {{ $category->name }}
                        </h3>
                        <p class="text-center text-xs text-neutral-400 mt-1">{{ $category->products_count }} produits</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <h2 class="text-4xl font-bold text-neutral-900 mb-4">Produits en Vedette</h2>
                    <p class="text-lg text-neutral-400">Découvrez notre sélection coup de cœur</p>
                </div>
                <a href="{{ route('shop.index') }}"
                    class="hidden md:flex items-center text-primary-500 hover:text-primary-600 font-medium">
                    Voir tout
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($featuredProducts as $product)
                    <div
                        class="group bg-neutral-50 rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 border border-neutral-200">
                        <div class="relative aspect-square overflow-hidden bg-neutral-100">
                            @if ($product->main_image)
                                <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-16 h-16 text-neutral-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif

                            @if ($product->isOnSale())
                                <span
                                    class="absolute top-4 left-4 px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full">
                                    -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                </span>
                            @endif

                            @if ($product->isOutOfStock())
                                <div class="absolute inset-0 bg-neutral-900/80 flex items-center justify-center">
                                    <span class="px-4 py-2 bg-white text-neutral-900 rounded-lg font-semibold">Rupture de
                                        stock</span>
                                </div>
                            @endif

                            <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button
                                    class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-primary-500 hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="p-5">
                            <span class="text-xs text-primary-500 font-medium">{{ $product->category->name }}</span>
                            <h3
                                class="font-semibold text-neutral-900 mt-2 mb-3 line-clamp-2 group-hover:text-primary-500 transition-colors">
                                <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>

                            <div class="flex items-center justify-between">
                                <div>
                                    @if ($product->isOnSale())
                                        <div class="flex items-center space-x-2">
                                            <span
                                                class="text-lg font-bold text-primary-500">{{ number_format($product->sale_price, 0, ',', ' ') }}
                                                FCFA</span>
                                            <span
                                                class="text-sm text-neutral-400 line-through">{{ number_format($product->price, 0, ',', ' ') }}</span>
                                        </div>
                                    @else
                                        <span
                                            class="text-lg font-bold text-neutral-900">{{ number_format($product->price, 0, ',', ' ') }}
                                            FCFA</span>
                                    @endif
                                </div>

                                @if (!$product->isOutOfStock())
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="p-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12 md:hidden">
                <a href="{{ route('shop.index') }}" class="btn-primary inline-flex items-center">
                    Voir tous les produits
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-20 bg-neutral-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-neutral-900 mb-4">Pourquoi Choisir La Maison P2A ?</h2>
                <p class="text-lg text-neutral-400 max-w-2xl mx-auto">
                    Nous nous engageons à vous offrir la meilleure expérience possible
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-20 h-20 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-primary-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Qualité Premium</h3>
                    <p class="text-neutral-400">Produits soigneusement sélectionnés pour leur qualité exceptionnelle</p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Livraison Rapide</h3>
                    <p class="text-neutral-400">Livraison sécurisée et rapide dans tout le Bénin</p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Support 24/7</h3>
                    <p class="text-neutral-400">Notre équipe est là pour vous accompagner à tout moment</p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Paiement Sécurisé</h3>
                    <p class="text-neutral-400">Transactions 100% sécurisées avec FedaPay</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-primary-500 to-primary-700 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h2 class="text-4xl lg:text-5xl font-bold mb-6">Prêt à Transformer Votre Espace ?</h2>
            <p class="text-xl text-primary-100 mb-8 max-w-2xl mx-auto">
                Découvrez notre collection complète et trouvez l'inspiration pour votre prochain projet de décoration
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('shop.index') }}" class="btn-primary bg-white text-primary-500 hover:bg-neutral-50">
                    Voir la Boutique
                </a>
                <a href="{{ route('contact') }}"
                    class="px-8 py-4 bg-white/10 backdrop-blur-sm text-white rounded-xl font-semibold hover:bg-white/20 transition-all border border-white/20">
                    Nous Contacter
                </a>
            </div>
        </div>
    </section>
@endsection
