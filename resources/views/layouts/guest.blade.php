<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'La Maison P2A') }} - @yield('title', 'Authentification')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div class="min-h-screen flex">
        <!-- Left Side - Branding -->
        <div
            class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-10"></div>
            <div class="relative z-10 flex flex-col justify-between p-12 text-white w-full">
                <div>
                    <a href="{{ route('home') }}" class="inline-flex items-center space-x-3">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center">
                            <span class="text-2xl font-bold text-primary-500">P2A</span>
                        </div>
                        <span class="text-2xl font-bold">La Maison P2A</span>
                    </a>
                </div>

                <div class="space-y-6">
                    <h1 class="text-5xl font-bold leading-tight">
                        Créez votre espace<br />
                        <span class="text-accent-light">de rêve</span>
                    </h1>
                    <p class="text-xl text-primary-100 max-w-md">
                        Découvrez notre collection exclusive de décoration d'intérieur et transformez votre maison en un
                        lieu unique.
                    </p>
                </div>

                <div class="flex items-center space-x-8">
                    <div class="flex -space-x-2">
                        <div class="w-10 h-10 rounded-full bg-white/20 border-2 border-white"></div>
                        <div class="w-10 h-10 rounded-full bg-white/20 border-2 border-white"></div>
                        <div class="w-10 h-10 rounded-full bg-white/20 border-2 border-white"></div>
                    </div>
                    <div>
                        <p class="text-sm text-primary-100">Rejoignez plus de</p>
                        <p class="font-semibold text-lg">500+ clients satisfaits</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-neutral-50">
            <div class="w-full max-w-md animate-fade-in">
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-8 text-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center space-x-3">
                        <div class="w-12 h-12 bg-primary-500 rounded-xl flex items-center justify-center">
                            <span class="text-xl font-bold text-white">P2A</span>
                        </div>
                        <span class="text-2xl font-bold text-neutral-900">La Maison P2A</span>
                    </a>
                </div>

                {{ $slot }}

                <!-- Footer -->
                <div class="mt-8 text-center text-sm text-neutral-400">
                    <p>&copy; {{ date('Y') }} La Maison P2A. Tous droits réservés.</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
