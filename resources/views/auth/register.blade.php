<x-guest-layout>
    <div class="bg-white rounded-2xl shadow-soft p-8 border border-neutral-200">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-neutral-900 mb-2">{{ __('auth.register.title') }}</h2>
            <p class="text-neutral-400">{{ __('auth.register.subtitle') }}</p>
        </div>

        <!-- Errors -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="label">{{ __('auth.register.name') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="input-field pl-12" placeholder="{{ __('auth.register.name_placeholder') }}">
                </div>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="label">{{ __('auth.register.email') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="input-field pl-12" placeholder="{{ __('auth.register.email_placeholder') }}">
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="label">{{ __('auth.register.password') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="password" type="password" name="password" required class="input-field pl-12"
                        placeholder="{{ __('auth.register.password_placeholder') }}">
                </div>
                <p class="mt-1 text-xs text-neutral-400">{{ __('auth.register.password_min') }}</p>
            </div>

            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="label">{{ __('auth.register.password_confirmation') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="input-field pl-12" placeholder="{{ __('auth.register.password_placeholder') }}">
                </div>
            </div>

            <!-- Terms -->
            <div class="flex items-start">
                <input type="checkbox" required
                    class="mt-1 rounded border-neutral-300 text-primary-500 focus:ring-primary-500">
                <span class="ml-2 text-sm text-neutral-400">
                    {{ __('auth.register.terms_prefix') }}
                    <a href="#" class="text-primary-500 hover:text-primary-600 font-medium">{{ __('auth.register.terms_link') }}</a>
                    {{ __('auth.register.terms_and') }}
                    <a href="#" class="text-primary-500 hover:text-primary-600 font-medium">{{ __('auth.register.privacy_link') }}</a>
                </span>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full btn-primary flex items-center justify-center space-x-2">
                <span>{{ __('auth.register.register_button') }}</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </button>
        </form>

        <!-- Login Link -->
        <div class="mt-8 pt-6 border-t border-neutral-200 text-center">
            <p class="text-sm text-neutral-400">
                {{ __('auth.register.have_account') }}
                <a href="{{ route('login') }}" class="text-primary-500 hover:text-primary-600 font-semibold ml-1">
                    {{ __('auth.register.login_link') }}
                </a>
            </p>
        </div>

        <!-- Back to Home -->
        <div class="mt-6 text-center">
            <a href="{{ route('home') }}"
                class="text-sm text-neutral-400 hover:text-neutral-900 inline-flex items-center space-x-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>{{ __('auth.register.back_to_home') }}</span>
            </a>
        </div>
    </div>
</x-guest-layout>
