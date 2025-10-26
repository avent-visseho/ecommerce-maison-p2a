@extends('layouts.public')

@section('title', $product->name)
@section('description', $product->description)

@section('content')
    <!-- Breadcrumb -->
    <section class="bg-neutral-50 py-4 border-b border-neutral-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center space-x-2 text-sm text-neutral-400">
                <a href="{{ route('home') }}" class="hover:text-neutral-900">Accueil</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('shop.index') }}" class="hover:text-neutral-900">Boutique</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('shop.index', ['category' => $product->category_id]) }}"
                    class="hover:text-neutral-900">{{ $product->category->name }}</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-neutral-900 font-medium truncate">{{ $product->name }}</span>
            </nav>
        </div>
    </section>

    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-12" x-data="{ selectedImage: '{{ $product->main_image ? asset('storage/' . $product->main_image) : '' }}', quantity: 1 }">
                <!-- Product Images -->
                <div class="space-y-4">
                    <!-- Main Image -->
                    <div class="aspect-square rounded-2xl overflow-hidden bg-neutral-50 border border-neutral-200">
                        @if ($product->main_image)
                            <img :src="selectedImage" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-24 h-24 text-neutral-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Thumbnail Gallery -->
                    @if ($product->main_image || $product->images)
                        <div class="grid grid-cols-4 gap-4">
                            @if ($product->main_image)
                                <button @click="selectedImage = '{{ asset('storage/' . $product->main_image) }}'"
                                    :class="selectedImage === '{{ asset('storage/' . $product->main_image) }}' ?
                                        'ring-2 ring-primary-500' : 'ring-1 ring-neutral-200'"
                                    class="aspect-square rounded-lg overflow-hidden hover:ring-2 hover:ring-primary-500 transition-all">
                                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover">
                                </button>
                            @endif

                            @if ($product->images)
                                @foreach ($product->images as $image)
                                    <button @click="selectedImage = '{{ asset('storage/' . $image) }}'"
                                        :class="selectedImage === '{{ asset('storage/' . $image) }}' ?
                                            'ring-2 ring-primary-500' : 'ring-1 ring-neutral-200'"
                                        class="aspect-square rounded-lg overflow-hidden hover:ring-2 hover:ring-primary-500 transition-all">
                                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}"
                                            class="w-full h-full object-cover">
                                    </button>
                                @endforeach
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="mt-8 lg:mt-0 space-y-6">
                    <!-- Title & Category -->
                    <div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-50 text-primary-500 mb-3">
                            {{ $product->category->name }}
                        </span>
                        <h1 class="text-4xl font-bold text-neutral-900 mb-2">{{ $product->name }}</h1>
                        @if ($product->brand)
                            <p class="text-lg text-neutral-400">Par {{ $product->brand->name }}</p>
                        @endif
                    </div>

                    <!-- Price -->
                    <div class="border-y border-neutral-200 py-6">
                        @if ($product->isOnSale())
                            <div class="flex items-baseline space-x-3">
                                <span
                                    class="text-4xl font-bold text-primary-500">{{ number_format($product->sale_price, 0, ',', ' ') }}
                                    FCFA</span>
                                <span
                                    class="text-2xl text-neutral-400 line-through">{{ number_format($product->price, 0, ',', ' ') }}
                                    FCFA</span>
                                <span class="px-3 py-1 bg-red-500 text-white text-sm font-bold rounded-full">
                                    -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                </span>
                            </div>
                        @else
                            <span
                                class="text-4xl font-bold text-neutral-900">{{ number_format($product->price, 0, ',', ' ') }}
                                FCFA</span>
                        @endif
                    </div>

                    <!-- Stock Status -->
                    <div class="flex items-center space-x-4">
                        @if ($product->isOutOfStock())
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-lg bg-red-50 text-red-700 font-semibold">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Rupture de stock
                            </span>
                        @elseif($product->isLowStock())
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-lg bg-orange-50 text-orange-700 font-semibold">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                Plus que {{ $product->stock }} en stock !
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-lg bg-green-50 text-green-700 font-semibold">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                En stock
                            </span>
                        @endif

                        <span class="text-sm text-neutral-400">SKU: <span
                                class="font-mono">{{ $product->sku }}</span></span>
                    </div>

                    <!-- Description -->
                    @if ($product->description)
                        <div>
                            <h3 class="text-lg font-semibold text-neutral-900 mb-2">Description</h3>
                            <p class="text-neutral-600 leading-relaxed">{{ $product->description }}</p>
                        </div>
                    @endif

                    <!-- Add to Cart Form -->
                    @if (!$product->isOutOfStock())
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <!-- Quantity Selector -->
                            <div>
                                <label class="label">Quantité</label>
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center border border-neutral-200 rounded-lg">
                                        <button type="button" @click="quantity = Math.max(1, quantity - 1)"
                                            class="px-4 py-3 hover:bg-neutral-50 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 12H4" />
                                            </svg>
                                        </button>
                                        <input type="number" name="quantity" x-model="quantity" min="1"
                                            max="{{ $product->stock }}"
                                            class="w-16 text-center border-0 focus:ring-0 font-semibold">
                                        <button type="button"
                                            @click="quantity = Math.min({{ $product->stock }}, quantity + 1)"
                                            class="px-4 py-3 hover:bg-neutral-50 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>
                                    <span class="text-sm text-neutral-400">{{ $product->stock }} disponibles</span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-4">
                                <button type="submit"
                                    class="flex-1 btn-primary flex items-center justify-center space-x-2 py-4">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    <span>Ajouter au panier</span>
                                </button>
                                <button type="button"
                                    class="px-6 py-4 border-2 border-neutral-200 rounded-xl hover:border-primary-500 hover:text-primary-500 transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="p-6 bg-neutral-50 rounded-xl text-center">
                            <p class="text-neutral-600 mb-4">Ce produit est actuellement en rupture de stock</p>
                            <button class="btn-secondary">
                                Me notifier quand disponible
                            </button>
                        </div>
                    @endif

                    <!-- Product Features -->
                    <div class="grid grid-cols-2 gap-4 pt-6 border-t border-neutral-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-primary-50 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-neutral-900">Livraison</p>
                                <p class="text-xs text-neutral-400">2-5 jours</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-neutral-900">Garantie</p>
                                <p class="text-xs text-neutral-400">1 an</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-neutral-900">Paiement</p>
                                <p class="text-xs text-neutral-400">Sécurisé</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-neutral-900">Support</p>
                                <p class="text-xs text-neutral-400">24/7</p>
                            </div>
                        </div>
                    </div>

                    <!-- Share -->
                    <div class="pt-6 border-t border-neutral-200">
                        <p class="text-sm font-medium text-neutral-900 mb-3">Partager</p>
                        <div class="flex items-center space-x-3">
                            <button
                                class="w-10 h-10 bg-neutral-100 rounded-lg flex items-center justify-center hover:bg-primary-500 hover:text-white transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </button>
                            <button
                                class="w-10 h-10 bg-neutral-100 rounded-lg flex items-center justify-center hover:bg-primary-500 hover:text-white transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </button>
                            <button
                                class="w-10 h-10 bg-neutral-100 rounded-lg flex items-center justify-center hover:bg-primary-500 hover:text-white transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Description & Related Products -->
            <div class="mt-20 space-y-16">
                <!-- Tabs -->
                <div x-data="{ activeTab: 'description' }">
                    <div class="border-b border-neutral-200">
                        <nav class="flex space-x-8">
                            <button @click="activeTab = 'description'"
                                :class="activeTab === 'description' ? 'border-primary-500 text-primary-500' :
                                    'border-transparent text-neutral-400'"
                                class="py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Description Détaillée
                            </button>
                            <button @click="activeTab = 'specifications'"
                                :class="activeTab === 'specifications' ? 'border-primary-500 text-primary-500' :
                                    'border-transparent text-neutral-400'"
                                class="py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Spécifications
                            </button>
                            <button @click="activeTab = 'delivery'"
                                :class="activeTab === 'delivery' ? 'border-primary-500 text-primary-500' :
                                    'border-transparent text-neutral-400'"
                                class="py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Livraison & Retours
                            </button>
                        </nav>
                    </div>

                    <div class="py-8">
                        <!-- Description Tab -->
                        <div x-show="activeTab === 'description'" class="prose max-w-none">
                            @if ($product->long_description)
                                <p class="text-neutral-600 leading-relaxed text-lg">{{ $product->long_description }}</p>
                            @else
                                <p class="text-neutral-600 leading-relaxed text-lg">{{ $product->description }}</p>
                            @endif
                        </div>

                        <!-- Specifications Tab -->
                        <div x-show="activeTab === 'specifications'" style="display: none;">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex justify-between py-3 border-b border-neutral-200">
                                    <span class="font-medium text-neutral-900">Catégorie</span>
                                    <span class="text-neutral-600">{{ $product->category->name }}</span>
                                </div>
                                @if ($product->brand)
                                    <div class="flex justify-between py-3 border-b border-neutral-200">
                                        <span class="font-medium text-neutral-900">Marque</span>
                                        <span class="text-neutral-600">{{ $product->brand->name }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between py-3 border-b border-neutral-200">
                                    <span class="font-medium text-neutral-900">SKU</span>
                                    <span class="text-neutral-600 font-mono">{{ $product->sku }}</span>
                                </div>
                                <div class="flex justify-between py-3 border-b border-neutral-200">
                                    <span class="font-medium text-neutral-900">Disponibilité</span>
                                    <span class="text-neutral-600">{{ $product->stock }} en stock</span>
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Tab -->
                        <div x-show="activeTab === 'delivery'" style="display: none;">
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-neutral-900 mb-3">Livraison</h3>
                                    <p class="text-neutral-600">Livraison gratuite pour toute commande supérieure à 50,000
                                        FCFA. Délai de livraison : 2-5 jours ouvrables dans tout le Bénin.</p>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-neutral-900 mb-3">Retours</h3>
                                    <p class="text-neutral-600">Retours acceptés sous 14 jours. Le produit doit être dans
                                        son emballage d'origine et non utilisé.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Products -->
                @if ($relatedProducts->count() > 0)
                    <div>
                        <h2 class="text-3xl font-bold text-neutral-900 mb-8">Produits Similaires</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach ($relatedProducts as $relatedProduct)
                                <div
                                    class="group bg-white rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 border border-neutral-200">
                                    <div class="relative aspect-square overflow-hidden bg-neutral-50">
                                        @if ($relatedProduct->main_image)
                                            <img src="{{ asset('storage/' . $relatedProduct->main_image) }}"
                                                alt="{{ $relatedProduct->name }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @endif
                                        <a href="{{ route('shop.show', $relatedProduct->slug) }}"
                                            class="absolute inset-0"></a>
                                    </div>
                                    <div class="p-5">
                                        <h3 class="font-semibold text-neutral-900 mb-2 line-clamp-2">
                                            <a href="{{ route('shop.show', $relatedProduct->slug) }}"
                                                class="hover:text-primary-500 transition-colors">
                                                {{ $relatedProduct->name }}
                                            </a>
                                        </h3>
                                        <span
                                            class="text-lg font-bold text-neutral-900">{{ number_format($relatedProduct->effective_price, 0, ',', ' ') }}
                                            FCFA</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
