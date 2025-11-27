@extends('layouts.public')

@section('title', 'Paiement Réussi')
@section('description', 'Votre paiement a été effectué avec succès')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-green-50 to-neutral-50 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 text-center">
                <!-- Success Icon -->
                <div class="mb-6">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                        <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>

                <!-- Success Message -->
                <h1 class="text-3xl font-bold text-neutral-900 mb-4">Paiement Réussi !</h1>
                <p class="text-lg text-neutral-600 mb-8">
                    Votre commande <span class="font-semibold text-primary-500">#{{ $order->order_number }}</span> a été
                    payée avec succès
                </p>

                <!-- Order Info -->
                <div class="bg-gradient-to-br from-primary-50 to-neutral-50 rounded-xl p-6 mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                        <div>
                            <p class="text-sm text-neutral-500 mb-1">Montant payé</p>
                            <p class="text-2xl font-bold text-primary-500">{{ number_format($order->total, 0, ',', ' ') }}
                                €</p>
                        </div>
                        <div>
                            <p class="text-sm text-neutral-500 mb-1">Date du paiement</p>
                            <p class="text-lg font-semibold text-neutral-900">{{ $order->paid_at->format('d/m/Y à H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- What's Next -->
                <div class="bg-blue-50 rounded-xl p-6 mb-8 text-left">
                    <h3 class="text-lg font-bold text-neutral-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Que se passe-t-il maintenant ?
                    </h3>
                    <ul class="space-y-2 text-sm text-neutral-600">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Un email de confirmation a été envoyé à
                                <strong>{{ $order->shipping_email }}</strong></span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Votre commande est en cours de traitement</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Nous vous contacterons pour la livraison</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Vous pouvez suivre l'état de votre commande depuis votre compte</span>
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('client.orders.show', $order) }}" class="btn-primary">
                        <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Voir ma commande
                    </a>
                    <a href="{{ route('shop.index') }}" class="btn-secondary">
                        <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Continuer mes achats
                    </a>
                </div>

                <!-- Support -->
                <div class="mt-8 pt-8 border-t border-neutral-200">
                    <p class="text-sm text-neutral-600">
                        Une question sur votre commande ?
                        <a href="{{ route('contact') }}" class="text-primary-500 hover:text-primary-600 font-medium">
                            Contactez-nous
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
