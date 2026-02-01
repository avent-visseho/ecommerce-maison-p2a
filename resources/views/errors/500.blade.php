<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('errors.error_occurred') }} - {{ config('app.name') }}</title>
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-neutral-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-lg w-full text-center">
            {{-- Illustration --}}
            <div class="mb-8">
                <div class="mx-auto w-32 h-32 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>

            {{-- Error Code --}}
            <h1 class="text-8xl font-bold text-red-500 mb-4">500</h1>

            {{-- Title --}}
            <h2 class="text-2xl font-bold text-neutral-900 mb-4">
                {{ __('errors.error_occurred') }}
            </h2>

            {{-- Message --}}
            <p class="text-neutral-600 mb-8">
                {{ __('errors.server_error') }}
            </p>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}"
                    class="px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-xl transition-colors">
                    {{ __('errors.go_home') }}
                </a>
                <button onclick="location.reload()"
                    class="px-6 py-3 bg-neutral-100 hover:bg-neutral-200 text-neutral-700 font-medium rounded-xl transition-colors">
                    {{ __('errors.try_again') }}
                </button>
            </div>

            {{-- Logo --}}
            <div class="mt-12">
                <a href="{{ route('home') }}" class="inline-block">
                    <img src="{{ asset('logo.jpg') }}" alt="{{ config('app.name') }}" class="h-12 w-auto mx-auto opacity-50">
                </a>
            </div>
        </div>
    </div>
</body>

</html>
