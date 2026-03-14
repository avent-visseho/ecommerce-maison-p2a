@extends('layouts.public')

@section('title', __('about.title'))
@section('description', __('about.meta_description'))

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-primary-50 to-neutral-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-5xl font-bold text-neutral-900 mb-6">{{ __('about.hero_title') }}</h1>
                <p class="text-xl text-neutral-600 leading-relaxed">
                    {{ __('about.hero_description') }}
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
                        {{ __('about.since_2019') }}
                    </span>
                    <h2 class="text-4xl font-bold text-neutral-900 mb-6">{{ __('about.welcome_title') }}</h2>
                    <p class="text-xl text-primary-500 font-semibold mb-6">{{ __('about.tagline') }}</p>
                    <div class="space-y-4 text-neutral-600 leading-relaxed">
                        <p>
                            {!! __('about.story_p1') !!}
                        </p>
                        <p>
                            {!! __('about.story_p2') !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Universe Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-neutral-900 mb-4 flex justify-center items-center gap-6"><img
                        src="{{ asset('univers.png') }}" alt="La Maison P2A" class="h-16 w-16"> {{ __('about.our_universe') }}</h2>
                <p class="text-lg text-neutral-600 max-w-2xl mx-auto">
                    {{ __('about.universe_description') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Universe 1 -->
                <div
                    class="bg-neutral-50 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 border border-neutral-200">
                    <div class="w-16 h-16 bg-primary-100 rounded-2xl flex items-center justify-center mb-6">
                        {{-- <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg> --}}
                        <img src="{{ asset('objet.png') }}" alt="La Maison P2A" class="h-16 w-16">
                    </div>
                    <h3 class="text-2xl font-bold text-neutral-900 mb-4">{{ __('about.deco_objects') }}</h3>
                    <p class="text-neutral-600 leading-relaxed">
                        {{ __('about.deco_objects_desc') }}
                    </p>
                </div>

                <!-- Universe 2 -->
                <div
                    class="bg-neutral-50 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 border border-neutral-200">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mb-6">
                        {{-- <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg> --}}
                        <img src="{{ asset('evenement.png') }}" alt="La Maison P2A" class="h-16 w-16">
                    </div>
                    <h3 class="text-2xl font-bold text-neutral-900 mb-4">{{ __('about.event_deco') }}</h3>
                    <p class="text-neutral-600 leading-relaxed mb-4">
                        {{ __('about.event_deco_desc1') }}
                    </p>
                    <p class="text-neutral-600 leading-relaxed">
                        {{ __('about.event_deco_desc2') }}
                    </p>
                </div>

                <!-- Universe 3 -->
                <div
                    class="bg-neutral-50 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 border border-neutral-200">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6">
                        {{-- <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg> --}}
                        <img src="{{ asset('coordination.png') }}" alt="La Maison P2A" class="h-16 w-16">
                    </div>
                    <h3 class="text-2xl font-bold text-neutral-900 mb-4">{{ __('about.project_coordination') }}</h3>
                    <p class="text-neutral-600 leading-relaxed">
                        {{ __('about.project_coordination_desc') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Inspiration Section -->
    <section class="py-20 bg-gradient-to-br from-primary-50 to-neutral-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                <div class="order-2 lg:order-1">
                    <h2 class="text-4xl font-bold text-neutral-900 mb-6">{{ __('about.inspiration_title') }}</h2>
                    <p class="text-lg text-neutral-600 leading-relaxed">
                        {!! __('about.inspiration_desc') !!}
                    </p>
                </div>
                <div class="order-1 lg:order-2 mb-12 lg:mb-0">
                    <div class="relative">
                        <div class="aspect-[4/3] rounded-2xl overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=800"
                                alt="Inspiration de voyage" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute -bottom-6 -left-6 w-64 h-64 bg-primary-100 rounded-2xl -z-10"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-20 bg-neutral-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-neutral-900 mb-4">{{ __('about.our_values') }}</h2>
                <p class="text-lg text-neutral-600 max-w-2xl mx-auto">
                    {{ __('about.values_description') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white rounded-2xl p-8 text-center hover:shadow-lg transition-all">
                    <div class="w-16 h-16 flex items-center justify-center mx-auto mb-6"> {{--  bg-primary-100 rounded-2xl --}}
                        <img
                        src="{{ asset('service.png') }}" alt="La Maison P2A" class="h-16 w-16">
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">{{ __('about.quality') }}</h3>
                    <p class="text-neutral-600">{{ __('about.quality_desc') }}</p>
                </div>

                <div class="bg-white rounded-2xl p-8 text-center hover:shadow-lg transition-all">
                    <div class="w-16 h-16  flex items-center justify-center mx-auto mb-6"> {{-- bg-green-100 rounded-2xl --}}
                       <img
                        src="{{ asset('service-client.png') }}" alt="La Maison P2A" class="h-16 w-16">
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">{{ __('about.customer_service') }}</h3>
                    <p class="text-neutral-600">{{ __('about.customer_service_desc') }}</p>
                </div>

                <div class="bg-white rounded-2xl p-8 text-center hover:shadow-lg transition-all">
                    <div class="w-16 h-16 flex items-center justify-center mx-auto mb-6"> {{--  bg-blue-100 rounded-2xl --}}
                        <img
                        src="{{ asset('innovation.png') }}" alt="La Maison P2A" class="h-16 w-16">
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">{{ __('about.innovation') }}</h3>
                    <p class="text-neutral-600">{{ __('about.innovation_desc') }}</p>
                </div>

                <div class="bg-white rounded-2xl p-8 text-center hover:shadow-lg transition-all">
                    <div class="w-16 h-16  flex items-center justify-center mx-auto mb-6"> {{-- bg-purple-100 rounded-2xl --}}
                        <img
                        src="{{ asset('passion.png') }}" alt="La Maison P2A" class="h-16 w-16">
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">{{ __('about.passion') }}</h3>
                    <p class="text-neutral-600">{{ __('about.passion_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->


    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-primary-500 to-primary-700 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-10"></div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h2 class="text-4xl font-bold mb-6">{{ __('about.cta_title') }}</h2>
            <p class="text-xl text-primary-100 mb-8">
                {{ __('about.cta_description') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}" class="btn-primary bg-white text-primary-500 hover:bg-neutral-50">
                    {{ __('about.contact_us') }}
                </a>
                <a href="{{ route('shop.index') }}"
                    class="px-8 py-4 bg-white/10 backdrop-blur-sm text-white rounded-xl font-semibold hover:bg-white/20 transition-all border border-white/20">
                    {{ __('about.view_shop') }}
                </a>
            </div>
        </div>
    </section>
@endsection
