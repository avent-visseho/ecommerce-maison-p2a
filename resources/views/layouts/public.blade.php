<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Accueil') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('description', 'La Maison P2A - Votre spécialiste en décoration d\'intérieur et d\'événements')">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="antialiased" x-data="{ mobileMenuOpen: false, cartOpen: false }">
    <!-- Navigation -->
    <nav class="bg-white border-b border-neutral-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-primary-500 rounded-xl flex items-center justify-center">
                            <span class="text-xl font-bold text-white">P2A</span>
                        </div>
                        <span class="text-xl font-bold text-neutral-900 hidden sm:block">La Maison P2A</span>
                    </a>

                    <!-- Desktop Menu -->
                    <div class="hidden lg:flex items-center space-x-1">
                        <a href="{{ route('home') }}"
                            class="px-4 py-2 text-sm font-medium text-neutral-900 hover:text-primary-500 hover:bg-primary-50 rounded-lg transition-all {{ request()->routeIs('home') ? 'text-primary-500 bg-primary-50' : '' }}">
                            Accueil
                        </a>
                        <a href="{{ route('shop.index') }}"
                            class="px-4 py-2 text-sm font-medium text-neutral-900 hover:text-primary-500 hover:bg-primary-50 rounded-lg transition-all {{ request()->routeIs('shop.*') ? 'text-primary-500 bg-primary-50' : '' }}">
                            Boutique
                        </a>
                        <a href="{{ route('services') }}"
                            class="px-4 py-2 text-sm font-medium text-neutral-900 hover:text-primary-500 hover:bg-primary-50 rounded-lg transition-all {{ request()->routeIs('services') ? 'text-primary-500 bg-primary-50' : '' }}">
                            Services
                        </a>
                        <a href="{{ route('blog.index') }}"
                            class="px-4 py-2 text-sm font-medium text-neutral-900 hover:text-primary-500 hover:bg-primary-50 rounded-lg transition-all {{ request()->routeIs('blog.*') ? 'text-primary-500 bg-primary-50' : '' }}">
                            Blog
                        </a>
                        <a href="{{ route('about') }}"
                            class="px-4 py-2 text-sm font-medium text-neutral-900 hover:text-primary-500 hover:bg-primary-50 rounded-lg transition-all {{ request()->routeIs('about') ? 'text-primary-500 bg-primary-50' : '' }}">
                            À Propos
                        </a>
                        <a href="{{ route('contact') }}"
                            class="px-4 py-2 text-sm font-medium text-neutral-900 hover:text-primary-500 hover:bg-primary-50 rounded-lg transition-all {{ request()->routeIs('contact') ? 'text-primary-500 bg-primary-50' : '' }}">
                            Contact
                        </a>
                    </div>
                </div>

                <!-- Right Menu -->
                <div class="flex items-center space-x-4">
                    <!-- Search -->
                    <button
                        class="hidden md:flex p-2 text-neutral-400 hover:text-neutral-900 hover:bg-neutral-50 rounded-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}"
                        class="relative p-2 text-neutral-400 hover:text-neutral-900 hover:bg-neutral-50 rounded-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        @if (app(\App\Services\CartService::class)->getCount() > 0)
                            <span
                                class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-primary-500 rounded-full">
                                {{ app(\App\Services\CartService::class)->getCount() }}
                            </span>
                        @endif
                    </a>

                    <!-- User Menu -->
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                class="flex items-center space-x-2 p-2 hover:bg-neutral-50 rounded-lg transition-all">
                                <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center">
                                    <span
                                        class="text-sm font-semibold text-primary-500">{{ substr(auth()->user()->name, 0, 2) }}</span>
                                </div>
                                <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-neutral-200 py-2"
                                style="display: none;">
                                @if (auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="flex items-center px-4 py-2 text-sm text-neutral-900 hover:bg-neutral-50">
                                        <svg class="w-5 h-5 mr-3 text-neutral-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                        Administration
                                    </a>
                                    <div class="border-t border-neutral-200 my-2"></div>
                                @endif
                                <a href="{{ route('client.dashboard') }}"
                                    class="flex items-center px-4 py-2 text-sm text-neutral-900 hover:bg-neutral-50">
                                    <svg class="w-5 h-5 mr-3 text-neutral-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Mon Compte
                                </a>
                                <a href="{{ route('client.orders.index') }}"
                                    class="flex items-center px-4 py-2 text-sm text-neutral-900 hover:bg-neutral-50">
                                    <svg class="w-5 h-5 mr-3 text-neutral-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    Mes Commandes
                                </a>
                                <div class="border-t border-neutral-200 my-2"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center w-full px-4 py-2 text-sm text-red-500 hover:bg-red-50">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="hidden md:flex px-4 py-2 text-sm font-medium text-neutral-900 hover:text-primary-500 hover:bg-primary-50 rounded-lg transition-all">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" class="hidden md:flex btn-primary text-sm">
                            S'inscrire
                        </a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="lg:hidden p-2 text-neutral-400 hover:text-neutral-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            class="lg:hidden border-t border-neutral-200 bg-white" style="display: none;">
            <div class="px-4 py-4 space-y-1">
                <a href="{{ route('home') }}"
                    class="block px-4 py-3 text-sm font-medium text-neutral-900 hover:bg-neutral-50 rounded-lg">Accueil</a>
                <a href="{{ route('shop.index') }}"
                    class="block px-4 py-3 text-sm font-medium text-neutral-900 hover:bg-neutral-50 rounded-lg">Boutique</a>
                <a href="{{ route('services') }}"
                    class="block px-4 py-3 text-sm font-medium text-neutral-900 hover:bg-neutral-50 rounded-lg">Services</a>
                <a href="{{ route('blog.index') }}"
                    class="block px-4 py-3 text-sm font-medium text-neutral-900 hover:bg-neutral-50 rounded-lg">Blog</a>
                <a href="{{ route('about') }}"
                    class="block px-4 py-3 text-sm font-medium text-neutral-900 hover:bg-neutral-50 rounded-lg">À
                    Propos</a>
                <a href="{{ route('contact') }}"
                    class="block px-4 py-3 text-sm font-medium text-neutral-900 hover:bg-neutral-50 rounded-lg">Contact</a>

                @guest
                    <div class="pt-4 border-t border-neutral-200">
                        <a href="{{ route('login') }}"
                            class="block px-4 py-3 text-sm font-medium text-neutral-900 hover:bg-neutral-50 rounded-lg">Connexion</a>
                        <a href="{{ route('register') }}"
                            class="block px-4 py-3 text-sm font-medium text-white bg-primary-500 rounded-lg text-center mt-2">S'inscrire</a>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if (session('success'))
            <div class="bg-green-50 border-b border-green-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border-b border-red-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-neutral-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 bg-primary-500 rounded-xl flex items-center justify-center">
                            <span class="text-xl font-bold text-white">P2A</span>
                        </div>
                        <span class="text-xl font-bold">La Maison P2A</span>
                    </div>
                    <p class="text-neutral-400 mb-4 max-w-md">
                        Votre partenaire privilégié pour la décoration d'intérieur et l'organisation d'événements.
                        Créons ensemble des espaces qui vous ressemblent.
                    </p>
                    <div class="flex items-center space-x-4">
                        <a href="https://www.facebook.com/profile.php?id=61582522333813"
                            class="w-10 h-10 bg-neutral-800 rounded-lg flex items-center justify-center hover:bg-primary-500 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/lamaisonp2a?igsh=ZHg1czEwZ3JoOWlm&utm_source=ig_contact_invite"
                            class="w-10 h-10 bg-neutral-800 rounded-lg flex items-center justify-center hover:bg-primary-500 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        {{-- <a href="#"
                            class="w-10 h-10 bg-neutral-800 rounded-lg flex items-center justify-center hover:bg-primary-500 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a> --}}
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liens Rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('shop.index') }}"
                                class="text-neutral-400 hover:text-white transition-colors">Boutique</a></li>
                        <li><a href="{{ route('services') }}"
                                class="text-neutral-400 hover:text-white transition-colors">Services</a></li>
                        <li><a href="{{ route('blog.index') }}"
                                class="text-neutral-400 hover:text-white transition-colors">Blog</a></li>
                        <li><a href="{{ route('about') }}"
                                class="text-neutral-400 hover:text-white transition-colors">À Propos</a></li>
                        <li><a href="{{ route('contact') }}"
                                class="text-neutral-400 hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-3 text-neutral-400">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Cotonou, Bénin</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>Lamaisonp2a@outlook.com</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>+229 01 90 01 68 79</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="pt-8 border-t border-neutral-800">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <p class="text-sm text-neutral-400">
                        &copy; {{ date('Y') }} La Maison P2A. Tous droits réservés.
                    </p>
                    <div class="flex items-center space-x-6 mt-4 md:mt-0">
                        <a href="#"
                            class="text-sm text-neutral-400 hover:text-white transition-colors">Politique de
                            confidentialité</a>
                        <a href="#"
                            class="text-sm text-neutral-400 hover:text-white transition-colors">Conditions
                            d'utilisation</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
