<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Services\FedaPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    protected $fedaPayService;

    public function __construct(FedaPayService $fedaPayService)
    {
        $this->fedaPayService = $fedaPayService;
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->isPaid()) {
            return redirect()->route('client.orders.show', $order);
        }

        return view('public.payment.show', compact('order'));
    }

    public function initiate(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Vérifier si la commande est déjà payée
        if ($order->isPaid()) {
            return redirect()->route('client.orders.show', $order)
                ->with('info', 'Cette commande a déjà été payée.');
        }

        try {
            $callbackUrl = route('payment.callback', $order);
            $cancelUrl = route('payment.cancel', $order);

            Log::info('Initiating payment for order', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'amount' => $order->total,
                'callback_url' => $callbackUrl,
                'cancel_url' => $cancelUrl,
            ]);

            $transaction = $this->fedaPayService->createTransaction($order, $callbackUrl, $cancelUrl);

            if (isset($transaction['v1/transaction'])) {
                $transactionData = $transaction['v1/transaction'];

                Log::info('Transaction created successfully', [
                    'transaction_id' => $transactionData['id'],
                    'transaction_data' => $transactionData,
                ]);

                $order->update([
                    'transaction_id' => $transactionData['id'],
                ]);

                // Redirect to FedaPay payment page
                if (isset($transactionData['url'])) {
                    return redirect($transactionData['url']);
                }

                // Si pas d'URL, essayer avec le token
                if (isset($transactionData['token'])) {
                    $paymentUrl = 'https://checkout.fedapay.com/' . $transactionData['token'];
                    return redirect($paymentUrl);
                }
            }

            Log::error('No transaction data in response', ['response' => $transaction]);
            return redirect()->back()->with('error', 'Impossible d\'initier le paiement. Veuillez réessayer.');
        } catch (\Exception $e) {
            Log::error('Payment initiation error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'order_id' => $order->id,
            ]);

            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'initiation du paiement. Veuillez vérifier vos informations et réessayer.');
        }
    }

    public function callback(Request $request, Order $order)
    {
        try {
            Log::info('Payment callback received', [
                'order_id' => $order->id,
                'request_data' => $request->all(),
            ]);

            if ($request->has('transaction_id')) {
                $transactionId = $request->transaction_id;
                $transaction = $this->fedaPayService->getTransaction($transactionId);

                if (isset($transaction['v1/transaction'])) {
                    $transactionData = $transaction['v1/transaction'];

                    Log::info('Transaction status', [
                        'transaction_id' => $transactionId,
                        'status' => $transactionData['status'],
                    ]);

                    if ($transactionData['status'] === 'approved') {
                        $order->update([
                            'payment_status' => 'paid',
                            'status' => 'processing',
                            'paid_at' => now(),
                        ]);

                        // Send confirmation email
                        try {
                            Mail::to($order->shipping_email)->send(new OrderConfirmation($order));
                            Mail::to(config('mail.from.address'))->send(new OrderConfirmation($order, true));
                        } catch (\Exception $e) {
                            Log::error('Failed to send confirmation email', [
                                'error' => $e->getMessage(),
                            ]);
                        }

                        return redirect()->route('payment.success', $order);
                    }
                }
            }

            return redirect()->route('payment.failed', $order);
        } catch (\Exception $e) {
            Log::error('Payment callback error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('payment.failed', $order);
        }
    }

    public function webhook(Request $request)
    {
        try {
            $payload = $request->getContent();
            $signature = $request->header('X-FedaPay-Signature');

            Log::info('Webhook received', [
                'payload' => $payload,
                'signature' => $signature,
            ]);

            if (!$this->fedaPayService->verifyWebhookSignature($payload, $signature)) {
                Log::warning('Invalid webhook signature');
                return response()->json(['error' => 'Invalid signature'], 400);
            }

            $data = json_decode($payload, true);

            if ($data['event'] === 'transaction.approved') {
                $transactionId = $data['entity']['id'];

                $order = Order::where('transaction_id', $transactionId)->first();

                if ($order && !$order->isPaid()) {
                    $order->update([
                        'payment_status' => 'paid',
                        'status' => 'processing',
                        'paid_at' => now(),
                    ]);

                    try {
                        Mail::to($order->shipping_email)->send(new OrderConfirmation($order));
                    } catch (\Exception $e) {
                        Log::error('Failed to send confirmation email from webhook', [
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Webhook error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('public.payment.success', compact('order'));
    }

    public function failed(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('public.payment.failed', compact('order'));
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('public.payment.cancel', compact('order'));
    }
}
