<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('errors.maintenance') }} - {{ config('app.name') }}</title>
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-neutral-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-lg w-full text-center">
            {{-- Illustration --}}
            <div class="mb-8">
                <div class="mx-auto w-32 h-32 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>

            {{-- Error Code --}}
            <h1 class="text-8xl font-bold text-yellow-500 mb-4">503</h1>

            {{-- Title --}}
            <h2 class="text-2xl font-bold text-neutral-900 mb-4">
                {{ __('errors.maintenance') }}
            </h2>

            {{-- Message --}}
            <p class="text-neutral-600 mb-8">
                {{ $message ?? __('errors.service_unavailable') }}
            </p>

            {{-- Logo --}}
            <div class="mt-12">
                <img src="{{ asset('logo.jpg') }}" alt="{{ config('app.name') }}" class="h-12 w-auto mx-auto opacity-50">
            </div>
        </div>
    </div>
</body>

</html>
