@extends('layouts.public')

@section('title', __('payment.show_title'))
@section('description', __('payment.show_meta'))

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-primary-50 to-neutral-50 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-neutral-900 mb-2">{{ __('payment.finalize_payment') }}</h1>
                <p class="text-neutral-600">{{ __('payment.order_number', ['number' => $order->order_number]) }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Payment Methods -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Choose Payment Method -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-neutral-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-neutral-900">{{ __('payment.choose_payment_method') }}</h2>
                                <p class="text-sm text-neutral-500">{{ __('payment.secure_payment') }}</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <!-- Stripe Option -->
                            <a href="{{ route('stripe.show', $order) }}" class="block group">
                                <div class="border-2 border-neutral-200 hover:border-indigo-500 rounded-xl p-5 transition-all duration-200 hover:shadow-md">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                                                <svg class="w-8 h-8 text-indigo-600" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.409 0-.831.683-1.305 1.901-1.305 2.227 0 4.515.858 6.09 1.631l.89-5.494C18.252.975 15.697 0 12.165 0 9.667 0 7.589.654 6.104 1.872 4.56 3.147 3.757 4.992 3.757 7.218c0 4.039 2.467 5.76 6.476 7.219 2.585.92 3.445 1.574 3.445 2.583 0 .98-.84 1.545-2.354 1.545-1.875 0-4.965-.921-6.99-2.109l-.9 5.555C5.175 22.99 8.385 24 11.714 24c2.641 0 4.843-.624 6.328-1.813 1.664-1.305 2.525-3.236 2.525-5.732 0-4.128-2.524-5.851-6.591-7.305z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-neutral-900">{{ __('payment.pay_with_card') }}</h3>
                                                <p class="text-sm text-neutral-500">{{ __('payment.card_description') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <img src="https://cdn.jsdelivr.net/gh/nicehorse06/payment-logo@master/icons/visa.svg" alt="Visa" class="h-8">
                                            <img src="https://cdn.jsdelivr.net/gh/nicehorse06/payment-logo@master/icons/mastercard.svg" alt="Mastercard" class="h-8">
                                            <svg class="w-6 h-6 text-neutral-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            {{-- FedaPay Option - Temporairement désactivé, seul Stripe est utilisé
                            <div class="border-2 border-neutral-200 hover:border-primary-500 rounded-xl p-5 transition-all duration-200 hover:shadow-md">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center">
                                            <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-neutral-900">{{ __('payment.pay_with_mobile') }}</h3>
                                            <p class="text-sm text-neutral-500">{{ __('payment.mobile_description') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <div class="bg-primary-50 rounded-lg p-3 text-center">
                                        <svg class="w-6 h-6 mx-auto mb-1 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20 8H4V6h16m0 12H4v-6h16m0-8H4c-1.11 0-2 .89-2 2v12c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2z" />
                                        </svg>
                                        <p class="text-xs font-medium text-primary-700">{{ __('payment.mobile_money') }}</p>
                                    </div>
                                    <div class="bg-primary-50 rounded-lg p-3 text-center">
                                        <svg class="w-6 h-6 mx-auto mb-1 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z" />
                                        </svg>
                                        <p class="text-xs font-medium text-primary-700">{{ __('payment.bank_card') }}</p>
                                    </div>
                                </div>

                                <form action="{{ route('payment.initiate', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full btn-primary py-3 text-base font-semibold flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        {{ __('payment.proceed_payment') }}
                                    </button>
                                </form>
                            </div>
                            --}}
                        </div>

                        <div class="flex items-center justify-center space-x-4 mt-6 text-sm text-neutral-500">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                                {{ __('payment.secure_payment') }}
                            </div>
                            <span>•</span>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                {{ __('payment.email_confirmation') }}
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-neutral-200">
                        <h3 class="text-lg font-bold text-neutral-900 mb-4">{{ __('payment.shipping_info') }}</h3>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-neutral-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <div>
                                    <p class="text-sm text-neutral-500">{{ __('payment.full_name') }}</p>
                                    <p class="font-medium text-neutral-900">{{ $order->shipping_name }}</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-neutral-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <div>
                                    <p class="text-sm text-neutral-500">{{ __('payment.email') }}</p>
                                    <p class="font-medium text-neutral-900">{{ $order->shipping_email }}</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-neutral-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <div>
                                    <p class="text-sm text-neutral-500">{{ __('payment.phone') }}</p>
                                    <p class="font-medium text-neutral-900">{{ $order->shipping_phone }}</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-neutral-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <div>
                                    <p class="text-sm text-neutral-500">{{ __('payment.shipping_address') }}</p>
                                    <p class="font-medium text-neutral-900">{{ $order->shipping_address }}</p>
                                    <p class="text-sm text-neutral-600">{{ $order->shipping_city }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Details Sidebar -->
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
                                    <p class="text-sm font-semibold text-neutral-900">{{ number_format($item->subtotal, 0, ',', ' ') }} &euro;</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-neutral-200 pt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-neutral-600">{{ __('payment.subtotal') }}</span>
                                <span class="font-medium">{{ number_format($order->subtotal, 0, ',', ' ') }} &euro;</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-neutral-600">{{ __('payment.shipping') }}</span>
                                <span class="font-medium">{{ number_format($order->shipping, 0, ',', ' ') }} &euro;</span>
                            </div>
                            @if ($order->tax > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-neutral-600">{{ __('payment.taxes') }}</span>
                                    <span class="font-medium">{{ number_format($order->tax, 0, ',', ' ') }} &euro;</span>
                                </div>
                            @endif
                            <div class="border-t border-neutral-200 pt-2 mt-2">
                                <div class="flex justify-between">
                                    <span class="text-lg font-bold text-neutral-900">{{ __('payment.total') }}</span>
                                    <span class="text-lg font-bold text-primary-500">{{ number_format($order->total, 0, ',', ' ') }} &euro;</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-neutral-200">
                            <div class="flex items-center text-sm text-neutral-600">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ __('payment.payment_100_secure') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back to Orders -->
            <div class="text-center mt-8">
                <a href="{{ route('client.orders.show', $order) }}" class="text-primary-500 hover:text-primary-600 font-medium">
                    {{ __('payment.back_to_order') }}
                </a>
            </div>
        </div>
    </div>
@endsection
