@extends('layouts.public')

@section('title', 'À Propos')
@section('description', 'Découvrez l\'histoire de La Maison P2A et notre passion pour la décoration d\'intérieur')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-primary-50 to-neutral-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-5xl font-bold text-neutral-900 mb-6">Notre Histoire</h1>
                <p class="text-xl text-neutral-600 leading-relaxed">
                    Depuis notre création, La Maison P2A s'est donnée pour mission de transformer les espaces de vie en
                    lieux uniques et inspirants.
                </p>
            </div>
        </div>
    </section>

    <!-- Story Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                <div class="mb-12 lg:mb-0">
                    <div class="relative">
                        <div class="aspect-square rounded-2xl overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=800"
                                alt="Notre showroom" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute -bottom-6 -right-6 w-64 h-64 bg-primary-100 rounded-2xl -z-10"></div>
                    </div>
                </div>
                <div>
                    <span
                        class="inline-block px-4 py-2 bg-primary-50 text-primary-500 rounded-full text-sm font-medium mb-4">
                        Depuis 2025
                    </span>
                    <h2 class="text-4xl font-bold text-neutral-900 mb-6">Une Passion Devenue Réalité</h2>
                    <div class="space-y-4 text-neutral-600 leading-relaxed">
                        <p>
                            La Maison P2A est née de la passion de créer des espaces qui racontent une histoire. Nous
                            croyons que chaque intérieur doit refléter la personnalité et le style de vie de ses occupants.
                        </p>
                        <p>
                            Notre équipe d'experts en décoration travaille sans relâche pour dénicher les plus belles pièces
                            et créer des ambiances uniques qui transforment les maisons en véritables havres de paix.
                        </p>
                        <p>
                            Aujourd'hui, nous sommes fiers de servir plus de 500 clients satisfaits à travers le Bénin, en
                            offrant une sélection soigneusement choisie de produits de qualité et des services de décoration
                            personnalisés.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-20 bg-neutral-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-neutral-900 mb-4">Nos Valeurs</h2>
                <p class="text-lg text-neutral-600 max-w-2xl mx-auto">
                    Les principes qui guident chacune de nos actions
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white rounded-2xl p-8 text-center hover:shadow-lg transition-all">
                    <div class="w-16 h-16 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Qualité</h3>
                    <p class="text-neutral-600">Nous sélectionnons uniquement des produits de qualité supérieure</p>
                </div>

                <div class="bg-white rounded-2xl p-8 text-center hover:shadow-lg transition-all">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Service Client</h3>
                    <p class="text-neutral-600">Une équipe dédiée pour vous accompagner à chaque étape</p>
                </div>

                <div class="bg-white rounded-2xl p-8 text-center hover:shadow-lg transition-all">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Innovation</h3>
                    <p class="text-neutral-600">Toujours à l'affût des dernières tendances en décoration</p>
                </div>

                <div class="bg-white rounded-2xl p-8 text-center hover:shadow-lg transition-all">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Passion</h3>
                    <p class="text-neutral-600">Chaque projet est réalisé avec amour et dévouement</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
   

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-primary-500 to-primary-700 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-10"></div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h2 class="text-4xl font-bold mb-6">Prêt à Commencer Votre Projet ?</h2>
            <p class="text-xl text-primary-100 mb-8">
                Contactez-nous dès aujourd'hui et transformons ensemble votre espace de vie
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}" class="btn-primary bg-white text-primary-500 hover:bg-neutral-50">
                    Nous Contacter
                </a>
                <a href="{{ route('shop.index') }}"
                    class="px-8 py-4 bg-white/10 backdrop-blur-sm text-white rounded-xl font-semibold hover:bg-white/20 transition-all border border-white/20">
                    Voir la Boutique
                </a>
            </div>
        </div>
    </section>
@endsection
