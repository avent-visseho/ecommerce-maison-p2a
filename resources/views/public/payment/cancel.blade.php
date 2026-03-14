@extends('layouts.public')

@section('title', __('payment.cancel_title'))
@section('description', __('payment.cancel_meta'))

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-orange-50 to-neutral-50 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 text-center">
                <!-- Cancel Icon -->
                <div class="mb-6">
                    <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto">
                        <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Cancel Message -->
                <h1 class="text-3xl font-bold text-neutral-900 mb-4">{{ __('payment.cancel_heading') }}</h1>
                <p class="text-lg text-neutral-600 mb-8">
                    {!! __('payment.cancel_message', ['order_number' => '#'.$order->order_number]) !!}
                </p>

                <!-- Order Info -->
                <div class="bg-gradient-to-br from-orange-50 to-neutral-50 rounded-xl p-6 mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                        <div>
                            <p class="text-sm text-neutral-500 mb-1">{{ __('payment.order_amount') }}</p>
                            <p class="text-2xl font-bold text-orange-500">{{ number_format($order->total, 0, ',', ' ') }}
                                €</p>
                        </div>
                        <div>
                            <p class="text-sm text-neutral-500 mb-1">{{ __('payment.status') }}</p>
                            <span
                                class="inline-block px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-sm font-medium">
                                {{ __('payment.pending_payment') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Information -->
                <div class="bg-blue-50 rounded-xl p-6 mb-8 text-left">
                    <h3 class="text-lg font-bold text-neutral-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('payment.what_happened') }}
                    </h3>
                    <p class="text-sm text-neutral-600 mb-3">
                        {{ __('payment.cancel_explanation') }}
                    </p>
                    <ul class="space-y-2 text-sm text-neutral-600">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ __('payment.no_charge') }}</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ __('payment.order_valid_48h') }}</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ __('payment.payment_anytime') }}</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ __('payment.products_reserved') }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Reasons -->
                <div class="bg-neutral-50 rounded-xl p-6 mb-8 text-left">
                    <h3 class="text-lg font-bold text-neutral-900 mb-3">{{ __('payment.why_cancel') }}</h3>
                    <p class="text-sm text-neutral-600 mb-3">
                        {{ __('payment.cancel_reasons_intro') }}
                    </p>
                    <ul class="space-y-2 text-sm text-neutral-600">
                        <li class="flex items-start">
                            <span class="text-neutral-400 mr-2">•</span>
                            <span>{{ __('payment.check_order_details') }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-neutral-400 mr-2">•</span>
                            <span>{{ __('payment.prefer_another_method') }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-neutral-400 mr-2">•</span>
                            <span>{{ __('payment.modify_order') }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-neutral-400 mr-2">•</span>
                            <span>{{ __('payment.changed_mind') }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('payment.show', $order) }}" class="btn-primary">
                        <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        {{ __('payment.resume_payment') }}
                    </a>
                    <a href="{{ route('client.orders.show', $order) }}" class="btn-secondary">
                        <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        {{ __('payment.view_order') }}
                    </a>
                </div>

                <div class="mt-4">
                    <a href="{{ route('shop.index') }}" class="text-neutral-500 hover:text-neutral-700 text-sm">
                        {{ __('payment.back_to_shop') }}
                    </a>
                </div>

                <!-- Support -->
                <div class="mt-8 pt-8 border-t border-neutral-200">
                    <p class="text-sm text-neutral-600">
                        {{ __('payment.questions') }}
                        <a href="{{ route('contact') }}" class="text-primary-500 hover:text-primary-600 font-medium">
                            {{ __('payment.team_help') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
