<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle commande</title>
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
                            style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); padding: 40px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: bold;">🔔 Nouvelle
                                Commande</h1>
                            <p style="color: #fef3c7; margin: 10px 0 0 0; font-size: 14px;">Une nouvelle commande a été
                                passée</p>
                        </td>
                    </tr>

                    <!-- Alert Message -->
                    <tr>
                        <td style="padding: 40px; text-align: center;">
                            <div
                                style="background-color: #fef3c7; border-left: 4px solid #f59e0b; border-radius: 8px; padding: 20px; text-align: left; margin-bottom: 20px;">
                                <p style="margin: 0; color: #92400e; font-size: 14px; font-weight: 600;">
                                    ⚠️ Action requise : Une nouvelle commande nécessite votre attention
                                </p>
                            </div>
                            <h2 style="color: #0c0d10; margin: 0 0 12px 0; font-size: 24px; font-weight: bold;">Commande
                                {{ $order->order_number }}</h2>
                            <p style="color: #606266; margin: 0; font-size: 16px;">
                                Commande passée le {{ $order->created_at->format('d/m/Y à H:i') }}
                            </p>
                        </td>
                    </tr>

                    <!-- Order Summary -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="background-color: #f9f5f2; border-radius: 12px; padding: 24px;">
                                <tr>
                                    <td>
                                        <h3
                                            style="color: #0c0d10; margin: 0 0 16px 0; font-size: 18px; font-weight: 600;">
                                            Résumé</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="color: #606266; font-size: 14px; padding-bottom: 8px;">
                                                    Client:</td>
                                                <td align="right"
                                                    style="color: #0c0d10; font-size: 14px; font-weight: 600; padding-bottom: 8px;">
                                                    {{ $order->user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #606266; font-size: 14px; padding-bottom: 8px;">Email:
                                                </td>
                                                <td align="right"
                                                    style="color: #0c0d10; font-size: 14px; font-weight: 600; padding-bottom: 8px;">
                                                    {{ $order->shipping_email }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #606266; font-size: 14px; padding-bottom: 8px;">
                                                    Téléphone:</td>
                                                <td align="right"
                                                    style="color: #0c0d10; font-size: 14px; font-weight: 600; padding-bottom: 8px;">
                                                    {{ $order->shipping_phone }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #606266; font-size: 14px; padding-bottom: 8px;">
                                                    Articles:</td>
                                                <td align="right"
                                                    style="color: #0c0d10; font-size: 14px; font-weight: 600; padding-bottom: 8px;">
                                                    {{ $order->items->count() }}</td>
                                            </tr>
                                            <tr style="border-top: 1px solid #dddfe7;">
                                                <td style="color: #606266; font-size: 14px; padding-top: 8px;">Total:
                                                </td>
                                                <td align="right"
                                                    style="color: #2725a9; font-size: 18px; font-weight: bold; padding-top: 8px;">
                                                    {{ number_format($order->total, 0, ',', ' ') }} €</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Products List -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px;">
                            <h3 style="color: #0c0d10; margin: 0 0 20px 0; font-size: 18px; font-weight: 600;">Articles
                                commandés</h3>
                            <table width="100%" cellpadding="0" cellspacing="0">
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td style="padding: 12px 0; border-bottom: 1px solid #dddfe7;">
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td width="70%">
                                                        <p
                                                            style="margin: 0; color: #0c0d10; font-size: 14px; font-weight: 600;">
                                                            {{ $item->product_name }}</p>
                                                        <p style="margin: 4px 0 0 0; color: #606266; font-size: 12px;">
                                                            SKU: {{ $item->product_sku }}</p>
                                                    </td>
                                                    <td width="15%" align="center">
                                                        <p style="margin: 0; color: #606266; font-size: 13px;">Qté:
                                                            <strong>{{ $item->quantity }}</strong></p>
                                                    </td>
                                                    <td width="15%" align="right">
                                                        <p
                                                            style="margin: 0; color: #0c0d10; font-size: 14px; font-weight: 600;">
                                                            {{ number_format($item->subtotal, 0, ',', ' ') }}</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>

                    <!-- Shipping Info -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="background-color: #e7eaf6; border-radius: 12px; padding: 24px;">
                                <tr>
                                    <td>
                                        <h3
                                            style="color: #0c0d10; margin: 0 0 16px 0; font-size: 16px; font-weight: 600;">
                                            Informations de livraison</h3>
                                        <p style="margin: 0; color: #0c0d10; font-size: 14px; line-height: 1.6;">
                                            <strong>{{ $order->shipping_name }}</strong><br>
                                            {{ $order->shipping_address }}<br>
                                            {{ $order->shipping_city }}<br>
                                            📱 {{ $order->shipping_phone }}<br>
                                            ✉️ {{ $order->shipping_email }}
                                        </p>
                                        @if ($order->notes)
                                            <div
                                                style="margin-top: 16px; padding: 12px; background-color: #ffffff; border-radius: 8px;">
                                                <p style="margin: 0; color: #606266; font-size: 13px;">
                                                    <strong>Notes:</strong></p>
                                                <p style="margin: 8px 0 0 0; color: #0c0d10; font-size: 13px;">
                                                    {{ $order->notes }}</p>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Action Buttons -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px; text-align: center;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                            style="display: inline-block; background-color: #2725a9; color: #ffffff; text-decoration: none; padding: 16px 32px; border-radius: 12px; font-size: 16px; font-weight: 600; margin: 0 8px;">
                                            Voir la commande
                                        </a>
                                        <a href="{{ route('admin.dashboard') }}"
                                            style="display: inline-block; background-color: #f4f5f7; color: #0c0d10; text-decoration: none; padding: 16px 32px; border-radius: 12px; font-size: 16px; font-weight: 600; margin: 0 8px;">
                                            Dashboard Admin
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Quick Actions -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px;">
                            <div style="background-color: #f3ebf8; border-radius: 12px; padding: 24px;">
                                <h3 style="color: #0c0d10; margin: 0 0 16px 0; font-size: 16px; font-weight: 600;">
                                    Actions rapides</h3>
                                <ul
                                    style="margin: 0; padding-left: 20px; color: #606266; font-size: 14px; line-height: 1.8;">
                                    <li>Vérifier la disponibilité des produits en stock</li>
                                    <li>Préparer les articles pour l'expédition</li>
                                    <li>Contacter le client si nécessaire</li>
                                    <li>Mettre à jour le statut de la commande</li>
                                </ul>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9f5f2; padding: 32px 40px; text-align: center;">
                            <p style="margin: 0; color: #4f5561; font-size: 12px;">
                                Ceci est une notification automatique envoyée à l'équipe administrative<br>
                                © {{ date('Y') }} La Maison P2A - Tous droits réservés
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
