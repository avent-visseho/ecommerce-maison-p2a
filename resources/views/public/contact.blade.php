@extends('layouts.public')

@section('title', 'Contact')
@section('description', 'Contactez-nous pour toute question ou demande de devis')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-primary-50 to-neutral-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-5xl font-bold text-neutral-900 mb-6">Contactez-Nous</h1>
                <p class="text-xl text-neutral-600 leading-relaxed">
                    Notre équipe est à votre écoute pour répondre à toutes vos questions
                </p>
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Contact Info -->
                <div class="space-y-8">
                    <div>
                        <h2 class="text-2xl font-bold text-neutral-900 mb-6">Informations de Contact</h2>
                        <p class="text-neutral-600 mb-8">
                            N'hésitez pas à nous contacter par le moyen qui vous convient le mieux. Nous sommes là pour vous
                            aider !
                        </p>
                    </div>

                    <!-- Contact Cards -->
                    <div class="space-y-4">
                        <div class="card hover:shadow-lg transition-all">
                            <div class="card-body">
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-neutral-900 mb-1">Adresse</h3>
                                        <p class="text-neutral-600 text-sm">Cotonou, Bénin</p>
                                        <p class="text-neutral-600 text-sm">Quartier des Cocotiers</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card hover:shadow-lg transition-all">
                            <div class="card-body">
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-neutral-900 mb-1">Téléphone</h3>
                                        <p class="text-neutral-600 text-sm">+229 01 90 01 68 79</p>
                                        <p class="text-neutral-400 text-xs mt-1">Lun - Sam: 9h - 18h</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card hover:shadow-lg transition-all">
                            <div class="card-body">
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-neutral-900 mb-1">Email</h3>
                                        <p class="text-neutral-600 text-sm">Lamaisonp2a@outlook.com</p>
                                        <p class="text-neutral-400 text-xs mt-1">Réponse sous 24h</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card hover:shadow-lg transition-all">
                            <div class="card-body">
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-neutral-900 mb-1">Horaires</h3>
                                        <p class="text-neutral-600 text-sm">Lun - Ven: 9h - 18h</p>
                                        <p class="text-neutral-600 text-sm">Samedi: 10h - 16h</p>
                                        <p class="text-neutral-400 text-sm">Dimanche: Fermé</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div>
                        <h3 class="font-semibold text-neutral-900 mb-4">Suivez-nous</h3>
                        <div class="flex space-x-3">
                            <a href="#"
                                class="w-10 h-10 bg-neutral-100 rounded-lg flex items-center justify-center hover:bg-primary-500 hover:text-white transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-10 h-10 bg-neutral-100 rounded-lg flex items-center justify-center hover:bg-primary-500 hover:text-white transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-10 h-10 bg-neutral-100 rounded-lg flex items-center justify-center hover:bg-primary-500 hover:text-white transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-10 h-10 bg-neutral-100 rounded-lg flex items-center justify-center hover:bg-primary-500 hover:text-white transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="lg:col-span-2">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="text-2xl font-bold text-neutral-900">Envoyez-nous un Message</h2>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div
                                    class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5">
                                @csrf

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label for="name" class="label">Nom complet <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                                            required class="input-field @error('name') border-red-500 @enderror"
                                            placeholder="Jean Dupont">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="email" class="label">Email <span
                                                class="text-red-500">*</span></label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                            required class="input-field @error('email') border-red-500 @enderror"
                                            placeholder="jean@exemple.com">
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label for="phone" class="label">Téléphone</label>
                                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                            class="input-field @error('phone') border-red-500 @enderror"
                                            placeholder="+229 01 90 01 68 79">
                                        @error('phone')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="subject" class="label">Sujet <span
                                                class="text-red-500">*</span></label>
                                        <select id="subject" name="subject" required
                                            class="input-field @error('subject') border-red-500 @enderror">
                                            <option value="">Sélectionnez un sujet</option>
                                            <option value="Demande de devis"
                                                {{ old('subject') == 'Demande de devis' ? 'selected' : '' }}>Demande de
                                                devis</option>
                                            <option value="Décoration intérieure"
                                                {{ old('subject') == 'Décoration intérieure' ? 'selected' : '' }}>Décoration
                                                intérieure</option>
                                            <option value="Événement"
                                                {{ old('subject') == 'Événement' ? 'selected' : '' }}>Organisation
                                                d'événement</option>
                                            <option value="Question produit"
                                                {{ old('subject') == 'Question produit' ? 'selected' : '' }}>Question sur
                                                un produit</option>
                                            <option value="Autre" {{ old('subject') == 'Autre' ? 'selected' : '' }}>Autre
                                            </option>
                                        </select>
                                        @error('subject')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="message" class="label">Message <span
                                            class="text-red-500">*</span></label>
                                    <textarea id="message" name="message" rows="6" required
                                        class="input-field @error('message') border-red-500 @enderror"
                                        placeholder="Décrivez votre projet ou posez votre question...">{{ old('message') }}</textarea>
                                    @error('message')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-start">
                                    <input type="checkbox" id="consent" name="consent" required
                                        class="mt-1 rounded border-neutral-300 text-primary-500 focus:ring-primary-500">
                                    <label for="consent" class="ml-3 text-sm text-neutral-600">
                                        J'accepte que mes données soient utilisées pour me recontacter concernant ma
                                        demande. <span class="text-red-500">*</span>
                                    </label>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit" class="btn-primary flex items-center space-x-2">
                                        <span>Envoyer le message</span>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section (Optional) -->
    <section class="py-20 bg-neutral-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-neutral-900 mb-4">Trouvez-nous</h2>
                <p class="text-neutral-600">Venez nous rendre visite dans notre showroom</p>
            </div>
            <div class="bg-neutral-200 rounded-2xl h-96 flex items-center justify-center">
                <p class="text-neutral-500">Carte Google Maps à intégrer ici</p>
            </div>
        </div>
    </section>
@endsection
