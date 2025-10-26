<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mon Compte') - {{ config('app.name') }}</title>
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="antialiased bg-neutral-50">
    <!-- Top Navigation -->
    <nav class="bg-white border-b border-neutral-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center">
                            <span class="text-lg font-bold text-white">P2A</span>
                        </div>
                        <span class="text-lg font-bold text-neutral-900 hidden sm:block">La Maison P2A</span>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-sm text-neutral-400 hover:text-neutral-900">
                        Retour au site
                    </a>
                    <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center">
                        <span
                            class="text-sm font-semibold text-primary-500">{{ substr(auth()->user()->name, 0, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="lg:grid lg:grid-cols-4 lg:gap-8">
            <!-- Sidebar Navigation -->
            <aside class="mb-8 lg:mb-0">
                <div class="card sticky top-8">
                    <div class="card-body">
                        <!-- User Info -->
                        <div class="flex items-center space-x-3 pb-6 border-b border-neutral-200 mb-6">
                            <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center">
                                <span
                                    class="text-lg font-semibold text-primary-500">{{ substr(auth()->user()->name, 0, 2) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-neutral-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-neutral-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                        </div>

                        <!-- Navigation Links -->
                        <nav class="space-y-1">
                            <a href="{{ route('client.dashboard') }}"
                                class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('client.dashboard') ? 'bg-primary-50 text-primary-500' : 'text-neutral-900 hover:bg-neutral-50' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span class="font-medium">Tableau de bord</span>
                            </a>

                            <a href="{{ route('client.orders.index') }}"
                                class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('client.orders.*') ? 'bg-primary-50 text-primary-500' : 'text-neutral-900 hover:bg-neutral-50' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <span class="font-medium">Mes Commandes</span>
                            </a>

                            <a href="{{ route('client.profile.edit') }}"
                                class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('client.profile.*') ? 'bg-primary-50 text-primary-500' : 'text-neutral-900 hover:bg-neutral-50' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="font-medium">Mon Profil</span>
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center px-4 py-3 rounded-lg text-red-500 hover:bg-red-50 transition-colors">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span class="font-medium">Déconnexion</span>
                                </button>
                            </form>
                        </nav>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="lg:col-span-3">
                @if (session('success'))
                    <div
                        class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center animate-fade-in">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center animate-fade-in">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
