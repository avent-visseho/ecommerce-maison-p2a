@extends('layouts.public')

@section('title', __('payment.failed_title'))
@section('description', __('payment.failed_meta'))

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-red-50 to-neutral-50 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 text-center">
                <!-- Error Icon -->
                <div class="mb-6">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto">
                        <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>

                <!-- Error Message -->
                <h1 class="text-3xl font-bold text-neutral-900 mb-4">{{ __('payment.failed_heading') }}</h1>
                <p class="text-lg text-neutral-600 mb-8">
                    {!! __('payment.failed_message', ['order_number' => '#'.$order->order_number]) !!}
                </p>

                <!-- Reasons -->
                <div class="bg-red-50 rounded-xl p-6 mb-8 text-left">
                    <h3 class="text-lg font-bold text-neutral-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        {{ __('payment.possible_reasons') }}
                    </h3>
                    <ul class="space-y-2 text-sm text-neutral-600">
                        <li class="flex items-start">
                            <span class="text-red-500 mr-2">•</span>
                            <span>{{ __('payment.insufficient_balance') }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-red-500 mr-2">•</span>
                            <span>{{ __('payment.incorrect_info') }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-red-500 mr-2">•</span>
                            <span>{{ __('payment.connection_issue') }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-red-500 mr-2">•</span>
                            <span>{{ __('payment.payment_cancelled_by_bank') }}</span>
                        </li>
                    </ul>
                </div>

                <!-- What to Do -->
                <div class="bg-blue-50 rounded-xl p-6 mb-8 text-left">
                    <h3 class="text-lg font-bold text-neutral-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('payment.what_to_do') }}
                    </h3>
                    <ul class="space-y-2 text-sm text-neutral-600">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ __('payment.check_balance') }}</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ __('payment.stable_connection') }}</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ __('payment.try_another_method') }}</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ __('payment.contact_support') }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Order Status Notice -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-8">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <div class="text-left">
                            <p class="text-sm font-semibold text-yellow-800 mb-1">{{ __('payment.order_pending_notice') }}</p>
                            <p class="text-xs text-yellow-700">{{ __('payment.order_not_cancelled') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('payment.show', $order) }}" class="btn-primary">
                        <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        {{ __('payment.retry_payment') }}
                    </a>
                    <a href="{{ route('client.orders.show', $order) }}" class="btn-secondary">
                        <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        {{ __('payment.view_order') }}
                    </a>
                </div>

                <!-- Support -->
                <div class="mt-8 pt-8 border-t border-neutral-200">
                    <p class="text-sm text-neutral-600">
                        {{ __('payment.need_help') }}
                        <a href="{{ route('contact') }}" class="text-primary-500 hover:text-primary-600 font-medium">
                            {{ __('payment.contact_customer_service') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
