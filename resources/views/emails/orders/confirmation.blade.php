<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de commande</title>
</head>

<body
    style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f4f5f7;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f5f7; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);">
                    <!-- Header -->
                    <tr>
                        <td
                            style="background: linear-gradient(135deg, #2725a9 0%, #1f1d87 100%); padding: 40px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: bold;">La Maison P2A
                            </h1>
                            <p style="color: #e7eaf6; margin: 10px 0 0 0; font-size: 14px;">Confirmation de votre
                                commande</p>
                        </td>
                    </tr>

                    <!-- Success Message -->
                    <tr>
                        <td style="padding: 40px; text-align: center;">
                            <div
                                style="width: 64px; height: 64px; background-color: #10b981; border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center;">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ffffff"
                                    stroke-width="3">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <h2 style="color: #0c0d10; margin: 0 0 12px 0; font-size: 24px; font-weight: bold;">Merci
                                pour votre commande !</h2>
                            <p style="color: #606266; margin: 0; font-size: 16px; line-height: 1.6;">
                                Bonjour <strong>{{ $order->shipping_name }}</strong>,<br>
                                Nous avons bien reçu votre commande et nous la préparons avec soin.
                            </p>
                        </td>
                    </tr>

                    <!-- Order Details -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="background-color: #f9f5f2; border-radius: 12px; padding: 24px;">
                                <tr>
                                    <td>
                                        <h3
                                            style="color: #0c0d10; margin: 0 0 16px 0; font-size: 18px; font-weight: 600;">
                                            Détails de la commande</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 12px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="color: #606266; font-size: 14px; padding-bottom: 8px;">Numéro
                                                    de commande:</td>
                                                <td align="right"
                                                    style="color: #0c0d10; font-size: 14px; font-weight: 600; padding-bottom: 8px;">
                                                    {{ $order->order_number }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #606266; font-size: 14px; padding-bottom: 8px;">Date:
                                                </td>
                                                <td align="right"
                                                    style="color: #0c0d10; font-size: 14px; font-weight: 600; padding-bottom: 8px;">
                                                    {{ $order->created_at->format('d/m/Y à H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #606266; font-size: 14px;">Total:</td>
                                                <td align="right"
                                                    style="color: #2725a9; font-size: 18px; font-weight: bold;">
                                                    {{ number_format($order->total, 0, ',', ' ') }} FCFA</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Products -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px;">
                            <h3 style="color: #0c0d10; margin: 0 0 20px 0; font-size: 18px; font-weight: 600;">Articles
                                commandés</h3>
                            <table width="100%" cellpadding="0" cellspacing="0">
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td style="padding: 16px 0; border-bottom: 1px solid #dddfe7;">
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td width="80%">
                                                        <p
                                                            style="margin: 0; color: #0c0d10; font-size: 14px; font-weight: 600;">
                                                            {{ $item->product_name }}</p>
                                                        <p style="margin: 4px 0 0 0; color: #606266; font-size: 13px;">
                                                            Quantité: {{ $item->quantity }} ×
                                                            {{ number_format($item->price, 0, ',', ' ') }} FCFA</p>
                                                    </td>
                                                    <td width="20%" align="right">
                                                        <p
                                                            style="margin: 0; color: #0c0d10; font-size: 14px; font-weight: 600;">
                                                            {{ number_format($item->subtotal, 0, ',', ' ') }} FCFA</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>

                    <!-- Totals -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding: 8px 0; color: #606266; font-size: 14px;">Sous-total</td>
                                    <td align="right"
                                        style="padding: 8px 0; color: #0c0d10; font-size: 14px; font-weight: 600;">
                                        {{ number_format($order->subtotal, 0, ',', ' ') }} FCFA</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color: #606266; font-size: 14px;">Livraison</td>
                                    <td align="right"
                                        style="padding: 8px 0; color: #0c0d10; font-size: 14px; font-weight: 600;">
                                        {{ number_format($order->shipping, 0, ',', ' ') }} FCFA</td>
                                </tr>
                                <tr style="border-top: 2px solid #dddfe7;">
                                    <td
                                        style="padding: 16px 0 0 0; color: #0c0d10; font-size: 16px; font-weight: bold;">
                                        Total</td>
                                    <td align="right"
                                        style="padding: 16px 0 0 0; color: #2725a9; font-size: 20px; font-weight: bold;">
                                        {{ number_format($order->total, 0, ',', ' ') }} FCFA</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Shipping Address -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="background-color: #e7eaf6; border-radius: 12px; padding: 24px;">
                                <tr>
                                    <td>
                                        <h3
                                            style="color: #0c0d10; margin: 0 0 16px 0; font-size: 16px; font-weight: 600;">
                                            Adresse de livraison</h3>
                                        <p style="margin: 0; color: #0c0d10; font-size: 14px; line-height: 1.6;">
                                            <strong>{{ $order->shipping_name }}</strong><br>
                                            {{ $order->shipping_address }}<br>
                                            {{ $order->shipping_city }}<br>
                                            {{ $order->shipping_phone }}<br>
                                            {{ $order->shipping_email }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Next Steps -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px;">
                            <div
                                style="background-color: #f3ebf8; border-left: 4px solid #2725a9; border-radius: 8px; padding: 20px;">
                                <h3 style="color: #0c0d10; margin: 0 0 12px 0; font-size: 16px; font-weight: 600;">
                                    Prochaines étapes</h3>
                                <ul
                                    style="margin: 0; padding-left: 20px; color: #606266; font-size: 14px; line-height: 1.8;">
                                    <li>Nous préparons votre commande avec soin</li>
                                    <li>Vous recevrez un email de confirmation d'expédition</li>
                                    <li>Livraison estimée : 2-5 jours ouvrables</li>
                                    <li>Suivez votre commande dans votre espace client</li>
                                </ul>
                            </div>
                        </td>
                    </tr>

                    <!-- CTA Button -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px; text-align: center;">
                            <a href="{{ route('client.orders.show', $order) }}"
                                style="display: inline-block; background-color: #2725a9; color: #ffffff; text-decoration: none; padding: 16px 32px; border-radius: 12px; font-size: 16px; font-weight: 600;">
                                Suivre ma commande
                            </a>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9f5f2; padding: 32px 40px; text-align: center;">
                            <p style="margin: 0 0 16px 0; color: #606266; font-size: 14px;">
                                Besoin d'aide ? Contactez-nous :
                            </p>
                            <p style="margin: 0; color: #2725a9; font-size: 14px; font-weight: 600;">
                                contact@lamaisonp2a.com | +229 XX XX XX XX
                            </p>
                            <div style="margin: 24px 0 0 0;">
                                <a href="#" style="display: inline-block; margin: 0 8px;">
                                    <img src="https://via.placeholder.com/24" alt="Facebook"
                                        style="width: 24px; height: 24px;">
                                </a>
                                <a href="#" style="display: inline-block; margin: 0 8px;">
                                    <img src="https://via.placeholder.com/24" alt="Instagram"
                                        style="width: 24px; height: 24px;">
                                </a>
                                <a href="#" style="display: inline-block; margin: 0 8px;">
                                    <img src="https://via.placeholder.com/24" alt="Twitter"
                                        style="width: 24px; height: 24px;">
                                </a>
                            </div>
                            <p style="margin: 24px 0 0 0; color: #4f5561; font-size: 12px;">
                                © {{ date('Y') }} La Maison P2A. Tous droits réservés.<br>
                                Cotonou, Bénin
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
