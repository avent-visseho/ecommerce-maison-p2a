@extends('layouts.public')

@section('title', $rentalItem->name)
@section('description', $rentalItem->description)

@section('content')
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex items-center space-x-2 text-sm text-neutral-400 mb-8">
                <a href="{{ route('home') }}" class="hover:text-neutral-900">Accueil</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('rentals.index') }}" class="hover:text-neutral-900">Locations</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-neutral-900 font-medium">{{ $rentalItem->name }}</span>
            </nav>

            <div class="lg:grid lg:grid-cols-2 lg:gap-12">
                <!-- Images -->
                <div class="mb-8 lg:mb-0">
                    <div class="sticky top-24">
                        @if ($rentalItem->main_image)
                            <div class="relative h-96 lg:h-[500px] rounded-2xl overflow-hidden bg-neutral-100 mb-4">
                                <img src="{{ asset('storage/' . $rentalItem->main_image) }}" alt="{{ $rentalItem->name }}"
                                    class="w-full h-full object-cover">
                            </div>
                        @endif

                        @if ($rentalItem->images && count($rentalItem->images) > 0)
                            <div class="grid grid-cols-4 gap-4">
                                @foreach ($rentalItem->images as $image)
                                    <div class="relative h-24 rounded-lg overflow-hidden bg-neutral-100 cursor-pointer hover:opacity-75 transition-opacity">
                                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $rentalItem->name }}"
                                            class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Details -->
                <div>
                    <div class="mb-6">
                        <p class="text-sm text-neutral-400 mb-2">{{ $rentalItem->rentalCategory->name }}</p>
                        <h1 class="text-4xl font-bold text-neutral-900 mb-4">{{ $rentalItem->name }}</h1>

                        @if ($rentalItem->description)
                            <div class="trix-content text-neutral-600 mb-6">{!! $rentalItem->description !!}</div>
                        @endif
                    </div>

                    <!-- Pricing -->
                    <div class="card mb-6">
                        <div class="card-body">
                            <h3 class="text-lg font-semibold text-neutral-900 mb-4">Tarification</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-neutral-600">Tarif journalier</span>
                                    <span class="text-2xl font-bold text-primary-500">{{ number_format($rentalItem->daily_rate, 0, ',', ' ') }} €</span>
                                </div>
                                @if ($rentalItem->weekly_rate)
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-neutral-600">Tarif hebdomadaire</span>
                                        <span class="font-semibold text-neutral-900">{{ number_format($rentalItem->weekly_rate, 0, ',', ' ') }} €</span>
                                    </div>
                                @endif
                                @if ($rentalItem->monthly_rate)
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-neutral-600">Tarif mensuel</span>
                                        <span class="font-semibold text-neutral-900">{{ number_format($rentalItem->monthly_rate, 0, ',', ' ') }} €</span>
                                    </div>
                                @endif
                                <div class="flex justify-between items-center pt-3 border-t border-neutral-200">
                                    <span class="text-neutral-600">Caution</span>
                                    <span class="font-semibold text-neutral-900">{{ number_format($rentalItem->deposit_amount, 0, ',', ' ') }} €</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Form -->
                    <div class="card mb-6" x-data="rentalBooking()">
                        <div class="card-body">
                            <h3 class="text-lg font-semibold text-neutral-900 mb-4">Réserver cet objet</h3>

                            <div class="space-y-4">
                                <!-- Dates -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="label">Date de début</label>
                                        <input type="date" x-model="startDate" :min="minDate" @change="checkAvailability"
                                            class="input-field">
                                    </div>
                                    <div>
                                        <label class="label">Date de fin</label>
                                        <input type="date" x-model="endDate" :min="startDate" @change="checkAvailability"
                                            class="input-field">
                                    </div>
                                </div>

                                <!-- Quantity -->
                                <div>
                                    <label class="label">Quantité</label>
                                    <input type="number" x-model="quantity" min="1" max="{{ $rentalItem->quantity }}" @change="checkAvailability"
                                        class="input-field">
                                    <p class="text-xs text-neutral-400 mt-1">{{ $rentalItem->quantity }} disponible(s)</p>
                                </div>

                                <!-- Loading State -->
                                <div x-show="loading" class="text-center py-4">
                                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-500"></div>
                                    <p class="text-sm text-neutral-400 mt-2">Vérification de la disponibilité...</p>
                                </div>

                                <!-- Error Message -->
                                <div x-show="error && !loading" class="bg-red-50 border border-red-200 rounded-lg p-4">
                                    <p class="text-sm text-red-600" x-text="errorMessage"></p>
                                </div>

                                <!-- Pricing Result -->
                                <div x-show="showPricing && !loading && !error" class="bg-primary-50 border border-primary-200 rounded-lg p-4">
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-neutral-600">Durée</span>
                                            <span class="font-semibold" x-text="durationDays + ' jour(s)'"></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-neutral-600">Tarif appliqué</span>
                                            <span class="font-semibold" x-text="getRateTypeLabel()"></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-neutral-600">Location</span>
                                            <span class="font-semibold" x-text="formatPrice(totalRental)"></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-neutral-600">Caution</span>
                                            <span class="font-semibold" x-text="formatPrice(totalDeposit)"></span>
                                        </div>
                                        <div class="flex justify-between pt-2 border-t border-primary-300">
                                            <span class="font-bold text-neutral-900">Total</span>
                                            <span class="text-xl font-bold text-primary-500" x-text="formatPrice(grandTotal)"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add to Cart Button -->
                                <button @click="addToCart" :disabled="!canAddToCart()"
                                    :class="canAddToCart() ? 'btn-primary' : 'btn-secondary opacity-50 cursor-not-allowed'"
                                    class="w-full">
                                    <span x-show="!loading">Ajouter au panier</span>
                                    <span x-show="loading">Chargement...</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    @if ($rentalItem->long_description)
                        <div class="card">
                            <div class="card-body">
                                <h3 class="text-lg font-semibold text-neutral-900 mb-4">Description détaillée</h3>
                                <div class="trix-content text-neutral-600">{!! $rentalItem->long_description !!}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Similar Items -->
            @if ($similarItems->count() > 0)
                <div class="mt-16">
                    <h2 class="text-2xl font-bold text-neutral-900 mb-8">Objets similaires</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($similarItems as $item)
                            <a href="{{ route('rentals.show', $item->slug) }}"
                                class="group card hover:shadow-lg transition-all duration-300">
                                <div class="relative h-48 overflow-hidden bg-neutral-100">
                                    @if ($item->main_image)
                                        <img src="{{ asset('storage/' . $item->main_image) }}" alt="{{ $item->name }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    @endif
                                </div>
                                <div class="card-body">
                                    <h3 class="font-semibold text-neutral-900 mb-2 group-hover:text-primary-500 transition-colors">
                                        {{ $item->name }}
                                    </h3>
                                    <p class="text-xl font-bold text-primary-500">{{ number_format($item->daily_rate, 0, ',', ' ') }} €</p>
                                    <p class="text-xs text-neutral-400">par jour</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    @push('scripts')
    <script>
        function rentalBooking() {
            return {
                startDate: '',
                endDate: '',
                quantity: 1,
                loading: false,
                error: false,
                errorMessage: '',
                showPricing: false,
                durationDays: 0,
                rateType: '',
                totalRental: 0,
                totalDeposit: 0,
                grandTotal: 0,
                minDate: new Date().toISOString().split('T')[0],

                async checkAvailability() {
                    if (!this.startDate || !this.endDate || !this.quantity) {
                        this.showPricing = false;
                        return;
                    }

                    this.loading = true;
                    this.error = false;
                    this.showPricing = false;

                    try {
                        const response = await fetch('{{ route('rentals.checkAvailability', $rentalItem->id) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                start_date: this.startDate,
                                end_date: this.endDate,
                                quantity: this.quantity
                            })
                        });

                        const data = await response.json();

                        if (!data.available) {
                            this.error = true;
                            this.errorMessage = data.message;
                        } else {
                            this.durationDays = data.duration_days;
                            this.rateType = data.rate_type;
                            this.totalRental = data.total;
                            this.totalDeposit = data.total_deposit;
                            this.grandTotal = data.grand_total;
                            this.showPricing = true;
                        }
                    } catch (error) {
                        this.error = true;
                        this.errorMessage = 'Une erreur est survenue. Veuillez réessayer.';
                    } finally {
                        this.loading = false;
                    }
                },

                canAddToCart() {
                    return this.showPricing && !this.loading && !this.error;
                },

                async addToCart() {
                    if (!this.canAddToCart()) return;

                    this.loading = true;

                    try {
                        const response = await fetch('{{ route('cart.add.rental', $rentalItem->id) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                start_date: this.startDate,
                                end_date: this.endDate,
                                quantity: this.quantity
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            // Success - redirect to cart
                            window.location.href = '{{ route('cart.index') }}';
                        } else {
                            this.error = true;
                            this.errorMessage = data.message;
                        }
                    } catch (error) {
                        this.error = true;
                        this.errorMessage = 'Une erreur est survenue. Veuillez réessayer.';
                    } finally {
                        this.loading = false;
                    }
                },

                getRateTypeLabel() {
                    const labels = {
                        'daily': 'Journalier',
                        'weekly': 'Hebdomadaire',
                        'monthly': 'Mensuel'
                    };
                    return labels[this.rateType] || '';
                },

                formatPrice(amount) {
                    return new Intl.NumberFormat('fr-FR', {
                        style: 'currency',
                        currency: 'EUR',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(amount);
                }
            }
        }
    </script>
    @endpush
@endsection
