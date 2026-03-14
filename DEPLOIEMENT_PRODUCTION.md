# 🚀 DÉPLOIEMENT PRODUCTION - GUIDE RAPIDE

## 📋 PRÉREQUIS (1 heure)

### 1. Certificat SSL (15 min)
```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d lamaisonp2a.com -d www.lamaisonp2a.com
```

### 2. Récupérer les clés Stripe (10 min)

**Aller sur** : https://dashboard.stripe.com/

**Passer en Mode LIVE** (bouton en haut à droite)

**Récupérer :**
1. **Développeurs → Clés API**
   - Copier : Clé publiable (`pk_live_...`)
   - Copier : Clé secrète (`sk_live_...`)

2. **Développeurs → Webhooks → Ajouter un endpoint**
   - URL : `https://lamaisonp2a.com/stripe/webhook`
   - Événements : `payment_intent.succeeded`, `payment_intent.payment_failed`, `charge.refunded`
   - Cliquer sur "Ajouter"
   - Copier : Secret de signature (`whsec_...`)

---

## 🔧 CONFIGURATION (15 min)

### Étape 1 : Copier le fichier .env
```bash
cp .env.production.ready .env
```

### Étape 2 : Éditer .env
```bash
nano .env
```

### Étape 3 : Remplir les 3 clés Stripe

Chercher la section `STRIPE` et remplir :

```env
# ⬇️ Remplacer ces 3 lignes :
STRIPE_PUBLISHABLE_KEY=pk_live_VOTRE_CLE_PUBLIABLE_ICI
STRIPE_SECRET_KEY=sk_live_VOTRE_CLE_SECRETE_ICI
STRIPE_WEBHOOK_SECRET=whsec_VOTRE_SECRET_WEBHOOK_ICI
```

**Exemple :**
```env
STRIPE_PUBLISHABLE_KEY=pk_live_51ABcdEF...
STRIPE_SECRET_KEY=sk_live_51ABcdEF...
STRIPE_WEBHOOK_SECRET=whsec_1234567890abcdef...
```

### Étape 4 : Générer la clé d'application
```bash
php artisan key:generate
```

### Étape 5 : Sauvegarder et quitter
```
Ctrl + O  # Sauvegarder
Entrée    # Confirmer
Ctrl + X  # Quitter
```

---

## ✅ VÉRIFICATION (5 min)

### Script de vérification automatique
```bash
./check-production-ready.sh
```

**Si tout est vert ✅** → Passez à l'étape suivante
**Si rouge ❌** → Corrigez les erreurs indiquées

---

## 🚀 DÉPLOIEMENT (10 min)

### 1. Optimiser Laravel
```bash
# Nettoyer les caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Optimiser pour la production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Migrations (si besoin)
php artisan migrate --force

# Permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 2. Build des assets
```bash
npm install
npm run build
```

### 3. Redémarrer les services
```bash
# Redémarrer PHP-FPM
sudo systemctl restart php8.4-fpm

# Redémarrer Nginx
sudo systemctl restart nginx

# Lancer la queue (si utilisée)
php artisan queue:restart
```

---

## 🧪 TESTS (20 min)

### Test 1 : Vérifier HTTPS
```bash
# Visiter
https://lamaisonp2a.com

# Vérifier le cadenas vert 🔒
```

### Test 2 : Paiement Stripe
1. Créer une commande de test
2. Aller sur la page de paiement Stripe
3. Utiliser une vraie carte (montant faible : 5€)
4. Vérifier que le paiement réussit
5. Vérifier l'email de confirmation

### Test 3 : Webhook
```bash
# Installer Stripe CLI
brew install stripe/stripe-cli/stripe

# Déclencher un événement test
stripe trigger payment_intent.succeeded
```

**Vérifier les logs :**
```bash
tail -f storage/logs/laravel.log
```

Vous devriez voir :
```
[2026-02-06 ...] production.INFO: Stripe webhook received
```

### Test 4 : 3D Secure
1. Créer une nouvelle commande
2. Utiliser la carte de test 3DS : `4000 0027 6000 3184`
3. Vérifier que la popup 3DS s'affiche
4. Compléter l'authentification
5. Vérifier que le paiement réussit

---

## 📊 SURVEILLANCE (24h)

### Logs en temps réel
```bash
tail -f storage/logs/laravel.log
```

### Dashboard Stripe
Vérifier :
- Les paiements reçus
- Les webhooks envoyés (devrait être 200 OK)
- Les éventuelles erreurs

### Vérifier les emails
- Les clients reçoivent bien les confirmations
- Vous recevez bien les notifications admin

---

## 🆘 EN CAS DE PROBLÈME

### Webhook ne fonctionne pas

**Vérifier dans Stripe Dashboard** :
- Développeurs → Webhooks → Votre endpoint
- Regarder les "Tentatives de livraison"
- Code de réponse : devrait être 200

**Vérifier dans Laravel** :
```bash
# Logs
tail -f storage/logs/laravel.log

# Route existe ?
php artisan route:list | grep stripe

# Config chargée ?
php artisan config:clear && php artisan config:cache
```

### Paiement échoue

**Vérifier :**
1. Les clés Stripe sont bien en mode LIVE
2. HTTPS fonctionne
3. Les logs Laravel pour les erreurs

### Erreur 500

**Vérifier :**
```bash
# Logs
tail -f storage/logs/laravel.log

# Permissions
ls -la storage
ls -la bootstrap/cache
```

---

## 🔄 ROLLBACK (Si problème critique)

### Revenir en mode test
```bash
# 1. Éditer .env
nano .env

# 2. Changer les clés Stripe en mode test
STRIPE_PUBLISHABLE_KEY=pk_test_...
STRIPE_SECRET_KEY=sk_test_...

# 3. Nettoyer cache
php artisan config:clear
php artisan cache:clear

# 4. Redémarrer
sudo systemctl restart php8.4-fpm
```

---

## 📋 CHECKLIST FINALE

Avant de déclarer "PRODUCTION READY" :

- [ ] ✅ SSL installé et HTTPS fonctionne
- [ ] ✅ .env configuré avec clés LIVE
- [ ] ✅ APP_ENV=production
- [ ] ✅ APP_DEBUG=false
- [ ] ✅ APP_KEY généré
- [ ] ✅ Webhook créé dans Stripe
- [ ] ✅ Secret webhook configuré
- [ ] ✅ Script check-production-ready.sh passe
- [ ] ✅ Paiement test réussi avec vraie carte
- [ ] ✅ Webhook test réussi
- [ ] ✅ 3D Secure testé
- [ ] ✅ Email de confirmation reçu
- [ ] ✅ Dashboard Stripe montre 200 OK
- [ ] ✅ Logs Laravel sans erreur
- [ ] ✅ Backups configurés

---

## 🎉 FÉLICITATIONS !

Votre site est maintenant en production avec Stripe activé !

**Surveillez pendant 24-48h et tout devrait bien se passer.**

---

## 📞 SUPPORT

- **Stripe** : https://support.stripe.com/
- **Laravel** : https://laravel.com/docs
- **Logs** : `storage/logs/laravel.log`

---

## 💡 CONSEILS POST-PRODUCTION

### Monitoring
- Installer Sentry pour les erreurs : https://sentry.io/
- Configurer des alertes email pour les paiements échoués
- Surveiller les logs quotidiennement

### Backups
```bash
# Backup base de données quotidien
0 2 * * * mysqldump -u root -p lamaisonp2a_prod > /backups/db-$(date +\%Y\%m\%d).sql
```

### Mises à jour
```bash
# Mettre à jour Laravel et dépendances régulièrement
composer update
php artisan migrate --force
```

### Performance
```bash
# Optimiser Laravel
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

**C'est tout ! Bon déploiement ! 🚀**
