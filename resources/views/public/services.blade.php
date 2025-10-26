    @extends('layouts.public')

    @section('title', 'Nos Services')
    @section('description', 'Découvrez nos services de décoration d\'intérieur, aménagement d\'espaces et organisation
        d\'événements')

    @section('content')
        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-primary-50 to-neutral-50 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto">
                    <h1 class="text-5xl font-bold text-neutral-900 mb-6">Nos Services</h1>
                    <p class="text-xl text-neutral-600 leading-relaxed">
                        Des solutions complètes pour tous vos projets de décoration et d'aménagement
                    </p>
                </div>
            </div>
        </section>

        <!-- Main Services -->
        <section class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="space-y-24">
                    <!-- Service 1: Interior Design -->
                    <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                        <div class="mb-12 lg:mb-0">
                            <div class="relative">
                                <div class="aspect-[4/3] rounded-2xl overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=800"
                                        alt="Décoration d'intérieur" class="w-full h-full object-cover">
                                </div>
                                <div class="absolute -bottom-6 -right-6 w-48 h-48 bg-primary-100 rounded-2xl -z-10"></div>
                            </div>
                        </div>
                        <div>
                            <span
                                class="inline-flex items-center px-4 py-2 bg-primary-50 text-primary-500 rounded-full text-sm font-medium mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Décoration d'Intérieur
                            </span>
                            <h2 class="text-4xl font-bold text-neutral-900 mb-6">Transformez Votre Intérieur</h2>
                            <p class="text-neutral-600 leading-relaxed mb-6">
                                Notre équipe de décorateurs professionnels vous accompagne dans la création d'espaces qui
                                vous ressemblent. Du concept initial à la réalisation finale, nous prenons en charge tous
                                les aspects de votre projet.
                            </p>
                            <ul class="space-y-3 mb-8">
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">Consultation personnalisée et analyse de vos
                                        besoins</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">Création de planches d'ambiance et visualisation
                                        3D</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">Sélection de mobilier et accessoires personnalisés</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">Coordination complète de la réalisation</span>
                                </li>
                            </ul>
                            <a href="{{ route('contact') }}" class="btn-primary inline-flex items-center">
                                Demander un devis
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Service 2: Event Decoration -->
                    <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                        <div class="mb-12 lg:mb-0 lg:order-2">
                            <div class="relative">
                                <div class="aspect-[4/3] rounded-2xl overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=800"
                                        alt="Décoration événementielle" class="w-full h-full object-cover">
                                </div>
                                <div class="absolute -bottom-6 -left-6 w-48 h-48 bg-green-100 rounded-2xl -z-10"></div>
                            </div>
                        </div>
                        <div class="lg:order-1">
                            <span
                                class="inline-flex items-center px-4 py-2 bg-green-50 text-green-600 rounded-full text-sm font-medium mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                                Décoration Événementielle
                            </span>
                            <h2 class="text-4xl font-bold text-neutral-900 mb-6">Créez des Moments Inoubliables</h2>
                            <p class="text-neutral-600 leading-relaxed mb-6">
                                Que ce soit pour un mariage, un anniversaire, un événement d'entreprise ou toute autre
                                célébration, nous créons des ambiances magiques qui marqueront les esprits.
                            </p>
                            <ul class="space-y-3 mb-8">
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">Design et conception sur mesure</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">Location de mobilier et accessoires événementiels</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">Installation et démontage sur site</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">Coordination le jour J</span>
                                </li>
                            </ul>
                            <a href="{{ route('contact') }}" class="btn-primary inline-flex items-center">
                                Planifier un événement
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Service 3: Consultation -->
                    <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                        <div class="mb-12 lg:mb-0">
                            <div class="relative">
                                <div class="aspect-[4/3] rounded-2xl overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800"
                                        alt="Conseil en aménagement" class="w-full h-full object-cover">
                                </div>
                                <div class="absolute -bottom-6 -right-6 w-48 h-48 bg-blue-100 rounded-2xl -z-10"></div>
                            </div>
                        </div>
                        <div>
                            <span
                                class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-600 rounded-full text-sm font-medium mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                                Conseil en Aménagement
                            </span>
                            <h2 class="text-4xl font-bold text-neutral-900 mb-6">Des Conseils d'Experts</h2>
                            <p class="text-neutral-600 leading-relaxed mb-6">
                                Vous avez besoin de conseils pour optimiser votre espace ? Notre service de consultation
                                vous guide dans vos choix de décoration et d'aménagement.
                            </p>
                            <ul class="space-y-3 mb-8">
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">Session de consultation à domicile ou en ligne</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">Analyse de votre espace et recommandations</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">Sélection de produits adaptés à votre budget</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">Dossier de recommandations détaillé</span>
                                </li>
                            </ul>
                            <a href="{{ route('contact') }}" class="btn-primary inline-flex items-center">
                                Réserver une consultation
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Process Section -->
        <section class="py-20 bg-neutral-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-neutral-900 mb-4">Notre Processus</h2>
                    <p class="text-lg text-neutral-600 max-w-2xl mx-auto">
                        Une approche structurée pour garantir votre satisfaction
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="text-center relative">
                        <div
                            class="w-16 h-16 bg-primary-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">
                            1
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 mb-3">Consultation</h3>
                        <p class="text-neutral-600">Nous écoutons vos besoins et vos envies</p>
                        <div class="hidden md:block absolute top-8 left-full w-full h-0.5 bg-neutral-200 -translate-x-1/2">
                        </div>
                    </div>

                    <div class="text-center relative">
                        <div
                            class="w-16 h-16 bg-primary-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">
                            2
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 mb-3">Conception</h3>
                        <p class="text-neutral-600">Création de concepts personnalisés</p>
                        <div class="hidden md:block absolute top-8 left-full w-full h-0.5 bg-neutral-200 -translate-x-1/2">
                        </div>
                    </div>

                    <div class="text-center relative">
                        <div
                            class="w-16 h-16 bg-primary-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">
                            3
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 mb-3">Réalisation</h3>
                        <p class="text-neutral-600">Mise en œuvre de votre projet</p>
                        <div class="hidden md:block absolute top-8 left-full w-full h-0.5 bg-neutral-200 -translate-x-1/2">
                        </div>
                    </div>

                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-primary-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">
                            4
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 mb-3">Livraison</h3>
                        <p class="text-neutral-600">Installation et touches finales</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-br from-primary-500 to-primary-700 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-10"></div>
            <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
                <h2 class="text-4xl font-bold mb-6">Commençons Votre Projet</h2>
                <p class="text-xl text-primary-100 mb-8">
                    Prenez rendez-vous avec notre équipe et concrétisons ensemble vos idées
                </p>
                <a href="{{ route('contact') }}"
                    class="btn-primary bg-white text-primary-500 hover:bg-neutral-50 inline-flex items-center">
                    Prendre Rendez-vous
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
        </section>
    @endsection
