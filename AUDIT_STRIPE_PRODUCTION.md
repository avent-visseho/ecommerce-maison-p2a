# 🔒 AUDIT DE SECURITE STRIPE - PRODUCTION READY

## 📊 SCORE GLOBAL : 6.5/10

### ✅ Points Forts
- Aucune clé commitée dans Git ✓
- Code PHP sécurisé ✓
- Gestion des webhooks correcte ✓
- Protection CSRF implémentée ✓
- Logs sécurisés (pas de données sensibles) ✓
- Dépendances à jour ✓

### ⚠️ Points Critiques à Corriger AVANT Production
1. 🚨 **HTTPS non forcé** (CRITIQUE)
2. 🚨 **Variables d'environnement en mode dev** (CRITIQUE)
3. ⚠️ **Webhook secret non configuré** (IMPORTANT)
4. ⚠️ **Pas de rate limiting** (IMPORTANT)

---

## 🚨 PROBLEMES CRITIQUES

### 1. HTTPS NON FORCE (CRITIQUE)

**Problème** :
- Aucune configuration pour forcer HTTPS
- APP_URL en HTTP : `http://lamaisonp2a.com/`
- Pas de redirection automatique vers HTTPS

**Impact** :
- ❌ Webhooks Stripe REQUI

ÈRENT HTTPS (ne fonctionneront PAS)
- ❌ Clés API transmises en clair (risque d'interception)
- ❌ Payment intents vulnérables
- ❌ Violation PCI-DSS

**Solution** :
```bash
# 1. Installer certificat SSL (Let's Encrypt gratuit)
sudo certbot --nginx -d lamaisonp2a.com -d www.lamaisonp2a.com

# 2. Forcer HTTPS dans Laravel
```

### 2. VARIABLES D'ENVIRONNEMENT (CRITIQUE)

**Problème Actuel (.env)** :
```env
APP_ENV=local          # ❌ Devrait être production
APP_DEBUG=true         # ❌ Devrait être false
APP_URL=http://...     # ❌ Devrait être https://
```

**Impact** :
- Mode debug expose le code source, les variables, les requêtes SQL
- Erreurs détaillées visibles par les utilisateurs
- Informations sensibles exposées

**Solution (.env production)** :
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://lamaisonp2a.com
```

### 3. WEBHOOK SECRET NON CONFIGURE (IMPORTANT)

**Problème Actuel** :
```env
STRIPE_WEBHOOK_SECRET=whsec_xxxxxxxxxxxxxxxxxxxx  # ❌ Placeholder
```

**Impact** :
- Webhooks non vérifiés = vulnérabilité à l'injection de faux événements
- Quelqu'un pourrait envoyer de faux webhooks "payment_intent.succeeded"
- Commandes marquées comme payées sans paiement réel

**Solution** :
1. Créer le webhook dans Stripe Dashboard
2. Récupérer le vrai secret
3. Mettre à jour .env

---

## ✅ CHECKLIST PRODUCTION (ÉTAPE PAR ÉTAPE)

### PHASE 1 : Configuration SSL/HTTPS (OBLIGATOIRE)

```bash
# 1. Installer Let's Encrypt
sudo apt install certbot python3-certbot-nginx

# 2. Obtenir le certificat
sudo certbot --nginx -d lamaisonp2a.com -d www.lamaisonp2a.com

# 3. Vérifier le renouvellement automatique
sudo certbot renew --dry-run
```

**Modifier AppServiceProvider** :

```php
// app/Providers/AppServiceProvider.php
use Illuminate\Support\Facades\URL;

public function boot(): void
{
    if ($this->app->environment('production')) {
        URL::forceScheme('https');
    }
}
```

**Mettre à jour .env** :
```env
APP_URL=https://lamaisonp2a.com
```

### PHASE 2 : Remplacer les Clés Stripe (OBLIGATOIRE)

**1. Récupérer les clés de production** :
- Aller sur https://dashboard.stripe.com/
- Mode LIVE (pas TEST)
- Développeurs > Clés API
- Copier :
  - Clé publiable (pk_live_...)
  - Clé secrète (sk_live_...)

**2. Mettre à jour .env** :
```env
STRIPE_PUBLISHABLE_KEY=pk_live_VOTRE_CLE_ICI
STRIPE_SECRET_KEY=sk_live_VOTRE_CLE_ICI
STRIPE_CURRENCY=eur
```

⚠️ **ATTENTION** : Ne JAMAIS committer ce fichier .env !

### PHASE 3 : Configurer le Webhook Stripe (OBLIGATOIRE)

**1. Dans le Dashboard Stripe** :
- Aller sur Développeurs > Webhooks
- Cliquer sur "Ajouter un endpoint"
- URL : `https://lamaisonp2a.com/stripe/webhook`
- Sélectionner les événements :
  - `payment_intent.succeeded`
  - `payment_intent.payment_failed`
  - `charge.refunded`
- Enregistrer

**2. Récupérer le secret** :
- Cliquer sur le webhook créé
- Cliquer sur "Révéler" le secret
- Copier : `whsec_...`

**3. Mettre à jour .env** :
```env
STRIPE_WEBHOOK_SECRET=whsec_VOTRE_SECRET_ICI
```

**4. Tester le webhook** :
```bash
# Installer Stripe CLI
brew install stripe/stripe-cli/stripe

# Se connecter
stripe login

# Tester le webhook
stripe trigger payment_intent.succeeded

# Vérifier les logs Laravel
tail -f storage/logs/laravel.log
```

### PHASE 4 : Variables d'Environnement (OBLIGATOIRE)

**Mettre à jour .env de production** :
```env
APP_NAME="La Maison P2A"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://lamaisonp2a.com

# Base de données (vérifier les credentials)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=votre_db_production
DB_USERNAME=votre_user_prod
DB_PASSWORD=MOT_DE_PASSE_FORT

# Stripe Production
STRIPE_PUBLISHABLE_KEY=pk_live_...
STRIPE_SECRET_KEY=sk_live_...
STRIPE_CURRENCY=eur
STRIPE_WEBHOOK_SECRET=whsec_...
```

### PHASE 5 : Sécurité Additionnelle (RECOMMANDÉ)

**1. Ajouter Rate Limiting sur les routes sensibles** :

```php
// routes/web.php
Route::post('/stripe/webhook', [StripePaymentController::class, 'webhook'])
    ->middleware('throttle:60,1')
    ->name('stripe.webhook');
```

**2. Configurer TrustProxies** (si Nginx/Load Balancer) :

```php
// bootstrap/app.php
use Illuminate\Http\Middleware\TrustProxies;

->withMiddleware(function (Middleware $middleware) {
    $middleware->trustProxies(at: '*');
})
```

**3. Supprimer les console.log en production** :

```javascript
// resources/views/public/payment/stripe.blade.php
// Entourer les console.log avec :
@if(config('app.debug'))
    console.log('Payment Element ready');
@endif
```

**4. Configurer la rotation des logs** :

```php
// config/logging.php
'daily' => [
    'driver' => 'daily',
    'path' => storage_path('logs/laravel.log'),
    'level' => 'debug',
    'days' => 14, // Garder 14 jours de logs
],
```

### PHASE 6 : Tests Avant Production (OBLIGATOIRE)

**1. Tester avec les clés de test** :
```bash
# Mode test avec pk_test_ et sk_test_
php artisan test --filter=StripePayment
```

**2. Tester un paiement complet** :
- Créer une commande
- Aller sur la page de paiement Stripe
- Utiliser carte de test : `4242 4242 4242 4242`
- Vérifier que le paiement réussit
- Vérifier l'email de confirmation
- Vérifier le statut dans le dashboard admin

**3. Tester le webhook** :
```bash
# Avec Stripe CLI
stripe trigger payment_intent.succeeded
stripe trigger payment_intent.payment_failed
stripe trigger charge.refunded

# Vérifier les logs
tail -f storage/logs/laravel.log
```

**4. Tester 3D Secure** :
- Carte de test 3DS : `4000 0027 6000 3184`
- Vérifier que la popup 3DS s'affiche
- Valider avec le code
- Vérifier que le paiement réussit

### PHASE 7 : Déploiement Production (ÉTAPES FINALES)

**1. Sauvegarder la base de données** :
```bash
php artisan backup:run
# ou
mysqldump -u root -p votre_db > backup_avant_prod.sql
```

**2. Mettre en mode maintenance** :
```bash
php artisan down --secret="token-secret-123"
```

**3. Remplacer les clés .env** :
```bash
# Éditer .env avec les clés de production
nano .env

# Vérifier
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

**4. Tester une dernière fois** :
- Visiter https://lamaisonp2a.com
- Vérifier que HTTPS fonctionne (cadenas vert)
- Faire un paiement test avec une vraie carte (petit montant)
- Vérifier que le webhook est reçu
- Vérifier l'email de confirmation

**5. Sortir du mode maintenance** :
```bash
php artisan up
```

**6. Surveiller les logs** :
```bash
tail -f storage/logs/laravel.log
```

---

## 📋 CHECKLIST FINALE

### Avant de Passer en Production

- [ ] ✅ Certificat SSL installé et fonctionnel
- [ ] ✅ HTTPS forcé dans AppServiceProvider
- [ ] ✅ APP_URL en HTTPS dans .env
- [ ] ✅ APP_ENV=production
- [ ] ✅ APP_DEBUG=false
- [ ] ✅ Clés Stripe remplacées par clés LIVE
- [ ] ✅ STRIPE_PUBLISHABLE_KEY=pk_live_...
- [ ] ✅ STRIPE_SECRET_KEY=sk_live_...
- [ ] ✅ Webhook créé dans Stripe Dashboard
- [ ] ✅ STRIPE_WEBHOOK_SECRET configuré
- [ ] ✅ Webhook testé avec Stripe CLI
- [ ] ✅ Rate limiting ajouté
- [ ] ✅ TrustProxies configuré (si proxy)
- [ ] ✅ console.log supprimés ou conditionnés
- [ ] ✅ Rotation des logs configurée
- [ ] ✅ Tests complets effectués
- [ ] ✅ Paiement test réussi avec vraie carte
- [ ] ✅ 3D Secure testé
- [ ] ✅ Emails de confirmation testés
- [ ] ✅ Backup de la base de données

### Surveillance Post-Production

- [ ] Vérifier les logs pendant 24h
- [ ] Surveiller les paiements échoués
- [ ] Vérifier les emails de confirmation
- [ ] Tester les remboursements
- [ ] Monitorer les webhooks dans Stripe Dashboard

---

## 🚨 RÉPONSE À VOTRE QUESTION

**"Si je remplace les clés test par les clés prod, tout va marcher ?"**

**NON ! ❌** Il faut AUSSI :

1. **Forcer HTTPS** (sinon webhooks ne marcheront pas)
2. **Configurer le webhook secret** (sinon vulnérabilité)
3. **Changer APP_ENV et APP_DEBUG** (sinon failles de sécurité)
4. **Créer le webhook dans Stripe** (sinon pas de confirmation auto)

**OUI ✅** si vous suivez TOUTES les étapes de ce document.

---

## ⚠️ ERREURS COURANTES À ÉVITER

1. ❌ Oublier de forcer HTTPS → Webhooks échouent
2. ❌ Ne pas configurer le webhook secret → Faille de sécurité
3. ❌ Laisser APP_DEBUG=true → Exposition de données
4. ❌ Ne pas tester le webhook → Commandes pas confirmées
5. ❌ Oublier de tester 3D Secure → Paiements échouent
6. ❌ Ne pas surveiller les logs → Problèmes non détectés

---

## 📞 SUPPORT STRIPE

En cas de problème :
- Support Stripe : https://support.stripe.com/
- Documentation : https://stripe.com/docs
- Status : https://status.stripe.com/

---

## 🎯 CONCLUSION

**Votre intégration est BONNE mais PAS PRÊTE pour la production.**

**Actions OBLIGATOIRES** :
1. Forcer HTTPS (30 min)
2. Configurer les variables d'environnement (5 min)
3. Remplacer les clés Stripe (2 min)
4. Configurer le webhook (10 min)
5. Tester tout (1h)

**TOTAL : ~2h de travail**

Une fois ces étapes complétées, votre intégration sera **100% sécurisée et production-ready** ✅
