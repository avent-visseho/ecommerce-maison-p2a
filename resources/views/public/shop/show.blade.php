@extends('layouts.public')

@section('title', $product->name)
@section('description', $product->description)

@section('content')
    <!-- Breadcrumb -->
    <section class="bg-neutral-50 py-4 border-b border-neutral-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center space-x-2 text-sm text-neutral-400">
                <a href="{{ route('home') }}" class="hover:text-neutral-900">{{ __('common.home') }}</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('shop.index') }}" class="hover:text-neutral-900">{{ __('common.shop') }}</a>
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
            <div class="lg:grid lg:grid-cols-2 lg:gap-12" x-data="productDetail()">
                <!-- Product Images -->
                <div class="space-y-4">
                    <!-- Main Image with Zoom -->
                    <div class="aspect-square rounded-2xl overflow-hidden bg-neutral-50 border border-neutral-200 relative cursor-zoom-in"
                         x-data="imageZoom()"
                         @mouseenter="zooming = true"
                         @mouseleave="zooming = false"
                         @mousemove="onMouseMove($event)"
                         @click="$dispatch('open-lightbox')">
                        @if ($product->main_image)
                            {{-- Normal image --}}
                            <img :src="selectedImage" alt="{{ $product->name }}" class="w-full h-full object-cover transition-opacity duration-200"
                                 :class="zooming ? 'opacity-0' : 'opacity-100'">
                            {{-- Zoomed image layer --}}
                            <div x-show="zooming"
                                 class="absolute inset-0 bg-no-repeat"
                                 :style="`background-image: url(${selectedImage}); background-size: 200%; background-position: ${zoomX}% ${zoomY}%;`">
                            </div>
                            {{-- Zoom hint icon --}}
                            <div class="absolute top-3 right-3 bg-white/80 backdrop-blur-sm rounded-full p-2 shadow-sm pointer-events-none transition-opacity duration-200"
                                 :class="zooming ? 'opacity-0' : 'opacity-100'">
                                <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                </svg>
                            </div>
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

                <!-- Lightbox / Fullscreen Modal -->
                <template x-teleport="body">
                    <div x-show="lightboxOpen"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         @open-lightbox.window="lightboxOpen = true"
                         @keydown.escape.window="lightboxOpen = false"
                         @keydown.arrow-left.window="if(lightboxOpen) prevImage()"
                         @keydown.arrow-right.window="if(lightboxOpen) nextImage()"
                         class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/90 backdrop-blur-sm cursor-zoom-out"
                         @click.self="lightboxOpen = false"
                         x-cloak>
                        {{-- Close button --}}
                        <button @click="lightboxOpen = false"
                                class="absolute top-4 right-4 z-10 bg-white/10 hover:bg-white/20 text-white rounded-full p-3 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        {{-- Navigation arrows (only if multiple images) --}}
                        <template x-if="allImages.length > 1">
                            <button @click.stop="prevImage()" class="absolute left-4 bg-white/10 hover:bg-white/20 text-white rounded-full p-3 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                        </template>
                        <template x-if="allImages.length > 1">
                            <button @click.stop="nextImage()" class="absolute right-4 bg-white/10 hover:bg-white/20 text-white rounded-full p-3 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </template>
                        {{-- Fullscreen image --}}
                        <img :src="selectedImage" alt="{{ $product->name }}"
                             class="max-w-[90vw] max-h-[90vh] object-contain rounded-lg shadow-2xl"
                             @click.stop>
                    </div>
                </template>

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
                            <p class="text-lg text-neutral-400">{{ __('shop.by') }} {{ $product->brand->name }}</p>
                        @endif
                    </div>

                    <!-- Price -->
                    <div class="border-y border-neutral-200 py-6">
                        @if($product->hasVariants())
                            {{-- Total dynamique quand des variantes sont sélectionnées --}}
                            <div x-show="totalItems > 0" x-cloak>
                                <div class="flex items-baseline space-x-3">
                                    <span class="text-4xl font-bold text-primary-500" x-text="formatPrice(totalPrice)"></span>
                                    <span class="text-lg text-neutral-400" x-text="totalItems + ' article(s)'"></span>
                                </div>
                            </div>
                            {{-- Prix de base affiché quand rien n'est sélectionné --}}
                            <div x-show="totalItems === 0">
                                <span class="text-2xl text-neutral-500">{{ __('shop.from', ['default' => 'À partir de']) }}</span>
                                <span class="text-4xl font-bold text-neutral-900">{{ number_format($product->price, 0, ',', ' ') }} €</span>
                            </div>
                        @else
                            @if ($product->isOnSale())
                                <div class="flex items-baseline space-x-3">
                                    <span class="text-4xl font-bold text-primary-500">{{ number_format($product->sale_price, 0, ',', ' ') }} €</span>
                                    <span class="text-2xl text-neutral-400 line-through">{{ number_format($product->price, 0, ',', ' ') }} €</span>
                                    <span class="px-3 py-1 bg-red-500 text-white text-sm font-bold rounded-full">
                                        -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                    </span>
                                </div>
                            @else
                                <span class="text-4xl font-bold text-neutral-900">{{ number_format($product->price, 0, ',', ' ') }} €</span>
                            @endif
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
                                {{ __('common.out_of_stock') }}
                            </span>
                        @elseif($product->isLowStock())
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-lg bg-orange-50 text-orange-700 font-semibold">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                {{ __('shop.only_x_left', ['count' => $product->stock]) }}
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-lg bg-green-50 text-green-700 font-semibold">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('common.in_stock') }}
                            </span>
                        @endif

                        <span class="text-sm text-neutral-400">SKU: <span
                                class="font-mono">{{ $product->sku }}</span></span>
                    </div>

                    <!-- Description -->
                    @if ($product->description)
                        <div>
                            <h3 class="text-lg font-semibold text-neutral-900 mb-2">{{ __('shop.description') }}</h3>
                            <div class="trix-content text-neutral-600">{!! $product->description !!}</div>
                        </div>
                    @endif

                    <!-- Variant Selector (multi-select) -->
                    @if($product->hasVariants())
                        <div class="space-y-4 border-t border-neutral-200 pt-6">
                            <h3 class="text-lg font-semibold text-neutral-900">{{ __('shop.choose_variants', ['default' => 'Choisissez vos variantes']) }}</h3>

                            <!-- Liste des variantes avec quantité -->
                            <div class="space-y-3">
                                <template x-for="variant in variants" :key="variant.id">
                                    <div class="border rounded-xl p-4 transition-all cursor-pointer"
                                         :class="[
                                            cart[variant.id]?.qty > 0 ? 'border-primary-500 bg-primary-50/30' : 'border-neutral-200',
                                            previewingVariantId === variant.id ? 'ring-2 ring-primary-300' : ''
                                         ]"
                                         @click="previewVariant(variant)">
                                        <div class="flex items-center justify-between gap-4">
                                            <!-- Variant info -->
                                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                                <!-- Color swatch if applicable -->
                                                <template x-if="getVariantColor(variant)">
                                                    <div class="w-8 h-8 rounded-full ring-1 ring-neutral-300 flex-shrink-0"
                                                         :class="previewingVariantId === variant.id ? 'ring-2 ring-primary-500 ring-offset-2' : ''"
                                                         :style="'background-color:' + getVariantColor(variant)"></div>
                                                </template>
                                                <!-- Variant image -->
                                                <template x-if="variant.image">
                                                    <img :src="'{{ asset('storage/') }}/' + variant.image"
                                                         class="w-12 h-12 rounded-lg object-cover flex-shrink-0 transition-all"
                                                         :class="previewingVariantId === variant.id ? 'ring-2 ring-primary-500' : ''"
                                                         alt="">
                                                </template>
                                                <div class="min-w-0">
                                                    <p class="font-medium text-neutral-900 truncate" x-text="getVariantName(variant)"></p>
                                                    <div class="flex items-center gap-2 mt-0.5">
                                                        <span class="text-sm font-bold text-primary-500" x-text="formatPrice(variant.effective_price)"></span>
                                                        <template x-if="variant.is_on_sale && variant.price">
                                                            <span class="text-xs text-neutral-400 line-through" x-text="formatPrice(variant.price)"></span>
                                                        </template>
                                                    </div>
                                                    <!-- Stock -->
                                                    <span x-show="variant.stock <= 0" class="text-xs text-red-600 font-medium">Rupture de stock</span>
                                                    <span x-show="variant.stock > 0 && variant.stock <= variant.low_stock_alert" class="text-xs text-orange-600 font-medium" x-text="'Plus que ' + variant.stock + ' en stock'"></span>
                                                </div>
                                            </div>

                                            <!-- Quantity selector -->
                                            <div class="flex items-center gap-2 flex-shrink-0" x-show="variant.stock > 0">
                                                <button type="button"
                                                    @click.stop="updateCart(variant.id, -1, variant.stock)"
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg border border-neutral-200 hover:bg-neutral-50 transition-colors"
                                                    :class="!cart[variant.id]?.qty ? 'opacity-30 cursor-not-allowed' : ''">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                    </svg>
                                                </button>
                                                <span class="w-8 text-center font-semibold text-sm" x-text="cart[variant.id]?.qty || 0"></span>
                                                <button type="button"
                                                    @click.stop="updateCart(variant.id, 1, variant.stock)"
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg border border-neutral-200 hover:bg-neutral-50 transition-colors"
                                                    :class="cart[variant.id]?.qty >= variant.stock ? 'opacity-30 cursor-not-allowed' : ''">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- Récapitulatif sélection -->
                            <div x-show="totalItems > 0" x-cloak class="bg-neutral-50 rounded-xl p-4 space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-neutral-600" x-text="totalItems + ' article(s) sélectionné(s)'"></span>
                                    <span class="font-bold text-neutral-900" x-text="formatPrice(totalPrice)"></span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Add to Cart Form -->
                    @if (!$product->isOutOfStock())
                        @if($product->hasVariants())
                            <form action="{{ route('cart.addMultipleVariants', $product->id) }}" method="POST" class="space-y-4">
                                @csrf
                                <!-- Hidden inputs for selected variants -->
                                <template x-for="(item, variantId) in cart" :key="variantId">
                                    <template x-if="item.qty > 0">
                                        <div>
                                            <input type="hidden" :name="'variants[' + variantId + ']'" :value="item.qty">
                                        </div>
                                    </template>
                                </template>

                                <!-- Action Buttons -->
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <button type="submit"
                                        :disabled="totalItems === 0"
                                        :class="{'opacity-50 cursor-not-allowed': totalItems === 0}"
                                        class="flex-1 btn-primary flex items-center justify-center space-x-2 py-4">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        <span x-show="totalItems === 0">Sélectionnez des variantes</span>
                                        <span x-show="totalItems > 0" x-text="'{{ __('common.add_to_cart') }} (' + totalItems + ')'"></span>
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
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-4">
                            @csrf

                            <!-- Quantity Selector -->
                            <div>
                                <label class="label">{{ __('common.quantity') }}</label>
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
                                            :max="maxStock"
                                            class="w-16 text-center border-0 focus:ring-0 font-semibold">
                                        <button type="button"
                                            @click="quantity = Math.min(maxStock, quantity + 1)"
                                            class="px-4 py-3 hover:bg-neutral-50 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>
                                    <span class="text-sm text-neutral-400" x-text="maxStock + ' disponible(s)'"></span>
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
                                    <span>{{ __('common.add_to_cart') }}</span>
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
                        @endif
                    @else
                        <div class="p-6 bg-neutral-50 rounded-xl text-center">
                            <p class="text-neutral-600 mb-4">{{ __('shop.out_of_stock_message') }}</p>
                            <button class="btn-secondary">
                                {{ __('shop.notify_when_available') }}
                            </button>
                        </div>
                    @endif

                    <!-- Product Features -->
                    <div class="grid grid-cols-2 gap-4 pt-6 border-t border-neutral-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-primary-50 rounded-lg flex items-center justify-center">
                                <img src="{{ asset('livraison-rapide.png') }}" alt="La Maison P2A" class="h-5 w-5">
                            </div>
                            <div>
                                <p class="text-sm font-medium text-neutral-900">{{ __('shop.delivery') }}</p>
                                <p class="text-xs text-neutral-400">{{ __('shop.delivery_time') }}</p>
                            </div>
                        </div>


                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                                 <img src="{{ asset('paiement-securise.png') }}" alt="La Maison P2A" class="h-5 w-5">
                            </div>
                            <div>
                                <p class="text-sm font-medium text-neutral-900">{{ __('shop.payment') }}</p>
                                <p class="text-xs text-neutral-400">{{ __('shop.secure') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                                <img src="{{ asset('service-client.png') }}" alt="La Maison P2A" class="h-5 w-5">
                            </div>
                            <div>
                                <p class="text-sm font-medium text-neutral-900">{{ __('shop.support') }}</p>
                                <p class="text-xs text-neutral-400">24/7</p>
                            </div>
                        </div>
                    </div>

                    <!-- Share -->
                    <div class="pt-6 border-t border-neutral-200" x-data="{
                        copyLink() {
                            const url = '{{ route('shop.show', $product->slug) }}';
                            navigator.clipboard.writeText(url).then(() => {
                                alert('{{ __('shop.link_copied') }}');
                            });
                        }
                    }">
                        <p class="text-sm font-medium text-neutral-900 mb-3">{{ __('shop.share_product') }}</p>
                        <div class="flex items-center flex-wrap gap-3">
                            <!-- WhatsApp -->
                          {{--   <a href="https://wa.me/?text={{ urlencode($product->name . ' - ' . route('shop.show', $product->slug)) }}"
                                target="_blank"
                                class="w-10 h-10 bg-neutral-100 rounded-lg flex items-center justify-center hover:bg-green-500 hover:text-white transition-all"
                                title="Partager sur WhatsApp">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                            </a> --}}

                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('shop.show', $product->slug)) }}"
                                target="_blank"
                                class="w-10 h-10 bg-neutral-100 rounded-lg flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all"
                                title="Partager sur Facebook">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>

                            <!-- Instagram (copier le lien) -->
                            <button @click="copyLink()"
                                class="w-10 h-10 bg-neutral-100 rounded-lg flex items-center justify-center hover:bg-gradient-to-br hover:from-purple-600 hover:via-pink-600 hover:to-orange-500 hover:text-white transition-all"
                                title="Copier le lien pour Instagram">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </button>

                            <!-- TikTok (copier le lien) -->
                            <button @click="copyLink()"
                                class="w-10 h-10 bg-neutral-100 rounded-lg flex items-center justify-center hover:bg-black hover:text-white transition-all"
                                title="Copier le lien pour TikTok">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                                </svg>
                            </button>

                            <!-- Pinterest -->
                            <a href="https://pin.it/6sDtY5TBh"
                                target="_blank"
                                class="w-10 h-10 bg-neutral-100 rounded-lg flex items-center justify-center hover:bg-red-600 hover:text-white transition-all"
                                title="Suivez-nous sur Pinterest">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z"/>
                                </svg>
                            </a>

                            <!-- YouTube -->
                            <a href="https://www.youtube.com/@Lamaisonp2a-s5c"
                                target="_blank"
                                class="w-10 h-10 bg-neutral-100 rounded-lg flex items-center justify-center hover:bg-red-600 hover:text-white transition-all"
                                title="Suivez-nous sur YouTube">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                        </div>
                        <p class="text-xs text-neutral-400 mt-2">{{ __('shop.copy_link_instruction') }}</p>
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
                                {{ __('shop.detailed_description') }}
                            </button>
                            <button @click="activeTab = 'specifications'"
                                :class="activeTab === 'specifications' ? 'border-primary-500 text-primary-500' :
                                    'border-transparent text-neutral-400'"
                                class="py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                {{ __('shop.specifications') }}
                            </button>
                            <button @click="activeTab = 'delivery'"
                                :class="activeTab === 'delivery' ? 'border-primary-500 text-primary-500' :
                                    'border-transparent text-neutral-400'"
                                class="py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                {{ __('shop.delivery_returns') }}
                            </button>
                        </nav>
                    </div>

                    <div class="py-8">
                        <!-- Description Tab -->
                        <div x-show="activeTab === 'description'">
                            @if ($product->long_description)
                                <div class="trix-content text-neutral-600 text-lg">{!! $product->long_description !!}</div>
                            @else
                                <div class="trix-content text-neutral-600 text-lg">{!! $product->description !!}</div>
                            @endif
                        </div>

                        <!-- Specifications Tab -->
                        <div x-show="activeTab === 'specifications'" style="display: none;">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex justify-between py-3 border-b border-neutral-200">
                                    <span class="font-medium text-neutral-900">{{ __('shop.category') }}</span>
                                    <span class="text-neutral-600">{{ $product->category->name }}</span>
                                </div>
                                @if ($product->brand)
                                    <div class="flex justify-between py-3 border-b border-neutral-200">
                                        <span class="font-medium text-neutral-900">{{ __('shop.brand') }}</span>
                                        <span class="text-neutral-600">{{ $product->brand->name }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between py-3 border-b border-neutral-200">
                                    <span class="font-medium text-neutral-900">SKU</span>
                                    <span class="text-neutral-600 font-mono">{{ $product->sku }}</span>
                                </div>
                                <div class="flex justify-between py-3 border-b border-neutral-200">
                                    <span class="font-medium text-neutral-900">{{ __('shop.availability') }}</span>
                                    <span class="text-neutral-600">{{ __('shop.x_in_stock', ['count' => $product->stock]) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Tab -->
                        <div x-show="activeTab === 'delivery'" style="display: none;">
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-neutral-900 mb-3">{{ __('shop.delivery') }}</h3>
                                    <ul class="text-neutral-600 list-disc list-inside space-y-1">
                                        <li>{{ __('shop.delivery_info_france') }}</li>
                                        <li>{{ __('shop.delivery_info_international') }}</li>
                                    </ul>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-neutral-900 mb-3">{{ __('shop.returns') }}</h3>
                                    <p class="text-neutral-600">{{ __('shop.returns_info') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Products -->
                @if ($relatedProducts->count() > 0)
                    <div>
                        <h2 class="text-3xl font-bold text-neutral-900 mb-8">{{ __('shop.similar_products') }}</h2>
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
                                            €</span>
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

@push('scripts')
<script>
function imageZoom() {
    return {
        zooming: false,
        zoomX: 50,
        zoomY: 50,

        onMouseMove(event) {
            const rect = event.currentTarget.getBoundingClientRect();
            this.zoomX = ((event.clientX - rect.left) / rect.width) * 100;
            this.zoomY = ((event.clientY - rect.top) / rect.height) * 100;
        }
    }
}

function productDetail() {
    return {
        variants: @json($product->activeVariants),
        cart: {},
        selectedImage: '{{ $product->main_image ? asset('storage/' . $product->main_image) : '' }}',
        defaultImage: '{{ $product->main_image ? asset('storage/' . $product->main_image) : '' }}',
        previewingVariantId: null,
        quantity: 1,
        lightboxOpen: false,
        allImages: [
            @if($product->main_image)'{{ asset('storage/' . $product->main_image) }}'@endif
            @if($product->images)
                @foreach($product->images as $image)
                    , '{{ asset('storage/' . $image) }}'
                @endforeach
            @endif
        ],

        get maxStock() {
            return {{ $product->stock }};
        },

        get totalItems() {
            return Object.values(this.cart).reduce((sum, item) => sum + (item.qty || 0), 0);
        },

        get totalPrice() {
            let total = 0;
            for (const [variantId, item] of Object.entries(this.cart)) {
                if (item.qty > 0) {
                    const variant = this.variants.find(v => v.id == variantId);
                    if (variant) {
                        total += parseFloat(variant.effective_price) * item.qty;
                    }
                }
            }
            return total;
        },

        previewVariant(variant) {
            this.previewingVariantId = variant.id;
            if (variant.image) {
                this.selectedImage = '{{ asset('storage/') }}/' + variant.image;
            } else if (this.defaultImage) {
                this.selectedImage = this.defaultImage;
            }
        },

        updateCart(variantId, delta, maxStock) {
            if (!this.cart[variantId]) {
                this.cart[variantId] = { qty: 0 };
            }
            const newQty = this.cart[variantId].qty + delta;
            if (newQty < 0 || newQty > maxStock) return;
            this.cart[variantId] = { qty: newQty };
        },

        getVariantName(variant) {
            return variant.attribute_values.map(av => av.value).join(' / ');
        },

        getVariantColor(variant) {
            const colorAttr = variant.attribute_values.find(av => av.color_hex);
            return colorAttr ? colorAttr.color_hex : null;
        },

        formatPrice(price) {
            if (!price) return '';
            return new Intl.NumberFormat('fr-FR', {
                style: 'currency',
                currency: 'EUR',
                minimumFractionDigits: 0
            }).format(price);
        },

        prevImage() {
            if (this.allImages.length <= 1) return;
            const currentIndex = this.allImages.indexOf(this.selectedImage);
            const prevIndex = (currentIndex - 1 + this.allImages.length) % this.allImages.length;
            this.selectedImage = this.allImages[prevIndex];
        },

        nextImage() {
            if (this.allImages.length <= 1) return;
            const currentIndex = this.allImages.indexOf(this.selectedImage);
            const nextIndex = (currentIndex + 1) % this.allImages.length;
            this.selectedImage = this.allImages[nextIndex];
        }
    }
}
</script>
@endpush
