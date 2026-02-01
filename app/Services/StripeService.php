<?php

namespace App\Services;

use App\Models\Order;
use Exception;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\SignatureVerificationException;
use Stripe\PaymentIntent;
use Stripe\Refund;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        // Utiliser une version stable de l'API Stripe
        Stripe::setApiVersion('2023-10-16');
    }

    /**
     * Create a PaymentIntent for an order
     */
    public function createPaymentIntent(Order $order): PaymentIntent
    {
        try {
            $amount = $this->convertToSmallestUnit($order->total);

            $paymentIntentData = [
                'amount' => $amount,
                'currency' => strtolower(config('services.stripe.currency', 'eur')),
                'metadata' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer_email' => $order->shipping_email,
                ],
                'description' => 'Commande #' . $order->order_number . ' - La Maison P2A',
                'receipt_email' => $order->shipping_email,
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ];

            // Add shipping info if available
            if ($order->shipping_name && $order->shipping_address) {
                $paymentIntentData['shipping'] = [
                    'name' => $order->shipping_name,
                    'phone' => $order->shipping_phone,
                    'address' => [
                        'line1' => $order->shipping_address,
                        'city' => $order->shipping_city,
                        'postal_code' => $order->shipping_postal_code ?? '',
                        'country' => 'FR',
                    ],
                ];
            }

            $paymentIntent = PaymentIntent::create($paymentIntentData);

            $order->update([
                'stripe_payment_intent_id' => $paymentIntent->id,
                'payment_method' => 'stripe',
            ]);

            Log::info('Stripe PaymentIntent created', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'payment_intent_id' => $paymentIntent->id,
                'amount' => $amount,
                'currency' => config('services.stripe.currency', 'eur'),
            ]);

            return $paymentIntent;

        } catch (ApiErrorException $e) {
            Log::error('Stripe PaymentIntent creation error', [
                'message' => $e->getMessage(),
                'code' => $e->getStripeCode(),
                'order_id' => $order->id,
            ]);
            throw $e;
        }
    }

    /**
     * Retrieve or create PaymentIntent for an order
     */
    public function getOrCreatePaymentIntent(Order $order): PaymentIntent
    {
        if ($order->stripe_payment_intent_id) {
            try {
                $paymentIntent = $this->retrievePaymentIntent($order->stripe_payment_intent_id);

                // If intent is still usable, return it
                if (in_array($paymentIntent->status, ['requires_payment_method', 'requires_confirmation', 'requires_action'])) {
                    return $paymentIntent;
                }

                // If succeeded or canceled, create new one
                if (in_array($paymentIntent->status, ['succeeded', 'canceled'])) {
                    return $this->createPaymentIntent($order);
                }

                return $paymentIntent;
            } catch (ApiErrorException $e) {
                Log::warning('Failed to retrieve existing PaymentIntent, creating new one', [
                    'order_id' => $order->id,
                    'old_intent_id' => $order->stripe_payment_intent_id,
                ]);
            }
        }

        return $this->createPaymentIntent($order);
    }

    /**
     * Retrieve a PaymentIntent
     */
    public function retrievePaymentIntent(string $paymentIntentId): PaymentIntent
    {
        return PaymentIntent::retrieve($paymentIntentId);
    }

    /**
     * Confirm payment was successful
     */
    public function confirmPaymentSuccess(string $paymentIntentId): bool
    {
        try {
            $paymentIntent = $this->retrievePaymentIntent($paymentIntentId);
            return $paymentIntent->status === 'succeeded';
        } catch (ApiErrorException $e) {
            Log::error('Failed to confirm payment status', [
                'payment_intent_id' => $paymentIntentId,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Verify webhook signature and return event
     */
    public function verifyWebhookSignature(string $payload, string $signature): \Stripe\Event
    {
        $webhookSecret = config('services.stripe.webhook_secret');

        if (empty($webhookSecret)) {
            throw new Exception('Stripe webhook secret not configured');
        }

        try {
            return Webhook::constructEvent($payload, $signature, $webhookSecret);
        } catch (SignatureVerificationException $e) {
            Log::warning('Stripe webhook signature verification failed', [
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Get publishable key for frontend
     */
    public function getPublishableKey(): string
    {
        return config('services.stripe.key');
    }

    /**
     * Get configured currency
     */
    public function getCurrency(): string
    {
        return strtolower(config('services.stripe.currency', 'eur'));
    }

    /**
     * Cancel a PaymentIntent
     */
    public function cancelPaymentIntent(string $paymentIntentId): PaymentIntent
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            if (!in_array($paymentIntent->status, ['canceled', 'succeeded'])) {
                $paymentIntent = $paymentIntent->cancel();

                Log::info('Stripe PaymentIntent canceled', [
                    'payment_intent_id' => $paymentIntentId,
                ]);
            }

            return $paymentIntent;
        } catch (ApiErrorException $e) {
            Log::error('Stripe PaymentIntent cancellation error', [
                'message' => $e->getMessage(),
                'payment_intent_id' => $paymentIntentId,
            ]);
            throw $e;
        }
    }

    /**
     * Create a refund for a payment
     */
    public function createRefund(string $paymentIntentId, ?int $amount = null): Refund
    {
        try {
            $refundData = ['payment_intent' => $paymentIntentId];

            if ($amount !== null) {
                $refundData['amount'] = $amount;
            }

            $refund = Refund::create($refundData);

            Log::info('Stripe refund created', [
                'payment_intent_id' => $paymentIntentId,
                'refund_id' => $refund->id,
                'amount' => $amount,
            ]);

            return $refund;
        } catch (ApiErrorException $e) {
            Log::error('Stripe refund error', [
                'message' => $e->getMessage(),
                'payment_intent_id' => $paymentIntentId,
            ]);
            throw $e;
        }
    }

    /**
     * Convert amount to smallest currency unit (cents/centimes)
     */
    private function convertToSmallestUnit(float $amount): int
    {
        $zeroDecimalCurrencies = ['bif', 'clp', 'djf', 'gnf', 'jpy', 'kmf', 'krw', 'mga', 'pyg', 'rwf', 'ugx', 'vnd', 'vuv', 'xaf', 'xof', 'xpf'];

        $currency = strtolower(config('services.stripe.currency', 'eur'));

        if (in_array($currency, $zeroDecimalCurrencies)) {
            return (int) round($amount);
        }

        return (int) round($amount * 100);
    }
}
