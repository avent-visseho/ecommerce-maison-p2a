@extends('layouts.public')

@section('title', __('cart.title'))

@section('content')
    <!-- Page Header -->
    <section class="bg-gradient-to-br from-primary-50 to-neutral-50 py-12 border-b border-neutral-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-neutral-900 mb-2">{{ __('cart.shopping_cart') }}</h1>
                    <p class="text-neutral-400">{{ __('cart.items_in_cart', ['count' => count($cart)]) }}</p>
                </div>
                <a href="{{ route('shop.index') }}"
                    class="hidden md:flex items-center text-primary-500 hover:text-primary-600 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('cart.continue_shopping') }}
                </a>
            </div>
        </div>
    </section>

    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (count($cart) > 0)
                <div class="lg:grid lg:grid-cols-3 lg:gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2 space-y-4">
                        @foreach ($cart as $cartKey => $item)
                            <div class="card">
                                <div class="card-body">
                                    <div class="flex items-start space-x-4">
                                        <!-- Product Image -->
                                        <div class="w-24 h-24 flex-shrink-0 bg-neutral-100 rounded-xl overflow-hidden">
                                            @if ($item['image'])
                                                <img src="{{ asset('storage/' . $item['image']) }}"
                                                    alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-neutral-300" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Product Info -->
                                        <div class="flex-1 min-w-0">
                                            @if(isset($item['type']) && $item['type'] === 'rental')
                                                <!-- Rental Item -->
                                                <div class="mb-2">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        Location
                                                    </span>
                                                </div>

                                                <h3 class="text-lg font-semibold text-neutral-900 mb-1">
                                                    <a href="{{ route('rentals.show', $item['slug']) }}"
                                                        class="hover:text-primary-500 transition-colors">
                                                        {{ $item['name'] }}
                                                    </a>
                                                </h3>

                                                <div class="space-y-1 mb-3">
                                                    <p class="text-sm text-neutral-600">
                                                        <span class="font-medium">Du:</span> {{ \Carbon\Carbon::parse($item['start_date'])->format('d/m/Y') }}
                                                        <span class="mx-2">→</span>
                                                        <span class="font-medium">Au:</span> {{ \Carbon\Carbon::parse($item['end_date'])->format('d/m/Y') }}
                                                    </p>
                                                    <p class="text-sm text-neutral-600">
                                                        <span class="font-medium">Durée:</span> {{ $item['duration_days'] }} jour(s)
                                                    </p>
                                                    <p class="text-sm text-neutral-600">
                                                        <span class="font-medium">Quantité:</span> {{ $item['quantity'] }}
                                                    </p>
                                                    <p class="text-sm text-neutral-600">
                                                        <span class="font-medium">Prix location:</span> {{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} €
                                                    </p>
                                                    <p class="text-sm text-amber-600 font-medium">
                                                        <span class="font-semibold">Caution:</span> {{ number_format($item['deposit'] * $item['quantity'], 0, ',', ' ') }} €
                                                    </p>
                                                </div>

                                                <!-- Remove Button -->
                                                <form action="{{ route('cart.remove', $cartKey) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-sm text-red-500 hover:text-red-700 font-medium">
                                                        {{ __('cart.remove') }}
                                                    </button>
                                                </form>
                                            @else
                                                <!-- Regular Product -->
                                                <h3 class="text-lg font-semibold text-neutral-900 mb-1">
                                                    <a href="{{ route('shop.show', $item['slug']) }}"
                                                        class="hover:text-primary-500 transition-colors">
                                                        {{ $item['name'] }}
                                                    </a>
                                                </h3>

                                                @if(isset($item['variant_name']) && $item['variant_name'])
                                                    <p class="text-sm text-primary-500 font-medium mb-1">
                                                        {{ $item['variant_name'] }}
                                                    </p>
                                                @endif

                                                <p class="text-sm text-neutral-400 mb-3">
                                                    {{ __('cart.unit_price') }}: {{ number_format($item['price'], 0, ',', ' ') }} €
                                                </p>

                                                <div class="flex items-center space-x-4">
                                                    <!-- Quantity Selector -->
                                                    <form action="{{ route('cart.update', $cartKey) }}" method="POST"
                                                        class="flex items-center border border-neutral-200 rounded-lg">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button"
                                                            onclick="updateQuantity('{{ $cartKey }}', {{ $item['quantity'] - 1 }})"
                                                            class="px-3 py-2 hover:bg-neutral-50 transition-colors">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M20 12H4" />
                                                            </svg>
                                                        </button>
                                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                                            min="1" max="{{ $item['stock'] }}"
                                                            class="w-12 text-center border-0 focus:ring-0 font-semibold text-sm py-2"
                                                            onchange="this.form.submit()">
                                                        <button type="button"
                                                            onclick="updateQuantity('{{ $cartKey }}', {{ $item['quantity'] + 1 }})"
                                                            class="px-3 py-2 hover:bg-neutral-50 transition-colors">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M12 4v16m8-8H4" />
                                                            </svg>
                                                        </button>
                                                    </form>

                                                    <!-- Remove Button -->
                                                    <form action="{{ route('cart.remove', $cartKey) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-sm text-red-500 hover:text-red-700 font-medium">
                                                            {{ __('cart.remove') }}
                                                        </button>
                                                    </form>
                                                </div>

                                                @if ($item['quantity'] >= $item['stock'])
                                                    <p class="text-xs text-orange-600 mt-2">{{ __('cart.max_stock_reached') }}</p>
                                                @endif
                                            @endif
                                        </div>

                                        <!-- Subtotal -->
                                        <div class="text-right">
                                            @if(isset($item['type']) && $item['type'] === 'rental')
                                                <div class="space-y-1">
                                                    <p class="text-lg font-bold text-neutral-900">
                                                        {{ number_format(($item['price'] * $item['quantity']) + ($item['deposit'] * $item['quantity']), 0, ',', ' ') }} €
                                                    </p>
                                                    <p class="text-xs text-neutral-400">
                                                        (incl. caution)
                                                    </p>
                                                </div>
                                            @else
                                                <p class="text-xl font-bold text-neutral-900">
                                                    {{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} €
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Clear Cart -->
                        <form action="{{ route('cart.clear') }}" method="POST" class="mt-6">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('{{ __('cart.confirm_clear') }}')"
                                class="text-sm text-red-500 hover:text-red-700 font-medium">
                                {{ __('cart.clear_cart') }}
                            </button>
                        </form>
                    </div>

                    <!-- Order Summary -->
                    <div class="mt-8 lg:mt-0">
                        <div class="card sticky top-24">
                            <div class="card-header">
                                <h3 class="text-lg font-semibold text-neutral-900">{{ __('cart.order_summary') }}</h3>
                            </div>
                            <div class="card-body space-y-4">
                                <div class="flex justify-between text-neutral-600">
                                    <span>{{ __('cart.subtotal') }}</span>
                                    <span class="font-semibold">{{ number_format($totals['subtotal'], 0, ',', ' ') }} €</span>
                                </div>

                                @if($totals['deposits'] > 0)
                                    <div class="flex justify-between text-amber-600">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Cautions
                                        </span>
                                        <span class="font-semibold">{{ number_format($totals['deposits'], 0, ',', ' ') }} €</span>
                                    </div>
                                    <p class="text-xs text-neutral-500 -mt-2">
                                        Les cautions seront restituées après retour des articles
                                    </p>
                                @endif

                                <div class="flex justify-between text-neutral-600">
                                    <span>{{ __('cart.shipping') }}</span>
                                    <span class="font-semibold">{{ __('cart.to_be_determined') }}</span>
                                </div>

                                <div class="pt-4 border-t border-neutral-200">
                                    <div class="flex justify-between text-lg font-bold text-neutral-900">
                                        <span>{{ __('cart.total') }}</span>
                                        <span class="text-primary-500">{{ number_format($totals['total'], 0, ',', ' ') }} €</span>
                                    </div>
                                </div>

                                <!-- Promo Code -->
                                {{-- <div class="pt-4 border-t border-neutral-200">
                                    <label class="label text-sm">Code Promo</label>
                                    <div class="flex space-x-2">
                                        <input type="text" placeholder="Entrez votre code" class="input-field text-sm">
                                        <button class="btn-secondary text-sm whitespace-nowrap">
                                            Appliquer
                                        </button>
                                    </div>
                                </div> --}}

                                <!-- Checkout Button -->
                                @auth
                                    <a href="{{ route('checkout.index') }}" class="block w-full btn-primary text-center">
                                        {{ __('cart.place_order') }}
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="block w-full btn-primary text-center">
                                        {{ __('cart.login_to_order') }}
                                    </a>
                                @endauth

                                <!-- Continue Shopping -->
                                <a href="{{ route('shop.index') }}"
                                    class="block text-center text-sm text-primary-500 hover:text-primary-600 font-medium">
                                    {{ __('cart.continue_shopping') }}
                                </a>

                                <!-- Trust Badges -->
                                <div class="pt-4 border-t border-neutral-200 space-y-3">
                                    <div class="flex items-center text-sm text-neutral-600">
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        {{ __('cart.secure_payment_100') }}
                                    </div>
                                    <div class="flex items-center text-sm text-neutral-600">
                                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                        </svg>
                                        {{ __('cart.fast_delivery') }}
                                    </div>
                                    <div class="flex items-center text-sm text-neutral-600">
                                        <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        {{ __('cart.returns_14_days') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart -->
                <div class="text-center py-20">
                    <div class="w-32 h-32 bg-neutral-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-16 h-16 text-neutral-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-neutral-900 mb-4">{{ __('cart.empty_cart') }}</h2>
                    <p class="text-neutral-400 mb-8 max-w-md mx-auto">
                        {{ __('cart.empty_cart_message') }}
                    </p>
                    <a href="{{ route('shop.index') }}" class="btn-primary inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        {{ __('cart.discover_shop') }}
                    </a>
                </div>
            @endif
        </div>
    </section>

    @push('scripts')
        <script>
            function updateQuantity(productId, newQuantity) {
                if (newQuantity < 1) return;

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/cart/update/${productId}`;

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';

                const quantityInput = document.createElement('input');
                quantityInput.type = 'hidden';
                quantityInput.name = 'quantity';
                quantityInput.value = newQuantity;

                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                form.appendChild(quantityInput);

                document.body.appendChild(form);
                form.submit();
            }
        </script>
    @endpush
@endsection
