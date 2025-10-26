<?php

namespace App\Services;

use App\Models\Order;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FedaPayService
{
    protected $apiKey;
    protected $baseUrl;
    protected $currency;

    public function __construct()
    {
        $this->apiKey = config('services.fedapay.api_key');
        $environment = config('services.fedapay.environment', 'sandbox');
        $this->baseUrl = $environment === 'live'
            ? 'https://api.fedapay.com/v1'
            : 'https://sandbox-api.fedapay.com/v1';
        $this->currency = config('services.fedapay.currency', 'XOF');
    }

    /**
     * Create a transaction for an order
     */
    public function createTransaction(Order $order, string $callbackUrl, string $cancelUrl)
    {
        try {
            // Séparer le nom en prénom et nom
            $nameParts = explode(' ', $order->shipping_name, 2);
            $firstname = $nameParts[0] ?? $order->shipping_name;
            $lastname = $nameParts[1] ?? $nameParts[0];

            // Nettoyer le numéro de téléphone (enlever espaces, tirets, etc.)
            $phoneNumber = preg_replace('/[^0-9+]/', '', $order->shipping_phone);

            // S'assurer que le numéro commence par + ou ajouter l'indicatif pays du Bénin
            if (!str_starts_with($phoneNumber, '+')) {
                // Si le numéro commence par 0, le remplacer par +229
                if (str_starts_with($phoneNumber, '0')) {
                    $phoneNumber = '+229' . substr($phoneNumber, 1);
                } else {
                    $phoneNumber = '+229' . $phoneNumber;
                }
            }

            $payload = [
                'description' => 'Commande #' . $order->order_number . ' - La Maison P2A',
                'amount' => (int)$order->total,
                'currency' => [
                    'iso' => $this->currency,
                ],
                'callback_url' => $callbackUrl,
                'cancel_url' => $cancelUrl,
                'customer' => [
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'email' => $order->shipping_email,
                    'phone_number' => [
                        'number' => $phoneNumber,
                        'country' => 'bj',
                    ],
                ],
            ];

            Log::info('FedaPay Request Payload', $payload);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/transactions', $payload);

            Log::info('FedaPay Response', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            // Log l'erreur détaillée
            Log::error('FedaPay transaction creation failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'payload' => $payload,
            ]);

            throw new Exception('Échec de la création de la transaction: ' . $response->body());
        } catch (Exception $e) {
            Log::error('FedaPay API error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Get transaction details
     */
    public function getTransaction(string $transactionId)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->get($this->baseUrl . '/transactions/' . $transactionId);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('FedaPay get transaction failed', [
                'transaction_id' => $transactionId,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new Exception('Échec de la récupération de la transaction');
        } catch (Exception $e) {
            Log::error('FedaPay get transaction error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Verify webhook signature
     */
    public function verifyWebhookSignature(string $payload, string $signature): bool
    {
        $secret = config('services.fedapay.webhook_secret');

        if (empty($secret)) {
            Log::warning('FedaPay webhook secret is not configured');
            return false;
        }

        $computedSignature = hash_hmac('sha256', $payload, $secret);

        return hash_equals($computedSignature, $signature);
    }

    /**
     * Generate payment token
     */
    public function generateToken(Order $order)
    {
        try {
            $nameParts = explode(' ', $order->shipping_name, 2);
            $firstname = $nameParts[0] ?? $order->shipping_name;
            $lastname = $nameParts[1] ?? $nameParts[0];

            // Nettoyer le numéro de téléphone
            $phoneNumber = preg_replace('/[^0-9+]/', '', $order->shipping_phone);

            if (!str_starts_with($phoneNumber, '+')) {
                if (str_starts_with($phoneNumber, '0')) {
                    $phoneNumber = '+229' . substr($phoneNumber, 1);
                } else {
                    $phoneNumber = '+229' . $phoneNumber;
                }
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/transactions', [
                'description' => 'Commande #' . $order->order_number,
                'amount' => (int)$order->total,
                'currency' => [
                    'iso' => $this->currency,
                ],
                'customer' => [
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'email' => $order->shipping_email,
                    'phone_number' => [
                        'number' => $phoneNumber,
                        'country' => 'bj',
                    ],
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['v1/transaction']['token'] ?? null;
            }

            Log::error('FedaPay token generation failed', [
                'response' => $response->body(),
            ]);

            return null;
        } catch (Exception $e) {
            Log::error('FedaPay token generation error: ' . $e->getMessage());
            return null;
        }
    }
}
