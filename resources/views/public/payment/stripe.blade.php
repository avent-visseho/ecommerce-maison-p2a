@extends('layouts.public')

@section('title', __('payment.stripe_title'))
@section('description', __('payment.stripe_meta'))

@push('styles')
<style>
    #payment-element {
        min-height: 200px;
    }
    .stripe-loading {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 200px;
    }
    .stripe-spinner {
        width: 40px;
        height: 40px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #6366f1;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    #payment-message {
        color: #df1b41;
        font-size: 14px;
        margin-top: 12px;
        text-align: center;
    }
    #submit-button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary-50 to-neutral-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-neutral-900 mb-2">{{ __('payment.finalize_payment') }}</h1>
            <p class="text-neutral-600">{{ __('payment.order_number', ['number' => $order->order_number]) }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Payment Form -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-neutral-200">
                    <!-- Stripe Badge -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-7 h-7 text-indigo-600" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.409 0-.831.683-1.305 1.901-1.305 2.227 0 4.515.858 6.09 1.631l.89-5.494C18.252.975 15.697 0 12.165 0 9.667 0 7.589.654 6.104 1.872 4.56 3.147 3.757 4.992 3.757 7.218c0 4.039 2.467 5.76 6.476 7.219 2.585.92 3.445 1.574 3.445 2.583 0 .98-.84 1.545-2.354 1.545-1.875 0-4.965-.921-6.99-2.109l-.9 5.555C5.175 22.99 8.385 24 11.714 24c2.641 0 4.843-.624 6.328-1.813 1.664-1.305 2.525-3.236 2.525-5.732 0-4.128-2.524-5.851-6.591-7.305z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-neutral-900">{{ __('payment.stripe_payment') }}</h2>
                                <p class="text-sm text-neutral-500">{{ __('payment.secure_stripe') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <img src="https://cdn.jsdelivr.net/gh/nicehorse06/payment-logo@master/icons/visa.svg" alt="Visa" class="h-8">
                            <img src="https://cdn.jsdelivr.net/gh/nicehorse06/payment-logo@master/icons/mastercard.svg" alt="Mastercard" class="h-8">
                            <img src="https://cdn.jsdelivr.net/gh/nicehorse06/payment-logo@master/icons/amex.svg" alt="Amex" class="h-8">
                        </div>
                    </div>

                    <!-- Stripe Payment Element -->
                    <form id="payment-form">
                        <div id="payment-element" class="mb-6">
                            <div class="stripe-loading">
                                <div class="stripe-spinner"></div>
                            </div>
                        </div>

                        <div id="payment-message" class="hidden"></div>

                        <button
                            id="submit-button"
                            type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 flex items-center justify-center space-x-2 disabled:opacity-50"
                            disabled
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span id="button-text">{{ __('payment.pay_amount', ['amount' => number_format($order->total, 2, ',', ' ')]) }}</span>
                            <span id="spinner" class="hidden">
                                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </button>
                    </form>

                    <!-- Security Badges -->
                    <div class="mt-6 pt-6 border-t border-neutral-200">
                        <div class="flex items-center justify-center space-x-6 text-sm text-neutral-500">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                                {{ __('payment.ssl_encrypted') }}
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                {{ __('payment.pci_compliant') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Alternative Payment (FedaPay) - Désactivé temporairement
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-neutral-200">
                    <p class="text-sm text-neutral-600 mb-4">{{ __('payment.prefer_mobile_money') }}</p>
                    <a href="{{ route('payment.show', $order) }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('payment.pay_with_fedapay') }}
                    </a>
                </div>
                --}}

                <!-- Shipping Information -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-neutral-200">
                    <h3 class="text-lg font-bold text-neutral-900 mb-4">{{ __('payment.shipping_info') }}</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-neutral-500">{{ __('payment.full_name') }}</p>
                            <p class="font-medium text-neutral-900">{{ $order->shipping_name }}</p>
                        </div>
                        <div>
                            <p class="text-neutral-500">{{ __('payment.email') }}</p>
                            <p class="font-medium text-neutral-900">{{ $order->shipping_email }}</p>
                        </div>
                        <div>
                            <p class="text-neutral-500">{{ __('payment.phone') }}</p>
                            <p class="font-medium text-neutral-900">{{ $order->shipping_phone }}</p>
                        </div>
                        <div>
                            <p class="text-neutral-500">{{ __('payment.shipping_address') }}</p>
                            <p class="font-medium text-neutral-900">{{ $order->shipping_address }}, {{ $order->shipping_city }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-neutral-200 sticky top-6">
                    <h3 class="text-lg font-bold text-neutral-900 mb-4">{{ __('payment.summary') }}</h3>

                    <!-- Products -->
                    <div class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                        @foreach ($order->items as $item)
                            <div class="flex items-center space-x-3">
                                @if ($item->product && $item->product->main_image)
                                    <img src="{{ asset('storage/' . $item->product->main_image) }}"
                                        alt="{{ $item->product_name }}" class="w-12 h-12 object-cover rounded-lg">
                                @else
                                    <div class="w-12 h-12 bg-neutral-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-neutral-900 truncate">{{ $item->product_name }}</p>
                                    <p class="text-xs text-neutral-500">{{ __('payment.quantity_short') }}: {{ $item->quantity }}</p>
                                </div>
                                <p class="text-sm font-semibold text-neutral-900">{{ number_format($item->subtotal, 2, ',', ' ') }} &euro;</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-neutral-200 pt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-neutral-600">{{ __('payment.subtotal') }}</span>
                            <span class="font-medium">{{ number_format($order->subtotal, 2, ',', ' ') }} &euro;</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-neutral-600">{{ __('payment.shipping') }}</span>
                            <span class="font-medium">{{ number_format($order->shipping, 2, ',', ' ') }} &euro;</span>
                        </div>
                        @if ($order->tax > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-neutral-600">{{ __('payment.taxes') }}</span>
                                <span class="font-medium">{{ number_format($order->tax, 2, ',', ' ') }} &euro;</span>
                            </div>
                        @endif
                        <div class="border-t border-neutral-200 pt-2 mt-2">
                            <div class="flex justify-between">
                                <span class="text-lg font-bold text-neutral-900">{{ __('payment.total') }}</span>
                                <span class="text-lg font-bold text-indigo-600">{{ number_format($order->total, 2, ',', ' ') }} &euro;</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Link -->
        <div class="text-center mt-8">
            <a href="{{ route('client.orders.show', $order) }}" class="text-primary-500 hover:text-primary-600 font-medium">
                {{ __('payment.back_to_order') }}
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', async function() {
    const publishableKey = '{{ $publishableKey }}';
    const clientSecret = '{{ $clientSecret }}';
    const returnUrl = '{{ $returnUrl }}';
    const messageDiv = document.getElementById('payment-message');
    const loadingDiv = document.querySelector('.stripe-loading');

    // Fonction pour afficher les erreurs
    function showError(message) {
        if (loadingDiv) loadingDiv.style.display = 'none';
        messageDiv.textContent = message;
        messageDiv.classList.remove('hidden');
        console.error('Stripe Error:', message);
    }

    // Vérifier que Stripe.js est chargé
    if (typeof Stripe === 'undefined') {
        showError('{{ __("payment.stripe_init_error") }}');
        return;
    }

    // Vérifier que les clés sont présentes
    if (!publishableKey || publishableKey === '') {
        showError('{{ __("payment.stripe_key_missing") }}');
        return;
    }

    if (!clientSecret || clientSecret === '') {
        showError('{{ __("payment.client_secret_missing") }}');
        return;
    }

    let stripe;
    try {
        stripe = Stripe(publishableKey);
    } catch (e) {
        showError('{{ __("payment.stripe_init_error") }}: ' + e.message);
        return;
    }

    const appearance = {
        theme: 'stripe',
        variables: {
            colorPrimary: '#4f46e5',
            colorBackground: '#ffffff',
            colorText: '#1f2937',
            colorDanger: '#df1b41',
            fontFamily: 'Inter, system-ui, sans-serif',
            spacingUnit: '4px',
            borderRadius: '8px',
        },
        rules: {
            '.Input': {
                border: '1px solid #e5e7eb',
                boxShadow: '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
            },
            '.Input:focus': {
                border: '1px solid #4f46e5',
                boxShadow: '0 0 0 3px rgba(79, 70, 229, 0.1)',
            },
            '.Label': {
                fontWeight: '500',
            },
        }
    };

    let elements;
    try {
        elements = stripe.elements({
            clientSecret,
            appearance,
            locale: '{{ app()->getLocale() }}'
        });
    } catch (e) {
        showError('{{ __("payment.elements_init_error") }}: ' + e.message);
        return;
    }

    let paymentElement;
    try {
        paymentElement = elements.create('payment', {
            layout: 'tabs',
            defaultValues: {
                billingDetails: {
                    name: '{{ addslashes($order->shipping_name) }}',
                    email: '{{ $order->shipping_email }}',
                    phone: '{{ $order->shipping_phone }}',
                    address: {
                        line1: '{{ addslashes($order->shipping_address) }}',
                        city: '{{ addslashes($order->shipping_city) }}',
                        postal_code: '{{ $order->shipping_postal_code ?? '' }}',
                        country: 'FR',
                    }
                }
            }
        });
    } catch (e) {
        showError('{{ __("payment.payment_element_error") }}: ' + e.message);
        return;
    }

    // Monter le Payment Element
    try {
        paymentElement.mount('#payment-element');
        console.log('Payment Element mounted successfully');
    } catch (e) {
        showError('{{ __("payment.mount_error") }}: ' + e.message);
        return;
    }

    // Événement quand le formulaire est prêt
    paymentElement.on('ready', function() {
        console.log('Payment Element ready');
        if (loadingDiv) loadingDiv.style.display = 'none';
        document.getElementById('submit-button').disabled = false;
    });

    // Événement pour les erreurs de chargement
    paymentElement.on('loaderror', function(event) {
        console.error('Payment Element load error:', event.error);
        showError(event.error?.message || '{{ __("payment.load_error") }}');
    });

    // Événement pour les changements
    paymentElement.on('change', function(event) {
        if (event.error) {
            messageDiv.textContent = event.error.message;
            messageDiv.classList.remove('hidden');
        } else {
            messageDiv.classList.add('hidden');
        }
    });

    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');
    const buttonText = document.getElementById('button-text');
    const spinner = document.getElementById('spinner');

    form.addEventListener('submit', async function(event) {
        event.preventDefault();

        submitButton.disabled = true;
        buttonText.classList.add('hidden');
        spinner.classList.remove('hidden');
        messageDiv.classList.add('hidden');

        try {
            const { error } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: returnUrl,
                },
            });

            if (error) {
                if (error.type === 'card_error' || error.type === 'validation_error') {
                    messageDiv.textContent = error.message;
                } else {
                    messageDiv.textContent = '{{ __("payment.unexpected_error") }}';
                    console.error('Payment error:', error);
                }
                messageDiv.classList.remove('hidden');
                submitButton.disabled = false;
                buttonText.classList.remove('hidden');
                spinner.classList.add('hidden');
            }
        } catch (e) {
            messageDiv.textContent = '{{ __("payment.unexpected_error") }}: ' + e.message;
            messageDiv.classList.remove('hidden');
            submitButton.disabled = false;
            buttonText.classList.remove('hidden');
            spinner.classList.add('hidden');
            console.error('Payment exception:', e);
        }
    });

    // Timeout de sécurité - si le formulaire ne se charge pas après 15 secondes
    setTimeout(function() {
        if (submitButton.disabled && loadingDiv && loadingDiv.style.display !== 'none') {
            showError('{{ __("payment.timeout_error") }}');
        }
    }, 15000);
});
</script>
@endpush
