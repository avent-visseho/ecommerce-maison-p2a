@extends('layouts.client')

@section('title', __('client.profile.title'))

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="card">
            <div class="card-body">
                <h1 class="text-2xl font-bold text-neutral-900 mb-2">{{ __('client.profile.title') }}</h1>
                <p class="text-neutral-400">{{ __('client.profile.manage_description') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Picture -->
            <div class="card">
                <div class="card-body text-center">
                    <div class="w-32 h-32 rounded-full bg-primary-100 flex items-center justify-center mx-auto mb-4">
                        <span class="text-5xl font-bold text-primary-500">{{ substr(auth()->user()->name, 0, 2) }}</span>
                    </div>
                    <h3 class="font-semibold text-neutral-900 mb-1">{{ auth()->user()->name }}</h3>
                    <p class="text-sm text-neutral-400 mb-4">{{ __('client.profile.member_since') }} {{ auth()->user()->created_at->format('F Y') }}
                    </p>
                    <button class="btn-secondary text-sm w-full">
                        {{ __('client.profile.change_photo') }}
                    </button>
                </div>
            </div>

            <!-- Profile Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Information -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-neutral-900">{{ __('client.profile.personal_info') }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('client.profile.update') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="name" class="label">{{ __('client.profile.full_name') }} <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                    required class="input-field @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="label">{{ __('client.profile.email') }} <span class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                    required class="input-field @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="label">{{ __('client.profile.phone') }}</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                    placeholder="+229 01 90 01 68 79"
                                    class="input-field @error('phone') border-red-500 @enderror">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="address" class="label">{{ __('client.profile.address') }}</label>
                                <textarea id="address" name="address" rows="3" placeholder="{{ __('client.profile.address_placeholder') }}"
                                    class="input-field @error('address') border-red-500 @enderror">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="city" class="label">{{ __('client.profile.city') }}</label>
                                    <input type="text" id="city" name="city"
                                        value="{{ old('city', $user->city) }}" placeholder="Cotonou"
                                        class="input-field @error('city') border-red-500 @enderror">
                                    @error('city')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="postal_code" class="label">{{ __('client.profile.postal_code') }}</label>
                                    <input type="text" id="postal_code" name="postal_code"
                                        value="{{ old('postal_code', $user->postal_code) }}"
                                        class="input-field @error('postal_code') border-red-500 @enderror">
                                    @error('postal_code')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex justify-end space-x-4 pt-4">
                                <button type="reset" class="btn-secondary">
                                    {{ __('client.profile.cancel') }}
                                </button>
                                <button type="submit" class="btn-primary">
                                    {{ __('client.profile.save_changes') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-neutral-900">{{ __('client.profile.change_password') }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('client.profile.password') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="current_password" class="label">{{ __('client.profile.current_password') }} <span
                                        class="text-red-500">*</span></label>
                                <input type="password" id="current_password" name="current_password" required
                                    class="input-field @error('current_password') border-red-500 @enderror">
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="label">{{ __('client.profile.new_password') }} <span
                                        class="text-red-500">*</span></label>
                                <input type="password" id="password" name="password" required
                                    class="input-field @error('password') border-red-500 @enderror">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-neutral-400">{{ __('client.profile.password_min') }}</p>
                            </div>

                            <div>
                                <label for="password_confirmation" class="label">{{ __('client.profile.confirm_password') }} <span
                                        class="text-red-500">*</span></label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="input-field">
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="btn-primary">
                                    {{ __('client.profile.update_password') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Account Actions -->
                <div class="card border-red-200">
                    <div class="card-header bg-red-50">
                        <h3 class="text-lg font-semibold text-red-900">{{ __('client.profile.danger_zone') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-neutral-900 mb-1">{{ __('client.profile.delete_account') }}</h4>
                                <p class="text-sm text-neutral-600">{{ __('client.profile.delete_warning') }}</p>
                            </div>
                            <button
                                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors font-medium">
                                {{ __('client.profile.delete') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
