    @extends('layouts.public')

    @section('title', __('services.title'))
    @section('description', __('services.meta_description'))

    @section('content')
        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-primary-50 to-neutral-50 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto">
                    <h1 class="text-5xl font-bold text-neutral-900 mb-6">{{ __('services.hero_title') }}</h1>
                    <p class="text-xl text-neutral-600 leading-relaxed">
                        {{ __('services.hero_description') }}
                    </p>
                </div>
            </div>
        </section>

        <!-- Main Services -->
        <section class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="space-y-24">
                    <!-- Service 1: Interior Design -->
                    <div class="flex flex-col lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                        <div class="order-2 lg:order-1 mb-12 lg:mb-0">
                            <div class="relative">
                                <div class="aspect-[4/3] rounded-2xl overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=800"
                                        alt="Décoration d'intérieur" class="w-full h-full object-cover">
                                </div>
                                <div class="absolute -bottom-6 -right-6 w-48 h-48 bg-primary-100 rounded-2xl -z-10"></div>
                            </div>
                        </div>
                        <div class="order-1 lg:order-2 mb-8 lg:mb-0">
                            <span
                                class="inline-flex items-center px-4 py-2 bg-primary-50 text-primary-500 rounded-full text-sm font-medium mb-4">
                                {{--   <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg> --}}
                                {{ __('services.interior_design') }}
                            </span>
                            <h2 class="text-4xl font-bold text-neutral-900 mb-6">{{ __('services.interior_title') }}</h2>
                            <p class="text-neutral-600 leading-relaxed mb-6">
                                {!! __('services.interior_desc') !!}
                            </p>
                            <ul class="space-y-3 mb-8">
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">{{ __('services.interior_item1') }}</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">{{ __('services.interior_item2') }}</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">{{ __('services.interior_item3') }}</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">{{ __('services.interior_item4') }}</span>
                                </li>
                            </ul>
                            <a href="#" class="btn-primary inline-flex items-center">
                                {{ __('services.request_quote') }}
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Service 2: Event Decoration -->
                    <div class="flex flex-col lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                        <div class="order-2 mb-12 lg:mb-0">
                            <div class="relative">
                                <div class="aspect-[4/3] rounded-2xl overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=800"
                                        alt="Décoration événementielle" class="w-full h-full object-cover">
                                </div>
                                <div class="absolute -bottom-6 -left-6 w-48 h-48 bg-green-100 rounded-2xl -z-10"></div>
                            </div>
                        </div>
                        <div class="order-1 mb-8 lg:mb-0">
                            <span
                                class="inline-flex items-center px-4 py-2 bg-green-50 text-green-600 rounded-full text-sm font-medium mb-4">
                                {{--  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg> --}}
                                {{ __('services.event_decoration') }}
                            </span>
                            <h2 class="text-4xl font-bold text-neutral-900 mb-6">{{ __('services.event_title') }}
                            </h2>
                            <p class="text-neutral-600 leading-relaxed mb-6">
                                {!! __('services.event_desc') !!}
                            </p>
                            <ul class="space-y-3 mb-8">
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">{{ __('services.event_item1') }}</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">{{ __('services.event_item2') }}</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">{{ __('services.event_item3') }}</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">{{ __('services.event_item4') }}</span>
                                </li>
                            </ul>
                            <a href="{{ route('rentals.index') }}" class="btn-primary inline-flex items-center">
                                {{ __('services.plan_event') }}
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Service 3: Consultation -->
                    <div class="flex flex-col lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                        <div class="order-2 lg:order-1 mb-12 lg:mb-0">
                            <div class="relative">
                                <div class="aspect-[4/3] rounded-2xl overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800"
                                        alt="Conseil en aménagement" class="w-full h-full object-cover">
                                </div>
                                <div class="absolute -bottom-6 -right-6 w-48 h-48 bg-blue-100 rounded-2xl -z-10"></div>
                            </div>
                        </div>
                        <div class="order-1 lg:order-2 mb-8 lg:mb-0">
                            <span
                                class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-600 rounded-full text-sm font-medium mb-4">
                                {{-- <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg> --}}
                                {{ __('services.consultation') }}
                            </span>
                            <h2 class="text-4xl font-bold text-neutral-900 mb-6">{{ __('services.consultation_title') }}</h2>
                            <p class="text-neutral-600 leading-relaxed mb-6">
                                {!! __('services.consultation_desc') !!}
                            </p>
                            <ul class="space-y-3 mb-8">
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">{{ __('services.consultation_item1') }}</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">{{ __('services.consultation_item2') }}</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">{{ __('services.consultation_item3') }}</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-neutral-600">{{ __('services.consultation_item4') }}</span>
                                </li>
                            </ul>
                            <a href="#" class="btn-primary inline-flex items-center">
                                {{ __('services.book_consultation') }}
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

        <!-- Process Section - Modern Cards -->
        <section class="py-20 bg-gradient-to-br from-neutral-50 via-primary-50/30 to-neutral-50 relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute top-20 right-10 w-72 h-72 bg-primary-200/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 left-10 w-96 h-96 bg-green-200/20 rounded-full blur-3xl"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-neutral-900 mb-4">{{ __('services.our_process') }}</h2>
                    <p class="text-lg text-neutral-600 max-w-2xl mx-auto">
                        {{ __('services.process_description') }}
                    </p>
                </div>

                <!-- Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">

                    <!-- Step 1: Consultation -->
                    <div class="group relative">
                        <!-- Connection Line (desktop only) -->
                        <div
                            class="hidden lg:block absolute top-24 left-full w-full h-1 bg-gradient-to-r from-primary-300 to-green-300 transform translate-x-0 z-0">
                            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-3 h-3 bg-green-400 rounded-full"></div>
                        </div>

                        <div
                            class="relative bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border-2 border-transparent hover:border-primary-200">
                            <!-- Number Badge -->
                            <div
                                class="absolute -top-4 -right-4 w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-12 transition-transform duration-300">
                                <span class="text-white text-2xl font-bold">01</span>
                            </div>

                            <!-- Icon -->
                            <div class="mb-6 relative">
                                <div
                                    class="w-20 h-20  rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-md">
                                    <img src="{{ asset('consultant.png') }}" alt="La Maison P2A" class="h-16 w-16">
                                </div>
                                <!-- Decorative circle -->
                                <div class="absolute -top-2 -right-2 w-8 h-8 bg-primary-200/50 rounded-full -z-10"></div>
                            </div>

                            <!-- Content -->
                            <h3
                                class="text-2xl font-bold text-neutral-900 mb-3 group-hover:text-primary-600 transition-colors">
                                {{ __('services.step1') }}
                            </h3>
                            <p class="text-neutral-600 text-sm leading-relaxed">
                                {{ __('services.step1_desc') }}
                            </p>

                            <!-- Bottom accent -->
                            <div
                                class="absolute bottom-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary-500 to-primary-400 rounded-b-3xl transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300">
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Conception -->
                    <div class="group relative">
                        <!-- Connection Line (desktop only) -->
                        <div
                            class="hidden lg:block absolute top-24 left-full w-full h-1 bg-gradient-to-r from-green-300 to-blue-300 transform translate-x-0 z-0">
                            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-3 h-3 bg-blue-400 rounded-full"></div>
                        </div>

                        <div
                            class="relative bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border-2 border-transparent  hover:border-primary-200">
                            <!-- Number Badge -->
                           <div
                                class="absolute -top-4 -right-4 w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-12 transition-transform duration-300">
                                <span class="text-white text-2xl font-bold">02</span>
                            </div>

                            <!-- Icon -->
                            <div class="mb-6 relative">
                                <div
                                    class="w-20 h-20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-md">
                                    <img src="{{ asset('simulation.png') }}" alt="La Maison P2A" class="h-16 w-16">
                                </div>
                                <!-- Decorative circle -->
                                 <div class="absolute -top-2 -right-2 w-8 h-8 bg-primary-200/50 rounded-full -z-10"></div>
                            </div>

                            <!-- Content -->
                            <h3
                                class="text-2xl font-bold text-neutral-900 mb-3group-hover:text-primary-600 transition-colors">
                                {{ __('services.step2') }}
                            </h3>
                            <p class="text-neutral-600 text-sm leading-relaxed">
                                {{ __('services.step2_desc') }}
                            </p>

                            <!-- Bottom accent -->
                            <div
                                class="absolute bottom-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary-500 to-primary-400 rounded-b-3xl transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300">
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Réalisation -->
                    <div class="group relative">
                        <!-- Connection Line (desktop only) -->
                        <div
                            class="hidden lg:block absolute top-24 left-full w-full h-1 bg-gradient-to-r from-blue-300 to-purple-300 transform translate-x-0 z-0">
                            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-3 h-3 bg-purple-400 rounded-full">
                            </div>
                        </div>

                        <div
                            class="relative bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border-2 border-transparent  hover:border-primary-200">
                            <!-- Number Badge -->
                           <div
                                class="absolute -top-4 -right-4 w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-12 transition-transform duration-300">
                                <span class="text-white text-2xl font-bold">03</span>
                            </div>

                            <!-- Icon -->
                            <div class="mb-6 relative">
                                <div
                                    class="w-20 h-20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-md">
                                    <img src="{{ asset('reparateur.png') }}" alt="La Maison P2A" class="h-16 w-16">
                                </div>
                                <!-- Decorative circle -->
                                 <div class="absolute -top-2 -right-2 w-8 h-8 bg-primary-200/50 rounded-full -z-10"></div>
                            </div>

                            <!-- Content -->
                            <h3
                                class="text-2xl font-bold text-neutral-900 mb-3 group-hover:text-primary-600 transition-colors">
                                {{ __('services.step3') }}
                            </h3>
                            <p class="text-neutral-600 text-sm leading-relaxed">
                                {{ __('services.step3_desc') }}
                            </p>

                            <!-- Bottom accent -->
                           <div
                                class="absolute bottom-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary-500 to-primary-400 rounded-b-3xl transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300">
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Livraison -->
                    <div class="group relative">
                        <div
                            class="relative bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border-2 border-transparent hover:border-primary-200">
                            <!-- Number Badge -->
                          <div
                                class="absolute -top-4 -right-4 w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-12 transition-transform duration-300">
                                <span class="text-white text-2xl font-bold">04</span>
                            </div>

                            <!-- Icon -->
                            <div class="mb-6 relative">
                                <div
                                    class="w-20 h-20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-md">
                                    <img src="{{ asset('livraison-rapide.png') }}" alt="La Maison P2A" class="h-16 w-16">
                                </div>
                                <!-- Decorative circle -->
                                <div class="absolute -top-2 -right-2 w-8 h-8 bg-primary-200/50 rounded-full -z-10"></div>
                            </div>

                            <!-- Content -->
                            <h3
                                class="text-2xl font-bold text-neutral-900 mb-3 group-hover:text-primary-600 transition-colors">
                                {{ __('services.step4') }}
                            </h3>
                            <p class="text-neutral-600 text-sm leading-relaxed">
                                {{ __('services.step4_desc') }}
                            </p>

                            <!-- Bottom accent -->
                           <div
                                class="absolute bottom-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary-500 to-primary-400 rounded-b-3xl transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Progress Indicator -->
                {{--  <div class="mt-16 max-w-3xl mx-auto">
                    <div class="relative">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-neutral-600">Début</span>
                            <span class="text-sm font-medium text-neutral-600">Fin</span>
                        </div>
                        <div class="h-3 bg-neutral-200 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-primary-500 via-green-500 via-blue-500 to-purple-500 rounded-full"></div>
                        </div>
                        <div class="flex items-center justify-between mt-3 px-1">
                            <div class="w-4 h-4 bg-primary-500 rounded-full shadow-lg"></div>
                            <div class="w-4 h-4 bg-green-500 rounded-full shadow-lg"></div>
                            <div class="w-4 h-4 bg-blue-500 rounded-full shadow-lg"></div>
                            <div class="w-4 h-4 bg-purple-500 rounded-full shadow-lg"></div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-br from-primary-500 to-primary-700 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-10"></div>
            <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
                <h2 class="text-4xl font-bold mb-6">{{ __('services.cta_title') }}</h2>
                <p class="text-xl text-primary-100 mb-8">
                    {{ __('services.cta_description') }}
                </p>
                <a href="{{ route('contact') }}"
                    class="btn-primary bg-white text-primary-500 hover:bg-neutral-50 inline-flex items-center">
                    {{ __('services.book_appointment') }}
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
        </section>
    @endsection
