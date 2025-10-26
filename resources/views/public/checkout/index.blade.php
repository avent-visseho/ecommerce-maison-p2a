@extends('layouts.public')

@section('title', 'Finaliser la commande')

@section('content')
    <!-- Progress Steps -->
    <section class="bg-neutral-50 py-8 border-b border-neutral-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center text-white font-semibold">
                            1
                        </div>
                        <span class="ml-3 text-sm font-medium text-neutral-900">Panier</span>
                    </div>
                    <svg class="w-6 h-6 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center text-white font-semibold">
                            2
                        </div>
                        <span class="ml-3 text-sm font-medium text-neutral-900">Livraison</span>
                    </div>
                    <svg class="w-6 h-6 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-neutral-200 rounded-full flex items-center justify-center text-neutral-600 font-semibold">
                            3
                        </div>
                        <span class="ml-3 text-sm font-medium text-neutral-400">Paiement</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <div class="lg:grid lg:grid-cols-3 lg:gap-8">
                    <!-- Checkout Form -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Contact Information -->
                        <div class="card">
                            <div class="card-header">
                                <h2 class="text-xl font-semibold text-neutral-900">Informations de Contact</h2>
                            </div>
                            <div class="card-body space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="shipping_name" class="label">Nom complet <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" id="shipping_name" name="shipping_name"
                                            value="{{ old('shipping_name', auth()->user()->name) }}" required
                                            class="input-field @error('shipping_name') border-red-500 @enderror">
                                        @error('shipping_name')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="shipping_email" class="label">Email <span
                                                class="text-red-500">*</span></label>
                                        <input type="email" id="shipping_email" name="shipping_email"
                                            value="{{ old('shipping_email', auth()->user()->email) }}" required
                                            class="input-field @error('shipping_email') border-red-500 @enderror">
                                        @error('shipping_email')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="shipping_phone" class="label">Téléphone <span
                                            class="text-red-500">*</span></label>
                                    <input type="tel" id="shipping_phone" name="shipping_phone"
                                        value="{{ old('shipping_phone', auth()->user()->phone) }}" required
                                        placeholder="+229 XX XX XX XX"
                                        class="input-field @error('shipping_phone') border-red-500 @enderror">
                                    @error('shipping_phone')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="card">
                            <div class="card-header">
                                <h2 class="text-xl font-semibold text-neutral-900">Adresse de Livraison</h2>
                            </div>
                            <div class="card-body space-y-4">
                                <div>
                                    <label for="shipping_address" class="label">Adresse complète <span
                                            class="text-red-500">*</span></label>
                                    <textarea id="shipping_address" name="shipping_address" rows="3" required placeholder="Numéro, rue, quartier..."
                                        class="input-field @error('shipping_address') border-red-500 @enderror">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                                    @error('shipping_address')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="shipping_city" class="label">Ville <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" id="shipping_city" name="shipping_city"
                                            value="{{ old('shipping_city', auth()->user()->city ?? 'Cotonou') }}" required
                                            class="input-field @error('shipping_city') border-red-500 @enderror">
                                        @error('shipping_city')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="shipping_postal_code" class="label">Code postal</label>
                                        <input type="text" id="shipping_postal_code" name="shipping_postal_code"
                                            value="{{ old('shipping_postal_code', auth()->user()->postal_code) }}"
                                            class="input-field @error('shipping_postal_code') border-red-500 @enderror">
                                        @error('shipping_postal_code')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Notes -->
                        <div class="card">
                            <div class="card-header">
                                <h2 class="text-xl font-semibold text-neutral-900">Notes de commande (optionnel)</h2>
                            </div>
                            <div class="card-body">
                                <textarea id="notes" name="notes" rows="4" placeholder="Instructions spéciales pour la livraison..."
                                    class="input-field">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="mt-8 lg:mt-0">
                        <div class="card sticky top-24">
                            <div class="card-header">
                                <h2 class="text-xl font-semibold text-neutral-900">Votre Commande</h2>
                            </div>
                            <div class="card-body">
                                <!-- Cart Items -->
                                <div class="space-y-4 pb-4 border-b border-neutral-200">
                                    @foreach ($cart as $item)
                                        <div class="flex items-center space-x-3">
                                            <div class="w-16 h-16 flex-shrink-0 bg-neutral-100 rounded-lg overflow-hidden">
                                                @if ($item['image'])
                                                    <img src="{{ asset('storage/' . $item['image']) }}"
                                                        alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-neutral-900 truncate">
                                                    {{ $item['name'] }}</p>
                                                <p class="text-xs text-neutral-400">Quantité: {{ $item['quantity'] }}</p>
                                            </div>
                                            <p class="text-sm font-semibold text-neutral-900">
                                                {{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} FCFA
                                            </p>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Totals -->
                                <div class="space-y-3 py-4">
                                    <div class="flex justify-between text-neutral-600">
                                        <span>Sous-total</span>
                                        <span class="font-semibold">{{ number_format($subtotal, 0, ',', ' ') }}
                                            FCFA</span>
                                    </div>

                                    <div class="flex justify-between text-neutral-600">
                                        <span>Livraison</span>
                                        <span class="font-semibold">{{ number_format($shipping, 0, ',', ' ') }}
                                            FCFA</span>
                                    </div>

                                    <div class="pt-3 border-t border-neutral-200">
                                        <div class="flex justify-between text-xl font-bold">
                                            <span class="text-neutral-900">Total</span>
                                            <span class="text-primary-500">{{ number_format($total, 0, ',', ' ') }}
                                                FCFA</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Info -->
                                <div class="pt-4 border-t border-neutral-200 mb-6">
                                    <div class="bg-primary-50 rounded-lg p-4">
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-primary-500 mr-3 mt-0.5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-primary-900 mb-1">Paiement sécurisé</p>
                                                <p class="text-xs text-primary-700">
                                                    Vous serez redirigé vers FedaPay pour finaliser le paiement en toute
                                                    sécurité.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit"
                                    class="w-full btn-primary flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <span>Passer au paiement</span>
                                </button>

                                <!-- Security Badges -->
                                <div class="pt-4 space-y-2">
                                    <div class="flex items-center text-xs text-neutral-600">
                                        <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        Paiement SSL sécurisé
                                    </div>
                                    <div class="flex items-center text-xs text-neutral-600">
                                        <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        Protection des données
                                    </div>
                                    <div class="flex items-center text-xs text-neutral-600">
                                        <svg class="w-4 h-4 text-purple-600 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        Paiement par FedaPay
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Back to Cart -->
                        <a href="{{ route('cart.index') }}"
                            class="mt-4 flex items-center justify-center text-sm text-neutral-400 hover:text-neutral-900">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Retour au panier
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
{{-- xs text-neutral-600">
<svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
</svg>
Paiement SSL sécurisé
</div>
<div class="flex items-center text- --}}
