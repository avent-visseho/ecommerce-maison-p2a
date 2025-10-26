@extends('layouts.public')

@section('title', 'Panier')

@section('content')
    <!-- Page Header -->
    <section class="bg-gradient-to-br from-primary-50 to-neutral-50 py-12 border-b border-neutral-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-neutral-900 mb-2">Panier d'Achat</h1>
                    <p class="text-neutral-400">{{ count($cart) }} article(s) dans votre panier</p>
                </div>
                <a href="{{ route('shop.index') }}"
                    class="hidden md:flex items-center text-primary-500 hover:text-primary-600 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Continuer les achats
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
                        @foreach ($cart as $id => $item)
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
                                            <h3 class="text-lg font-semibold text-neutral-900 mb-1">
                                                <a href="{{ route('shop.show', $item['slug']) }}"
                                                    class="hover:text-primary-500 transition-colors">
                                                    {{ $item['name'] }}
                                                </a>
                                            </h3>
                                            <p class="text-sm text-neutral-400 mb-3">
                                                Prix unitaire: {{ number_format($item['price'], 0, ',', ' ') }} FCFA
                                            </p>

                                            <div class="flex items-center space-x-4">
                                                <!-- Quantity Selector -->
                                                <form action="{{ route('cart.update', $id) }}" method="POST"
                                                    class="flex items-center border border-neutral-200 rounded-lg">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="button"
                                                        onclick="updateQuantity({{ $id }}, {{ $item['quantity'] - 1 }})"
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
                                                        onclick="updateQuantity({{ $id }}, {{ $item['quantity'] + 1 }})"
                                                        class="px-3 py-2 hover:bg-neutral-50 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                    </button>
                                                </form>

                                                <!-- Remove Button -->
                                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-sm text-red-500 hover:text-red-700 font-medium">
                                                        Retirer
                                                    </button>
                                                </form>
                                            </div>

                                            @if ($item['quantity'] >= $item['stock'])
                                                <p class="text-xs text-orange-600 mt-2">Stock maximum atteint</p>
                                            @endif
                                        </div>

                                        <!-- Subtotal -->
                                        <div class="text-right">
                                            <p class="text-xl font-bold text-neutral-900">
                                                {{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} FCFA
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Clear Cart -->
                        <form action="{{ route('cart.clear') }}" method="POST" class="mt-6">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir vider le panier ?')"
                                class="text-sm text-red-500 hover:text-red-700 font-medium">
                                Vider le panier
                            </button>
                        </form>
                    </div>

                    <!-- Order Summary -->
                    <div class="mt-8 lg:mt-0">
                        <div class="card sticky top-24">
                            <div class="card-header">
                                <h3 class="text-lg font-semibold text-neutral-900">Résumé de la Commande</h3>
                            </div>
                            <div class="card-body space-y-4">
                                <div class="flex justify-between text-neutral-600">
                                    <span>Sous-total</span>
                                    <span class="font-semibold">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                                </div>

                                <div class="flex justify-between text-neutral-600">
                                    <span>Livraison</span>
                                    <span class="font-semibold">2,000 FCFA</span>
                                </div>

                                <div class="pt-4 border-t border-neutral-200">
                                    <div class="flex justify-between text-lg font-bold text-neutral-900">
                                        <span>Total</span>
                                        <span class="text-primary-500">{{ number_format($total + 2000, 0, ',', ' ') }}
                                            FCFA</span>
                                    </div>
                                </div>

                                <!-- Promo Code -->
                                <div class="pt-4 border-t border-neutral-200">
                                    <label class="label text-sm">Code Promo</label>
                                    <div class="flex space-x-2">
                                        <input type="text" placeholder="Entrez votre code" class="input-field text-sm">
                                        <button class="btn-secondary text-sm whitespace-nowrap">
                                            Appliquer
                                        </button>
                                    </div>
                                </div>

                                <!-- Checkout Button -->
                                @auth
                                    <a href="{{ route('checkout.index') }}" class="block w-full btn-primary text-center">
                                        Passer la commande
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="block w-full btn-primary text-center">
                                        Se connecter pour commander
                                    </a>
                                @endauth

                                <!-- Continue Shopping -->
                                <a href="{{ route('shop.index') }}"
                                    class="block text-center text-sm text-primary-500 hover:text-primary-600 font-medium">
                                    Continuer les achats
                                </a>

                                <!-- Trust Badges -->
                                <div class="pt-4 border-t border-neutral-200 space-y-3">
                                    <div class="flex items-center text-sm text-neutral-600">
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        Paiement 100% sécurisé
                                    </div>
                                    <div class="flex items-center text-sm text-neutral-600">
                                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                        </svg>
                                        Livraison rapide 2-5 jours
                                    </div>
                                    <div class="flex items-center text-sm text-neutral-600">
                                        <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Retours sous 14 jours
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
                    <h2 class="text-3xl font-bold text-neutral-900 mb-4">Votre panier est vide</h2>
                    <p class="text-neutral-400 mb-8 max-w-md mx-auto">
                        Vous n'avez pas encore ajouté de produits à votre panier. Parcourez notre boutique pour découvrir
                        nos produits.
                    </p>
                    <a href="{{ route('shop.index') }}" class="btn-primary inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Découvrir la boutique
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
