<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Admin | {{ config('app.name') }}</title>
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="antialiased" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen bg-neutral-100">
        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-neutral-200 transform transition-transform duration-300 lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-between h-16 px-6 border-b border-neutral-200">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center">
                            <span class="text-lg font-bold text-white">P2A</span>
                        </div>
                        <div>
                            <span class="text-lg font-bold text-neutral-900">La Maison P2A</span>
                            <span class="block text-xs text-neutral-400">Administration</span>
                        </div>
                    </a>
                    <button @click="sidebarOpen = false" class="lg:hidden text-neutral-400 hover:text-neutral-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                    <a href="{{ route('admin.dashboard') }}"
                        class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Tableau de bord</span>
                    </a>

                    <div class="pt-4 pb-2">
                        <h3 class="px-4 text-xs font-semibold text-neutral-400 uppercase tracking-wider">Catalogue</h3>
                    </div>

                    <a href="{{ route('admin.products.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span>Produits</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <span>Catégories</span>
                    </a>

                    <a href="{{ route('admin.brands.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                        <span>Marques</span>
                    </a>

                    <div class="pt-4 pb-2">
                        <h3 class="px-4 text-xs font-semibold text-neutral-400 uppercase tracking-wider">Ventes</h3>
                    </div>

                    <a href="{{ route('admin.orders.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span>Commandes</span>
                        @if ($pendingOrders = \App\Models\Order::where('status', 'pending')->count())
                            <span class="ml-auto badge badge-warning">{{ $pendingOrders }}</span>
                        @endif
                    </a>

                    <div class="pt-4 pb-2">
                        <h3 class="px-4 text-xs font-semibold text-neutral-400 uppercase tracking-wider">Blog</h3>
                    </div>

                    <div x-data="{ open: {{ request()->routeIs('admin.blog.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open"
                            class="w-full sidebar-link {{ request()->routeIs('admin.blog.*') ? 'active' : '' }} flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                                <span>Gestion du Blog</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-90': open }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <div x-show="open" x-transition class="ml-11 mt-2 space-y-1">
                            <a href="{{ route('admin.blog.dashboard') }}"
                                class="sidebar-link text-sm {{ request()->routeIs('admin.blog.dashboard') ? 'active' : '' }}">
                                Tableau de bord
                            </a>
                            <a href="{{ route('admin.blog.posts.index') }}"
                                class="sidebar-link text-sm {{ request()->routeIs('admin.blog.posts.*') ? 'active' : '' }}">
                                Articles
                            </a>
                            <a href="{{ route('admin.blog.categories.index') }}"
                                class="sidebar-link text-sm {{ request()->routeIs('admin.blog.categories.*') ? 'active' : '' }}">
                                Catégories
                            </a>
                            <a href="{{ route('admin.blog.comments.index') }}"
                                class="sidebar-link text-sm {{ request()->routeIs('admin.blog.comments.*') ? 'active' : '' }}">
                                Commentaires
                                @if ($pendingComments = \App\Models\BlogComment::where('status', 'pending')->count())
                                    <span class="ml-auto badge badge-warning text-xs">{{ $pendingComments }}</span>
                                @endif
                            </a>
                        </div>
                    </div>
                </nav>

                <!-- User Menu -->
                <div class="border-t border-neutral-200 p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center">
                                <span
                                    class="text-sm font-semibold text-primary-500">{{ substr(auth()->user()->name, 0, 2) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-neutral-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-neutral-400 truncate">Administrateur</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="p-2 text-neutral-400 hover:text-red-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-72">
            <!-- Top Bar -->
            <header class="h-16 bg-white border-b border-neutral-200 flex items-center justify-between px-6">
                <button @click="sidebarOpen = true" class="lg:hidden text-neutral-400 hover:text-neutral-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="flex-1 flex items-center justify-between ml-4 lg:ml-0">
                    <div>
                        <h1 class="text-xl font-bold text-neutral-900">@yield('page-title', 'Dashboard')</h1>
                    </div>

                    <div class="flex items-center space-x-4">
                        <a href="{{ route('home') }}" target="_blank"
                            class="text-sm text-neutral-400 hover:text-primary-500 flex items-center space-x-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            <span>Voir le site</span>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
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

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
        x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-neutral-900 bg-opacity-50 z-40 lg:hidden" style="display: none;">
    </div>

    @stack('scripts')
</body>

</html>
