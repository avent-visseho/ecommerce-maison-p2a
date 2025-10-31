<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification Newsletter</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #2725a9; color: white; padding: 20px; text-align: center;">
        <h1 style="margin: 0;">La Maison P2A</h1>
        <p style="margin: 5px 0 0 0;">Blog</p>
    </div>

    <div style="background-color: #f4f4f4; padding: 30px; margin-top: 20px;">
        <h2 style="color: #2725a9;">Confirmez votre inscription</h2>

        <p>Bonjour,</p>

        <p>Merci de vous être inscrit à notre newsletter ! Pour recevoir nos derniers articles de blog, veuillez confirmer votre adresse email en cliquant sur le bouton ci-dessous :</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('newsletter.verify', $newsletter->token) }}"
               style="background-color: #2725a9; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block;">
                Vérifier mon email
            </a>
        </div>

        <p>Si vous n'avez pas demandé cette inscription, vous pouvez ignorer cet email.</p>

        <p>Cordialement,<br>L'équipe La Maison P2A</p>
    </div>

    <div style="text-align: center; margin-top: 20px; padding: 20px; font-size: 12px; color: #666;">
        <p>&copy; {{ date('Y') }} La Maison P2A. Tous droits réservés.</p>
    </div>
</body>
</html>
