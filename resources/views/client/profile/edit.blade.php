@extends('layouts.client')

@section('title', 'Mon Profil')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="card">
            <div class="card-body">
                <h1 class="text-2xl font-bold text-neutral-900 mb-2">Mon Profil</h1>
                <p class="text-neutral-400">Gérez vos informations personnelles</p>
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
                    <p class="text-sm text-neutral-400 mb-4">Membre depuis {{ auth()->user()->created_at->format('F Y') }}
                    </p>
                    <button class="btn-secondary text-sm w-full">
                        Changer la photo
                    </button>
                </div>
            </div>

            <!-- Profile Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Information -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-neutral-900">Informations Personnelles</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('client.profile.update') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="name" class="label">Nom complet <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                    required class="input-field @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="label">Email <span class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                    required class="input-field @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="label">Téléphone</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                    placeholder="+229 01 90 01 68 79"
                                    class="input-field @error('phone') border-red-500 @enderror">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="address" class="label">Adresse</label>
                                <textarea id="address" name="address" rows="3" placeholder="Votre adresse complète"
                                    class="input-field @error('address') border-red-500 @enderror">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="city" class="label">Ville</label>
                                    <input type="text" id="city" name="city"
                                        value="{{ old('city', $user->city) }}" placeholder="Cotonou"
                                        class="input-field @error('city') border-red-500 @enderror">
                                    @error('city')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="postal_code" class="label">Code postal</label>
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
                                    Annuler
                                </button>
                                <button type="submit" class="btn-primary">
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-neutral-900">Changer le Mot de Passe</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('client.profile.password') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="current_password" class="label">Mot de passe actuel <span
                                        class="text-red-500">*</span></label>
                                <input type="password" id="current_password" name="current_password" required
                                    class="input-field @error('current_password') border-red-500 @enderror">
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="label">Nouveau mot de passe <span
                                        class="text-red-500">*</span></label>
                                <input type="password" id="password" name="password" required
                                    class="input-field @error('password') border-red-500 @enderror">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-neutral-400">Minimum 8 caractères</p>
                            </div>

                            <div>
                                <label for="password_confirmation" class="label">Confirmer le mot de passe <span
                                        class="text-red-500">*</span></label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="input-field">
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="btn-primary">
                                    Mettre à jour le mot de passe
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Account Actions -->
                <div class="card border-red-200">
                    <div class="card-header bg-red-50">
                        <h3 class="text-lg font-semibold text-red-900">Zone Dangereuse</h3>
                    </div>
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-neutral-900 mb-1">Supprimer mon compte</h4>
                                <p class="text-sm text-neutral-600">Cette action est irréversible. Toutes vos données
                                    seront supprimées.</p>
                            </div>
                            <button
                                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors font-medium">
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
