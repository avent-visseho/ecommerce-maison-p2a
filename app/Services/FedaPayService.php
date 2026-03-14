<?php

namespace App\Services;

use App\Models\Order;
use Exception;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use Illuminate\Support\Facades\Log;

class FedaPayService
{


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
            // fin
            FedaPay::setApiKey(env('FEDAPAY_API_KEY'));
            FedaPay::setEnvironment(env('FEDAPAY_ENVIRONMENT'));
            $transaction = Transaction::create([
                'description' => 'Commande #' . $order->order_number . ' - La Maison P2A',
                'amount' => (int) $order->total,
                "currency" => ["iso" => "XOF"],
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

            ]);

            $token = $transaction->generateToken();
            return $token;

        } catch (Exception $e) {
            Log::error('FedaPay API error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }


}