<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('emails.order_confirmation.title') }}</title>
</head>

<body
    style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f0f0f0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f0f0f0; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);">
                    <!-- Header -->
                    <tr>
                        <td
                            style="background: linear-gradient(135deg, #e8bf5e 0%, #a05e18 100%); padding: 40px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: bold;">{{ __('emails.order_confirmation.title') }}
                            </h1>
                            <p style="color: #fde788; margin: 10px 0 0 0; font-size: 14px;">{{ __('emails.order_confirmation.subtitle') }}</p>
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
                            <h2 style="color: #000000; margin: 0 0 12px 0; font-size: 24px; font-weight: bold;">{{ __('emails.order_confirmation.thank_you') }}</h2>
                            <p style="color: #40464b; margin: 0; font-size: 16px; line-height: 1.6;">
                                {{ __('emails.order_confirmation.hello') }} <strong>{{ $order->shipping_name }}</strong>,<br>
                                {{ __('emails.order_confirmation.order_received') }}
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
                                            style="color: #000000; margin: 0 0 16px 0; font-size: 18px; font-weight: 600;">
                                            {{ __('emails.order_confirmation.order_details') }}</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 12px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="color: #40464b; font-size: 14px; padding-bottom: 8px;">{{ __('emails.order_confirmation.order_number') }}:</td>
                                                <td align="right"
                                                    style="color: #000000; font-size: 14px; font-weight: 600; padding-bottom: 8px;">
                                                    {{ $order->order_number }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #40464b; font-size: 14px; padding-bottom: 8px;">{{ __('emails.order_confirmation.date') }}:
                                                </td>
                                                <td align="right"
                                                    style="color: #000000; font-size: 14px; font-weight: 600; padding-bottom: 8px;">
                                                    {{ $order->created_at->format('d/m/Y') }} {{ __('emails.order_confirmation.at') }} {{ $order->created_at->format('H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #40464b; font-size: 14px;">{{ __('emails.order_confirmation.total') }}:</td>
                                                <td align="right"
                                                    style="color: #e8bf5e; font-size: 18px; font-weight: bold;">
                                                    {{ number_format($order->total, 0, ',', ' ') }} €</td>
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
                            <h3 style="color: #000000; margin: 0 0 20px 0; font-size: 18px; font-weight: 600;">{{ __('emails.order_confirmation.ordered_items') }}</h3>
                            <table width="100%" cellpadding="0" cellspacing="0">
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td style="padding: 16px 0; border-bottom: 1px solid #d0d0d0;">
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td width="80%">
                                                        <p
                                                            style="margin: 0; color: #000000; font-size: 14px; font-weight: 600;">
                                                            {{ $item->product_name }}</p>
                                                        <p style="margin: 4px 0 0 0; color: #40464b; font-size: 13px;">
                                                            {{ __('emails.order_confirmation.quantity') }}: {{ $item->quantity }} ×
                                                            {{ number_format($item->price, 0, ',', ' ') }} €</p>
                                                    </td>
                                                    <td width="20%" align="right">
                                                        <p
                                                            style="margin: 0; color: #000000; font-size: 14px; font-weight: 600;">
                                                            {{ number_format($item->subtotal, 0, ',', ' ') }} €</p>
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
                                    <td style="padding: 8px 0; color: #40464b; font-size: 14px;">{{ __('emails.order_confirmation.subtotal') }}</td>
                                    <td align="right"
                                        style="padding: 8px 0; color: #000000; font-size: 14px; font-weight: 600;">
                                        {{ number_format($order->subtotal, 0, ',', ' ') }} €</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color: #40464b; font-size: 14px;">{{ __('emails.order_confirmation.shipping') }}</td>
                                    <td align="right"
                                        style="padding: 8px 0; color: #000000; font-size: 14px; font-weight: 600;">
                                        {{ number_format($order->shipping, 0, ',', ' ') }} €</td>
                                </tr>
                                <tr style="border-top: 2px solid #d0d0d0;">
                                    <td
                                        style="padding: 16px 0 0 0; color: #000000; font-size: 16px; font-weight: bold;">
                                        {{ __('emails.order_confirmation.total') }}</td>
                                    <td align="right"
                                        style="padding: 16px 0 0 0; color: #e8bf5e; font-size: 20px; font-weight: bold;">
                                        {{ number_format($order->total, 0, ',', ' ') }} €</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Shipping Address -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="background-color: #fde788; border-radius: 12px; padding: 24px;">
                                <tr>
                                    <td>
                                        <h3
                                            style="color: #000000; margin: 0 0 16px 0; font-size: 16px; font-weight: 600;">
                                            {{ __('emails.order_confirmation.shipping_address') }}</h3>
                                        <p style="margin: 0; color: #000000; font-size: 14px; line-height: 1.6;">
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
                                style="background-color: #fef9ec; border-left: 4px solid #e8bf5e; border-radius: 8px; padding: 20px;">
                                <h3 style="color: #000000; margin: 0 0 12px 0; font-size: 16px; font-weight: 600;">
                                    {{ __('emails.order_confirmation.next_steps') }}</h3>
                                <ul
                                    style="margin: 0; padding-left: 20px; color: #40464b; font-size: 14px; line-height: 1.8;">
                                    <li>{{ __('emails.order_confirmation.preparing_order') }}</li>
                                    <li>{{ __('emails.order_confirmation.shipping_confirmation') }}</li>
                                    <li>{{ __('emails.order_confirmation.estimated_delivery') }}</li>
                                    <li>{{ __('emails.order_confirmation.track_order') }}</li>
                                </ul>
                            </div>
                        </td>
                    </tr>

                    <!-- CTA Button -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px; text-align: center;">
                            <a href="{{ route('client.orders.show', $order) }}"
                                style="display: inline-block; background-color: #e8bf5e; color: #ffffff; text-decoration: none; padding: 16px 32px; border-radius: 12px; font-size: 16px; font-weight: 600;">
                                {{ __('emails.order_confirmation.track_my_order') }}
                            </a>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9f5f2; padding: 32px 40px; text-align: center;">
                            <p style="margin: 0 0 16px 0; color: #606266; font-size: 14px;">
                                {{ __('emails.order_confirmation.need_help') }}
                            </p>
                            <p style="margin: 0; color: #2725a9; font-size: 14px; font-weight: 600;">
                                Lamaisonp2a@outlook.com | +229 01 90 01 68 79
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
                                © {{ date('Y') }} La Maison P2A. {{ __('emails.order_confirmation.all_rights_reserved') }}.<br>
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
