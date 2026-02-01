# Integration Stripe - La Maison P2A

## Vue d'ensemble

L'intégration Stripe permet aux clients de payer par carte bancaire (Visa, Mastercard, Amex) en complément du paiement FedaPay (Mobile Money pour l'Afrique de l'Ouest). L'implémentation utilise **Stripe Payment Elements** pour une expérience de paiement moderne et sécurisée.

## Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                         FRONTEND                                 │
│  resources/views/public/payment/stripe.blade.php                │
│  - Stripe.js v3                                                  │
│  - Payment Element (formulaire de carte dynamique)              │
│  - Gestion des erreurs et états de chargement                   │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                       CONTROLLER                                 │
│  App\Http\Controllers\StripePaymentController                   │
│  - show()        : Affiche la page de paiement                  │
│  - createIntent(): Crée un PaymentIntent via AJAX               │
│  - callback()    : Gère le retour après paiement                │
│  - webhook()     : Reçoit les événements Stripe                 │
│  - success()     : Page de succès                               │
│  - failed()      : Page d'échec                                 │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                         SERVICE                                  │
│  App\Services\StripeService                                      │
│  - createPaymentIntent()       : Crée un intent Stripe          │
│  - getOrCreatePaymentIntent()  : Récupère ou crée un intent     │
│  - retrievePaymentIntent()     : Récupère un intent existant    │
│  - confirmPaymentSuccess()     : Vérifie le statut du paiement  │
│  - verifyWebhookSignature()    : Valide les webhooks            │
│  - cancelPaymentIntent()       : Annule un intent               │
│  - createRefund()              : Crée un remboursement          │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                       BASE DE DONNÉES                            │
│  orders table                                                    │
│  - stripe_payment_intent_id : ID du PaymentIntent Stripe        │
│  - payment_method           : 'stripe' ou 'fedapay'             │
│  - payment_status           : 'pending', 'paid', 'refunded'     │
│  - transaction_id           : ID de transaction après paiement  │
└─────────────────────────────────────────────────────────────────┘
```

## Fichiers de l'intégration

| Fichier | Description |
|---------|-------------|
| `app/Services/StripeService.php` | Service encapsulant l'API Stripe |
| `app/Http/Controllers/StripePaymentController.php` | Contrôleur des routes de paiement |
| `resources/views/public/payment/stripe.blade.php` | Vue du formulaire de paiement |
| `database/migrations/..._add_stripe_payment_intent_id_to_orders_table.php` | Migration pour le champ `stripe_payment_intent_id` |
| `config/services.php` | Configuration des clés Stripe |
| `routes/web.php` | Routes Stripe (lignes 111-116 + webhook ligne 65) |

## Routes

| Route | Méthode | Nom | Description |
|-------|---------|-----|-------------|
| `/stripe/payment/{order}` | GET | `stripe.show` | Page de paiement Stripe |
| `/stripe/payment/{order}/intent` | POST | `stripe.intent` | Création PaymentIntent (AJAX) |
| `/stripe/payment/{order}/callback` | GET | `stripe.callback` | Retour après paiement |
| `/stripe/payment/{order}/success` | GET | `stripe.success` | Page de confirmation |
| `/stripe/payment/{order}/failed` | GET | `stripe.failed` | Page d'échec |
| `/stripe/webhook` | POST | `stripe.webhook` | Endpoint webhook Stripe |

## Configuration

### Variables d'environnement

Ajouter dans `.env` :

```env
# Stripe (Card Payments)
STRIPE_PUBLISHABLE_KEY=pk_test_xxxxxxxxxxxxxxxxxxxx
STRIPE_SECRET_KEY=sk_test_xxxxxxxxxxxxxxxxxxxx
STRIPE_CURRENCY=eur
STRIPE_WEBHOOK_SECRET=whsec_xxxxxxxxxxxxxxxxxxxx
```

### Obtenir les clés Stripe

1. Créer un compte sur [Stripe Dashboard](https://dashboard.stripe.com)
2. Aller dans **Developers > API keys**
3. Copier la **Publishable key** (`pk_test_...` ou `pk_live_...`)
4. Copier la **Secret key** (`sk_test_...` ou `sk_live_...`)

### Configurer le Webhook

1. Dans le Dashboard Stripe, aller à **Developers > Webhooks**
2. Cliquer **Add endpoint**
3. URL : `https://votre-domaine.com/stripe/webhook`
4. Sélectionner les événements :
   - `payment_intent.succeeded`
   - `payment_intent.payment_failed`
   - `charge.refunded`
5. Copier le **Signing secret** (`whsec_...`) dans `STRIPE_WEBHOOK_SECRET`

## Flux de paiement

```
1. Client → Checkout → Commande créée (payment_status: pending)
                          │
2. Client choisit "Payer par carte"
                          │
3. GET /stripe/payment/{order}
   └── StripeService::getOrCreatePaymentIntent()
       └── Stripe API: PaymentIntent.create()
           └── Retourne client_secret
                          │
4. Affichage du Payment Element Stripe.js
                          │
5. Client remplit le formulaire → Soumet
   └── stripe.confirmPayment()
       └── Redirection 3D Secure si nécessaire
                          │
6. GET /stripe/payment/{order}/callback?payment_intent=pi_xxx
   └── Vérifie le statut du PaymentIntent
       ├── succeeded → Marque la commande payée + email
       ├── processing → Message "en cours"
       └── failed → Redirection page d'échec
                          │
7. Webhook (en parallèle) : Confirmation asynchrone
   └── Garantit la mise à jour même si callback échoue
```

## Gestion des devises

Le service gère automatiquement la conversion pour les devises sans décimales (XOF, XAF, JPY, etc.) :

```php
// Pour EUR : 25.50€ → 2550 centimes
// Pour XOF : 15000 XOF → 15000 (pas de conversion)
private function convertToSmallestUnit(float $amount): int
```

## Sécurité

- **Vérification du propriétaire** : Chaque action vérifie `$order->user_id === auth()->id()`
- **Webhook signature** : Les webhooks sont validés avec HMAC-SHA256
- **Pas de données sensibles** : Les numéros de carte ne transitent jamais par le serveur
- **PCI DSS** : Conformité assurée par Stripe.js

## Tests en mode Sandbox

### Cartes de test

| Numéro | Comportement |
|--------|--------------|
| `4242 4242 4242 4242` | Paiement réussi |
| `4000 0000 0000 3220` | 3D Secure requis |
| `4000 0000 0000 9995` | Paiement refusé |
| `4000 0000 0000 0002` | Carte refusée (générique) |

- **Date d'expiration** : N'importe quelle date future (ex: 12/34)
- **CVC** : N'importe quel code à 3 chiffres (ex: 123)

### Tester localement les webhooks

Utiliser le CLI Stripe :

```bash
# Installer le CLI Stripe
# macOS
brew install stripe/stripe-cli/stripe

# Linux
curl -s https://packages.stripe.dev/api/security/keypair/stripe-cli-gpg/public | gpg --dearmor | sudo tee /usr/share/keyrings/stripe.gpg
echo "deb [signed-by=/usr/share/keyrings/stripe.gpg] https://packages.stripe.dev/stripe-cli-debian-local stable main" | sudo tee /etc/apt/sources.list.d/stripe.list
sudo apt update && sudo apt install stripe

# Authentification
stripe login

# Forwarder les webhooks vers votre serveur local
stripe listen --forward-to localhost:8000/stripe/webhook
```

Le CLI affichera un webhook secret temporaire (`whsec_...`) à utiliser dans `.env`.

---

## Avant de tester

### Checklist de configuration

- [ ] Clés Stripe configurées dans `.env`
- [ ] Migration exécutée : `php artisan migrate`
- [ ] Serveur démarré : `composer dev`
- [ ] (Optionnel) CLI Stripe pour les webhooks locaux

### Exécuter la migration

```bash
php artisan migrate
```

### Tester le flux complet

1. Ajouter un produit au panier
2. Passer à la caisse (checkout)
3. Remplir les informations de livraison
4. Sur la page de paiement, cliquer "Payer par carte"
5. Utiliser la carte test `4242 4242 4242 4242`
6. Vérifier la confirmation de commande

---

## Traductions

Les textes sont dans les fichiers de traduction :
- `lang/fr/payment.php`
- `lang/en/payment.php`

Clés utilisées :
- `payment.stripe_title`
- `payment.stripe_payment`
- `payment.secure_stripe`
- `payment.ssl_encrypted`
- `payment.pci_compliant`
- `payment.prefer_mobile_money`
- `payment.pay_with_fedapay`
- `payment.stripe_init_error`
- `payment.unexpected_error`

---

## Passage en production

1. Remplacer les clés test (`pk_test_`, `sk_test_`) par les clés live (`pk_live_`, `sk_live_`)
2. Configurer le webhook de production dans le Dashboard Stripe
3. Mettre à jour `STRIPE_WEBHOOK_SECRET` avec le nouveau signing secret
4. Tester avec une vraie carte (petits montants)
5. Activer les notifications email dans Stripe Dashboard

---

## Dépendances

```json
{
  "stripe/stripe-php": "^19.3"
}
```

Installé via : `composer require stripe/stripe-php`
