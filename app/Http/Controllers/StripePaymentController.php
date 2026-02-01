<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Services\StripeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\SignatureVerificationException;

class StripePaymentController extends Controller
{
    protected StripeService $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    /**
     * Display Stripe payment page
     */
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->isPaid()) {
            return redirect()->route('client.orders.show', $order)
                ->with('info', __('payment.already_paid'));
        }

        try {
            $paymentIntent = $this->stripeService->getOrCreatePaymentIntent($order);

            return view('public.payment.stripe', [
                'order' => $order,
                'clientSecret' => $paymentIntent->client_secret,
                'publishableKey' => $this->stripeService->getPublishableKey(),
                'returnUrl' => route('stripe.callback', $order),
            ]);
        } catch (ApiErrorException $e) {
            Log::error('Failed to create Stripe payment page', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('payment.show', $order)
                ->with('error', __('payment.stripe_init_error'));
        }
    }

    /**
     * Create PaymentIntent via AJAX (for SPA/dynamic updates)
     */
    public function createIntent(Order $order): JsonResponse
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($order->isPaid()) {
            return response()->json(['error' => __('payment.already_paid')], 400);
        }

        try {
            $paymentIntent = $this->stripeService->getOrCreatePaymentIntent($order);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
                'paymentIntentId' => $paymentIntent->id,
            ]);
        } catch (ApiErrorException $e) {
            Log::error('Failed to create PaymentIntent via API', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => __('payment.stripe_init_error'),
            ], 500);
        }
    }

    /**
     * Handle Stripe redirect callback
     */
    public function callback(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $paymentIntentId = $request->get('payment_intent');

        if (!$paymentIntentId) {
            Log::warning('Stripe callback without payment_intent', [
                'order_id' => $order->id,
                'request' => $request->all(),
            ]);
            return redirect()->route('stripe.failed', $order);
        }

        try {
            $paymentIntent = $this->stripeService->retrievePaymentIntent($paymentIntentId);

            Log::info('Stripe callback received', [
                'order_id' => $order->id,
                'payment_intent_id' => $paymentIntentId,
                'status' => $paymentIntent->status,
            ]);

            switch ($paymentIntent->status) {
                case 'succeeded':
                    $this->handleSuccessfulPayment($order, $paymentIntent);
                    return redirect()->route('stripe.success', $order);

                case 'processing':
                    return redirect()->route('stripe.success', $order)
                        ->with('info', __('payment.processing'));

                case 'requires_payment_method':
                    return redirect()->route('stripe.show', $order)
                        ->with('error', __('payment.requires_new_method'));

                default:
                    return redirect()->route('stripe.failed', $order);
            }
        } catch (ApiErrorException $e) {
            Log::error('Stripe callback error', [
                'order_id' => $order->id,
                'payment_intent_id' => $paymentIntentId,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('stripe.failed', $order);
        }
    }

    /**
     * Handle Stripe webhooks
     */
    public function webhook(Request $request): JsonResponse
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');

        if (!$signature) {
            Log::warning('Stripe webhook without signature');
            return response()->json(['error' => 'Missing signature'], 400);
        }

        try {
            $event = $this->stripeService->verifyWebhookSignature($payload, $signature);

            Log::info('Stripe webhook received', [
                'type' => $event->type,
                'id' => $event->id,
            ]);

            switch ($event->type) {
                case 'payment_intent.succeeded':
                    $this->handleWebhookPaymentSuccess($event->data->object);
                    break;

                case 'payment_intent.payment_failed':
                    $this->handleWebhookPaymentFailed($event->data->object);
                    break;

                case 'charge.refunded':
                    $this->handleWebhookRefund($event->data->object);
                    break;

                default:
                    Log::info('Unhandled Stripe webhook event', ['type' => $event->type]);
            }

            return response()->json(['received' => true]);

        } catch (SignatureVerificationException $e) {
            Log::warning('Invalid Stripe webhook signature', [
                'error' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'Invalid signature'], 400);

        } catch (\Exception $e) {
            Log::error('Stripe webhook processing error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }

    /**
     * Display success page
     */
    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('public.payment.success', compact('order'));
    }

    /**
     * Display failed page
     */
    public function failed(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('public.payment.failed', [
            'order' => $order,
            'isStripe' => true,
        ]);
    }

    /**
     * Handle successful payment
     */
    private function handleSuccessfulPayment(Order $order, $paymentIntent): void
    {
        if ($order->isPaid()) {
            return;
        }

        $order->update([
            'payment_status' => 'paid',
            'transaction_id' => $paymentIntent->id,
            'paid_at' => now(),
        ]);

        // Confirm rental reservations
        $order->load('items.rentalReservation');
        foreach ($order->items as $item) {
            if ($item->isRental() && $item->rentalReservation) {
                $item->rentalReservation->update(['status' => 'confirmed']);
            }
        }

        // Send confirmation emails
        try {
            Mail::to($order->shipping_email)->send(new OrderConfirmation($order));
            Mail::to(config('mail.from.address'))->send(new OrderConfirmation($order, true));
        } catch (\Exception $e) {
            Log::error('Failed to send order confirmation email', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
        }

        Log::info('Order payment successful', [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'payment_intent_id' => $paymentIntent->id,
        ]);
    }

    /**
     * Handle webhook payment success
     */
    private function handleWebhookPaymentSuccess($paymentIntent): void
    {
        $order = Order::where('stripe_payment_intent_id', $paymentIntent->id)->first();

        if (!$order) {
            Log::warning('Order not found for PaymentIntent', [
                'payment_intent_id' => $paymentIntent->id,
            ]);
            return;
        }

        $this->handleSuccessfulPayment($order, $paymentIntent);
    }

    /**
     * Handle webhook payment failure
     */
    private function handleWebhookPaymentFailed($paymentIntent): void
    {
        $order = Order::where('stripe_payment_intent_id', $paymentIntent->id)->first();

        if (!$order) {
            return;
        }

        Log::info('Payment failed via webhook', [
            'order_id' => $order->id,
            'payment_intent_id' => $paymentIntent->id,
            'error' => $paymentIntent->last_payment_error?->message ?? 'Unknown error',
        ]);
    }

    /**
     * Handle webhook refund
     */
    private function handleWebhookRefund($charge): void
    {
        $order = Order::where('stripe_payment_intent_id', $charge->payment_intent)->first();

        if (!$order) {
            return;
        }

        if ($charge->refunded) {
            $order->update([
                'payment_status' => 'refunded',
            ]);

            Log::info('Order refunded via webhook', [
                'order_id' => $order->id,
                'charge_id' => $charge->id,
            ]);
        }
    }
}
