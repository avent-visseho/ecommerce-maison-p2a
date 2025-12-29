<x-guest-layout>
    <div class="bg-white rounded-2xl shadow-soft p-8 border border-neutral-200">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-neutral-900 mb-2">{{ __('auth.login.title') }}</h2>
            <p class="text-neutral-400">{{ __('auth.login.subtitle') }}</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

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

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="label">{{ __('auth.login.email') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="input-field pl-12" placeholder="{{ __('auth.login.email_placeholder') }}">
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="label">{{ __('auth.login.password') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="password" type="password" name="password" required class="input-field pl-12"
                        placeholder="{{ __('auth.login.password_placeholder') }}">
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember"
                        class="rounded border-neutral-300 text-primary-500 focus:ring-primary-500">
                    <span class="ml-2 text-sm text-neutral-400">{{ __('auth.login.remember_me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-sm text-primary-500 hover:text-primary-600 font-medium">
                        {{ __('auth.login.forgot_password') }}
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full btn-primary flex items-center justify-center space-x-2">
                <span>{{ __('auth.login.login_button') }}</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </button>
        </form>

        <!-- Register Link -->
        <div class="mt-8 pt-6 border-t border-neutral-200 text-center">
            <p class="text-sm text-neutral-400">
                {{ __('auth.login.no_account') }}
                <a href="{{ route('register') }}" class="text-primary-500 hover:text-primary-600 font-semibold ml-1">
                    {{ __('auth.login.create_account') }}
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
                <span>{{ __('auth.login.back_to_home') }}</span>
            </a>
        </div>
    </div>
</x-guest-layout>
