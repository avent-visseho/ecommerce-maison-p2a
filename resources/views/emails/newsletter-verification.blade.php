<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('emails.newsletter_verification.title') }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #2725a9; color: white; padding: 20px; text-align: center;">
        <h1 style="margin: 0;">{{ __('emails.newsletter_verification.title') }}</h1>
        <p style="margin: 5px 0 0 0;">{{ __('emails.newsletter_verification.subtitle') }}</p>
    </div>

    <div style="background-color: #f4f4f4; padding: 30px; margin-top: 20px;">
        <h2 style="color: #2725a9;">{{ __('emails.newsletter_verification.confirm_subscription') }}</h2>

        <p>{{ __('emails.newsletter_verification.hello') }},</p>

        <p>{{ __('emails.newsletter_verification.thanks_subscription') }}</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('newsletter.verify', $newsletter->token) }}"
               style="background-color: #2725a9; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block;">
                {{ __('emails.newsletter_verification.verify_email') }}
            </a>
        </div>

        <p>{{ __('emails.newsletter_verification.no_request_notice') }}</p>

        <p>{{ __('emails.newsletter_verification.regards') }},<br>{{ __('emails.newsletter_verification.team') }}</p>
    </div>

    <div style="text-align: center; margin-top: 20px; padding: 20px; font-size: 12px; color: #666;">
        <p>&copy; {{ date('Y') }} La Maison P2A. {{ __('emails.newsletter_verification.all_rights_reserved') }}.</p>
    </div>
</body>
</html>
