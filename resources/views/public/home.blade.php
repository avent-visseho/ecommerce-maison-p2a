@extends('layouts.public')

@section('title', 'Accueil')
@section('description',
    'Découvrez La Maison P2A, votre spécialiste en décoration d\'intérieur et événementielle.
    Produits de qualité et services personnalisés.')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-neutral-300 overflow-hidden">
        <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="text-white space-y-8 animate-fade-in">
                    <div>
                        <span
                            class="inline-block px-4 py-2 bg-primary-500/20 backdrop-blur-sm rounded-full text-sm font-medium mb-4 text-primary-100">
                             Nouveau: collection printemps/été 2026
                        </span>
                        <h1 class="text-5xl lg:text-6xl font-bold leading-tight mb-6">
                            Sublimez vos
                            <span
                                class="text-primary-500 bg-gradient-to-r from-primary-100 via-primary-500 to-primary-800 bg-clip-text text-transparent">espaces
                                et vos événements</span>
                        </h1>
                        <p class="text-xl text-neutral-50 max-w-xl">
                            Découvrez notre univers de décoration d’intérieur et laissez-vous inspirer par nos créations
                            événementielles sur-mesure. Ambiances uniques, élégance et personnalisation sont au cœur de
                            notre savoir-faire
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('shop.index') }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-primary-100 via-primary-500 to-primary-800 text-neutral-900 rounded-xl font-semibold hover:shadow-2xl transition-all shadow-lg hover:scale-105">
                            <span>Explorer la boutique</span>
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                        <a href="{{ route('services') }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-white/10 backdrop-blur-sm text-white rounded-xl font-semibold hover:bg-white/20 transition-all border border-primary-500/30">
                            Nos Services
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-8 pt-8 border-t border-primary-500/30">
                        <div>
                            <p class="text-3xl font-bold text-primary-500">500+</p>
                            <p class="text-primary-100 text-sm">Clients Satisfaits</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-primary-500">{{ $featuredProducts->count() }}+</p>
                            <p class="text-primary-100 text-sm">Produits</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-primary-500">5⭐</p>
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
                    fill="#f0f0f0" />
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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($categories as $category)
                    <a href="{{ route('shop.index', ['category' => $category->id]) }}"
                        class="group relative h-96 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">

                        @if ($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-primary-500 via-primary-600 to-primary-800"></div>
                        @endif

                        <!-- Overlay sombre -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent group-hover:from-black/80 group-hover:via-black/40 transition-all duration-300"></div>

                        <!-- Contenu -->
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6">
                            <h3 class="text-2xl font-bold text-white mb-2 drop-shadow-lg group-hover:text-primary-100 transition-colors">
                                {{ $category->name }}
                            </h3>
                            <p class="text-white/90 text-sm font-medium">{{ $category->products_count }} produits</p>

                            <!-- Icône décorative -->
                            <div class="mt-4 w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:bg-primary-500/80 transition-all">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </div>
                        </div>
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
                    <h2 class="text-4xl font-bold text-neutral-900 mb-4">Nouveaux Produits</h2>
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
                            <a href="{{ route('shop.show', $product->slug) }}">
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

                            </a>

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
                                                €</span>
                                            <span
                                                class="text-sm text-neutral-400 line-through">{{ number_format($product->price, 0, ',', ' ') }}</span>
                                        </div>
                                    @else
                                        <span
                                            class="text-lg font-bold text-neutral-900">{{ number_format($product->price, 0, ',', ' ') }}
                                            €</span>
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
                    <div class="w-20 h-20  rounded-2xl flex items-center justify-center mx-auto mb-6">
                         <img
                        src="{{ asset('service.png') }}" alt="La Maison P2A" class="h-16 w-16">
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Qualité Premium</h3>
                    <p class="text-neutral-400">Produits soigneusement sélectionnés pour leur qualité exceptionnelle</p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                         <img
                        src="{{ asset('service-client.png') }}" alt="La Maison P2A" class="h-16 w-16">
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Livraison Rapide</h3>
                    <p class="text-neutral-400">Livraison sécurisée et rapide dans tout le Bénin</p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20  rounded-2xl flex items-center justify-center mx-auto mb-6 relative">
                         <img
                        src="{{ asset('livraison-rapide.png') }}" alt="La Maison P2A" class="h-16 w-16">
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Support 24/7</h3>
                    <p class="text-neutral-400">Notre équipe est là pour vous accompagner à tout moment</p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                       <img
                        src="{{ asset('paiement-securise.png') }}" alt="La Maison P2A" class="h-16 w-16">
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Paiement Sécurisé</h3>
                    <p class="text-neutral-400">Transactions 100% sécurisées avec FedaPay</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-neutral-300 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h2 class="text-4xl lg:text-5xl font-bold mb-6">Prêt à Transformer Votre Espace ?</h2>
            <p class="text-xl text-primary-100 mb-8 max-w-2xl mx-auto">
                Découvrez notre collection complète et trouvez l'inspiration pour votre prochain projet de décoration
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('shop.index') }}"
                    class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-primary-100 via-primary-500 to-primary-800 text-neutral-900 rounded-xl font-semibold hover:shadow-2xl transition-all shadow-lg hover:scale-105">
                    Voir la Boutique
                </a>
                <a href="{{ route('contact') }}"
                    class="px-8 py-4 bg-white/10 backdrop-blur-sm text-white rounded-xl font-semibold hover:bg-white/20 transition-all border border-primary-500/30">
                    Nous Contacter
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-neutral-900 mb-4">Ce Que Disent Nos Clients</h2>
                <p class="text-lg text-neutral-400 max-w-2xl mx-auto">
                    Découvrez les témoignages de ceux qui ont fait confiance à La Maison P2A
                </p>
            </div>

            <div class="relative" x-data="{
                activeSlide: 0,
                totalSlides: 6,
                autoplayInterval: null,
                init() {
                    this.startAutoplay();
                },
                startAutoplay() {
                    this.autoplayInterval = setInterval(() => {
                        this.next();
                    }, 3000);
                },
                stopAutoplay() {
                    if (this.autoplayInterval) {
                        clearInterval(this.autoplayInterval);
                        this.autoplayInterval = null;
                    }
                },
                next() {
                    this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
                },
                prev() {
                    this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides;
                },
                goToSlide(index) {
                    this.activeSlide = index;
                }
            }" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()">

                <!-- Carousel Container -->
                <div class="overflow-hidden">
                    <div class="flex transition-transform duration-500 ease-in-out"
                        :style="'transform: translateX(-' + (activeSlide * 100) + '%)'">

                        <!-- Testimonial 1 -->
                        <div class="w-full flex-shrink-0 px-4">
                            <div
                                class="bg-neutral-50 rounded-2xl p-8 md:p-12 border border-neutral-200 hover:shadow-xl transition-all duration-300 max-w-4xl mx-auto">
                                <div class="flex items-center justify-center mb-6">
                                    <div class="flex space-x-1 text-yellow-400">
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-neutral-600 text-lg text-center mb-8 leading-relaxed italic">"Excellent
                                    service ! J'ai commandé des accessoires pour ma salle à manger et je suis vraiment
                                    impressionnée par la qualité des produits. La livraison a été rapide et l'équipe très
                                    professionnelle."</p>
                                <div class="flex items-center justify-center">
                                    <div
                                        class="w-14 h-14 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white font-bold text-xl mr-4">
                                        AF</div>
                                    <div class="text-center">
                                        <h4 class="font-semibold text-neutral-900 text-lg">Aïcha Feliho</h4>
                                        <p class="text-sm text-neutral-500">Cotonou</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 2 -->
                        <div class="w-full flex-shrink-0 px-4">
                            <div
                                class="bg-neutral-50 rounded-2xl p-8 md:p-12 border border-neutral-200 hover:shadow-xl transition-all duration-300 max-w-4xl mx-auto">
                                <div class="flex items-center justify-center mb-6">
                                    <div class="flex space-x-1 text-yellow-400">
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-neutral-600 text-lg text-center mb-8 leading-relaxed italic">"La Maison P2A
                                    a organisé la décoration de mon mariage et c'était absolument magnifique ! Tout était
                                    parfait, du début à la fin. Je recommande vivement leurs services événementiels."</p>
                                <div class="flex items-center justify-center">
                                    <div
                                        class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xl mr-4">
                                        MS</div>
                                    <div class="text-center">
                                        <h4 class="font-semibold text-neutral-900 text-lg">Mariama Sanni</h4>
                                        <p class="text-sm text-neutral-500">Porto-Novo</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 3 -->
                        <div class="w-full flex-shrink-0 px-4">
                            <div
                                class="bg-neutral-50 rounded-2xl p-8 md:p-12 border border-neutral-200 hover:shadow-xl transition-all duration-300 max-w-4xl mx-auto">
                                <div class="flex items-center justify-center mb-6">
                                    <div class="flex space-x-1 text-yellow-400">
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-neutral-600 text-lg text-center mb-8 leading-relaxed italic">"Produits de
                                    très bonne qualité et prix abordables. J'ai refait toute la décoration de mon salon avec
                                    leurs articles. Le résultat est au-delà de mes espérances. Merci !"</p>
                                <div class="flex items-center justify-center">
                                    <div
                                        class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-bold text-xl mr-4">
                                        JD</div>
                                    <div class="text-center">
                                        <h4 class="font-semibold text-neutral-900 text-lg">Jean-Paul Dossou</h4>
                                        <p class="text-sm text-neutral-500">Abomey-Calavi</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 4 -->
                        <div class="w-full flex-shrink-0 px-4">
                            <div
                                class="bg-neutral-50 rounded-2xl p-8 md:p-12 border border-neutral-200 hover:shadow-xl transition-all duration-300 max-w-4xl mx-auto">
                                <div class="flex items-center justify-center mb-6">
                                    <div class="flex space-x-1 text-yellow-400">
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-neutral-600 text-lg text-center mb-8 leading-relaxed italic">"Service client
                                    exceptionnel ! J'ai eu besoin de conseils pour choisir mes rideaux et l'équipe m'a
                                    guidée avec patience et professionnalisme. Très satisfaite de mon achat."</p>
                                <div class="flex items-center justify-center">
                                    <div
                                        class="w-14 h-14 bg-gradient-to-br from-pink-500 to-pink-600 rounded-full flex items-center justify-center text-white font-bold text-xl mr-4">
                                        ER</div>
                                    <div class="text-center">
                                        <h4 class="font-semibold text-neutral-900 text-lg">Élisabeth Rodrigues</h4>
                                        <p class="text-sm text-neutral-500">Parakou</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 5 -->
                        <div class="w-full flex-shrink-0 px-4">
                            <div
                                class="bg-neutral-50 rounded-2xl p-8 md:p-12 border border-neutral-200 hover:shadow-xl transition-all duration-300 max-w-4xl mx-auto">
                                <div class="flex items-center justify-center mb-6">
                                    <div class="flex space-x-1 text-yellow-400">
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-neutral-600 text-lg text-center mb-8 leading-relaxed italic">"Rapport
                                    qualité-prix imbattable ! J'ai meublé tout mon bureau avec La Maison P2A et je suis ravi
                                    du résultat. L'ambiance est professionnelle et chaleureuse à la fois."</p>
                                <div class="flex items-center justify-center">
                                    <div
                                        class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xl mr-4">
                                        TK</div>
                                    <div class="text-center">
                                        <h4 class="font-semibold text-neutral-900 text-lg">Thomas Koffi</h4>
                                        <p class="text-sm text-neutral-500">Cotonou</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 6 -->
                        <div class="w-full flex-shrink-0 px-4">
                            <div
                                class="bg-neutral-50 rounded-2xl p-8 md:p-12 border border-neutral-200 hover:shadow-xl transition-all duration-300 max-w-4xl mx-auto">
                                <div class="flex items-center justify-center mb-6">
                                    <div class="flex space-x-1 text-yellow-400">
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-neutral-600 text-lg text-center mb-8 leading-relaxed italic">"Une expérience
                                    d'achat parfaite du début à la fin. Site web facile à utiliser, paiement sécurisé et
                                    livraison dans les délais. Je recommande sans hésitation !"</p>
                                <div class="flex items-center justify-center">
                                    <div
                                        class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center text-white font-bold text-xl mr-4">
                                        SB</div>
                                    <div class="text-center">
                                        <h4 class="font-semibold text-neutral-900 text-lg">Sophie Bocco</h4>
                                        <p class="text-sm text-neutral-500">Ouidah</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Navigation Buttons -->
                <button @click="prev()"
                    class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 lg:-translate-x-12 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-primary-500 hover:bg-primary-500 hover:text-white transition-colors z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button @click="next()"
                    class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 lg:translate-x-12 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-primary-500 hover:bg-primary-500 hover:text-white transition-colors z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Indicators -->
                <div class="flex justify-center gap-2 mt-8">
                    <button @click="goToSlide(0)" class="w-3 h-3 rounded-full transition-all duration-300"
                        :class="activeSlide === 0 ? 'bg-primary-500 w-8' : 'bg-neutral-300 hover:bg-neutral-400'"></button>
                    <button @click="goToSlide(1)" class="w-3 h-3 rounded-full transition-all duration-300"
                        :class="activeSlide === 1 ? 'bg-primary-500 w-8' : 'bg-neutral-300 hover:bg-neutral-400'"></button>
                    <button @click="goToSlide(2)" class="w-3 h-3 rounded-full transition-all duration-300"
                        :class="activeSlide === 2 ? 'bg-primary-500 w-8' : 'bg-neutral-300 hover:bg-neutral-400'"></button>
                    <button @click="goToSlide(3)" class="w-3 h-3 rounded-full transition-all duration-300"
                        :class="activeSlide === 3 ? 'bg-primary-500 w-8' : 'bg-neutral-300 hover:bg-neutral-400'"></button>
                    <button @click="goToSlide(4)" class="w-3 h-3 rounded-full transition-all duration-300"
                        :class="activeSlide === 4 ? 'bg-primary-500 w-8' : 'bg-neutral-300 hover:bg-neutral-400'"></button>
                    <button @click="goToSlide(5)" class="w-3 h-3 rounded-full transition-all duration-300"
                        :class="activeSlide === 5 ? 'bg-primary-500 w-8' : 'bg-neutral-300 hover:bg-neutral-400'"></button>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-neutral-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-neutral-900 mb-4">Questions Fréquentes</h2>
                <p class="text-lg text-neutral-400">
                    Trouvez les réponses aux questions les plus courantes
                </p>
            </div>

            <div class="space-y-4" x-data="{ activeAccordion: null }">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
                    <button @click="activeAccordion = activeAccordion === 1 ? null : 1"
                        class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-neutral-50 transition-colors">
                        <span class="font-semibold text-neutral-900 pr-8">Quels types de projets La Maison P2A prend-elle
                            en charge ?</span>
                        <svg class="w-5 h-5 text-primary-500 flex-shrink-0 transition-transform duration-200"
                            :class="{ 'rotate-180': activeAccordion === 1 }" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 1" x-collapse>
                        <div class="px-6 pb-5 text-neutral-600 leading-relaxed">
                            <p class="mb-3">Nous intervenons sur trois types de projets :</p>
                            <ul class="list-disc list-inside space-y-2 ml-2">
                                <li>Décoration d'intérieur (objets, aménagement, ambiance cocooning)</li>
                                <li>Décoration événementielle (mariages, baptêmes, anniversaires, événements professionnels)
                                </li>
                                <li>Coordination de projets de construction avec décoration finale selon vos besoins</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
                    <button @click="activeAccordion = activeAccordion === 2 ? null : 2"
                        class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-neutral-50 transition-colors">
                        <span class="font-semibold text-neutral-900 pr-8">Proposez-vous des créations sur mesure ?</span>
                        <svg class="w-5 h-5 text-primary-500 flex-shrink-0 transition-transform duration-200"
                            :class="{ 'rotate-180': activeAccordion === 2 }" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 2" x-collapse>
                        <div class="px-6 pb-5 text-neutral-600 leading-relaxed">
                            Oui, chaque projet est personnalisé. Nous travaillons en étroite collaboration avec vous pour
                            concevoir des objets ou des ambiances qui correspondent à votre style, vos envies et votre
                            budget.
                        </div>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
                    <button @click="activeAccordion = activeAccordion === 3 ? null : 3"
                        class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-neutral-50 transition-colors">
                        <span class="font-semibold text-neutral-900 pr-8">Est-il possible de vous confier uniquement la
                            décoration d'un événement ?</span>
                        <svg class="w-5 h-5 text-primary-500 flex-shrink-0 transition-transform duration-200"
                            :class="{ 'rotate-180': activeAccordion === 3 }" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 3" x-collapse>
                        <div class="px-6 pb-5 text-neutral-600 leading-relaxed">
                            Absolument. Que ce soit pour un événement privé ou professionnel, nous pouvons prendre en charge
                            uniquement la partie décoration, selon le thème et les contraintes du lieu.
                        </div>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
                    <button @click="activeAccordion = activeAccordion === 4 ? null : 4"
                        class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-neutral-50 transition-colors">
                        <span class="font-semibold text-neutral-900 pr-8">Où êtes-vous basés et intervenez-vous à
                            l'international ?</span>
                        <svg class="w-5 h-5 text-primary-500 flex-shrink-0 transition-transform duration-200"
                            :class="{ 'rotate-180': activeAccordion === 4 }" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 4" x-collapse>
                        <div class="px-6 pb-5 text-neutral-600 leading-relaxed">
                            Nous sommes basés en Île-de-France, mais nous pouvons intervenir dans toute la France et à
                            l'étranger selon les projets. Les déplacements sont étudiés au cas par cas.
                        </div>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
                    <button @click="activeAccordion = activeAccordion === 5 ? null : 5"
                        class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-neutral-50 transition-colors">
                        <span class="font-semibold text-neutral-900 pr-8">Comment se déroule un premier contact ?</span>
                        <svg class="w-5 h-5 text-primary-500 flex-shrink-0 transition-transform duration-200"
                            :class="{ 'rotate-180': activeAccordion === 5 }" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 5" x-collapse>
                        <div class="px-6 pb-5 text-neutral-600 leading-relaxed">
                            Le premier échange permet de comprendre vos besoins, vos goûts et vos contraintes. Ensuite, nous
                            vous proposons un devis personnalisé et un cahier des charges adapté à votre projet.
                        </div>
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
                    <button @click="activeAccordion = activeAccordion === 6 ? null : 6"
                        class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-neutral-50 transition-colors">
                        <span class="font-semibold text-neutral-900 pr-8">Quels sont les délais moyens pour un projet
                            ?</span>
                        <svg class="w-5 h-5 text-primary-500 flex-shrink-0 transition-transform duration-200"
                            :class="{ 'rotate-180': activeAccordion === 6 }" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 6" x-collapse>
                        <div class="px-6 pb-5 text-neutral-600 leading-relaxed">
                            <p class="mb-3">Les délais varient selon la nature du projet :</p>
                            <ul class="list-disc list-inside space-y-2 ml-2">
                                <li>Objets de décoration : quelques jours à quelques semaines</li>
                                <li>Événements : planification 1 à 3 mois à l'avance</li>
                                <li>Projets de construction : plusieurs mois selon l'ampleur</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- FAQ 7 -->
                <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
                    <button @click="activeAccordion = activeAccordion === 7 ? null : 7"
                        class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-neutral-50 transition-colors">
                        <span class="font-semibold text-neutral-900 pr-8">Puis-je voir des exemples de vos réalisations
                            ?</span>
                        <svg class="w-5 h-5 text-primary-500 flex-shrink-0 transition-transform duration-200"
                            :class="{ 'rotate-180': activeAccordion === 7 }" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 7" x-collapse>
                        <div class="px-6 pb-5 text-neutral-600 leading-relaxed">
                            Oui, nous mettons régulièrement à jour notre portfolio sur le site et nos réseaux sociaux.
                            N'hésitez pas à consulter la section "Réalisations" pour découvrir notre univers.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <p class="text-neutral-600 mb-4">Vous avez d'autres questions ?</p>
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center px-8 py-4 bg-primary-500 text-white rounded-xl font-semibold hover:bg-primary-600 transition-colors shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Contactez-nous
                </a>
            </div>
        </div>
    </section>
@endsection
