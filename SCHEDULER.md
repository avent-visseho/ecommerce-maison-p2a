# Configuration du Scheduler Laravel - Articles Planifiés

## 🎯 Objectif

Ce guide explique comment configurer le scheduler Laravel pour que vos articles planifiés soient automatiquement publiés à l'heure programmée.

## ✅ Ce qui a été fait

1. **Commande créée** : `blog:publish-scheduled`
   - Vérifie les articles avec statut "planifié" dont la date est passée
   - Les publie automatiquement
   - Envoie la newsletter aux abonnés

2. **Scheduler configuré** : La commande s'exécute automatiquement toutes les 5 minutes

## 🚀 Comment Démarrer le Scheduler

### Option 1 : Mode Développement (Recommandé pour tester)

Ouvrez un nouveau terminal et exécutez :

```bash
php artisan schedule:work
```

Cette commande démarre le scheduler en mode développement. Il vérifiera toutes les minutes s'il y a des tâches à exécuter.

**Avantages :**
- ✅ Simple et rapide
- ✅ Parfait pour le développement local
- ✅ Vous voyez les logs en temps réel

**Inconvénient :**
- ⚠️ S'arrête quand vous fermez le terminal
- ⚠️ Pas adapté pour la production

---

### Option 2 : Cron (Pour la Production)

#### Sur Linux/Mac

1. Ouvrez le crontab :
```bash
crontab -e
```

2. Ajoutez cette ligne à la fin du fichier :
```bash
* * * * * cd /home/avent/djob/laravel/ecommerce-la-maison-p2a && php artisan schedule:run >> /dev/null 2>&1
```

3. Sauvegardez et fermez (Ctrl+X puis Y puis Entrée)

#### Sur Windows

1. Ouvrez le **Planificateur de tâches**
2. Créez une nouvelle tâche
3. **Déclencheur** : Répéter toutes les 1 minute
4. **Action** : Démarrer un programme
   - Programme : `php`
   - Arguments : `artisan schedule:run`
   - Dossier : `C:\chemin\vers\votre\projet`

---

### Option 3 : Supervisor (Pour la Production - Recommandé)

#### Installation de Supervisor

```bash
sudo apt-get install supervisor
```

#### Configuration

Créez un fichier `/etc/supervisor/conf.d/laravel-scheduler.conf` :

```ini
[program:laravel-scheduler]
process_name=%(program_name)s
command=php /home/avent/djob/laravel/ecommerce-la-maison-p2a/artisan schedule:work
autostart=true
autorestart=true
user=avent
redirect_stderr=true
stdout_logfile=/home/avent/djob/laravel/ecommerce-la-maison-p2a/storage/logs/scheduler.log
```

Rechargez Supervisor :

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-scheduler
```

---

## 🧪 Tester la Publication Automatique

### 1. Créer un Article Planifié de Test

1. Allez dans **Admin** > **Blog** > **Articles** > **Nouveau**
2. Remplissez le formulaire
3. **Statut** : Sélectionnez "Planifié"
4. **Date de publication planifiée** : Réglez sur dans 2-3 minutes
5. Cliquez sur **"Créer l'article"**

### 2. Démarrer le Scheduler

Dans un terminal :
```bash
php artisan schedule:work
```

### 3. Attendre et Vérifier

Après que la date programmée soit passée (attendre 5 minutes max), vérifiez :

```bash
php artisan blog:publish-scheduled
```

Vous devriez voir :
```
Vérification des articles planifiés...
✓ Article publié : Votre Titre
  → Newsletter envoyée à X abonné(s)
✓ 1 article(s) publié(s) avec succès.
```

### 4. Vérifier dans l'Admin

Allez dans **Admin** > **Blog** > **Articles** et vérifiez que le statut de votre article est maintenant **"Publié"**.

---

## 📋 Commandes Utiles

### Publier Manuellement les Articles Planifiés

Si vous ne voulez pas attendre le scheduler :

```bash
php artisan blog:publish-scheduled
```

### Voir les Tâches Planifiées

```bash
php artisan schedule:list
```

Vous devriez voir :
```
  0 */5 * * * *  blog:publish-scheduled ..... Next Due: X minutes from now
```

### Tester le Scheduler

Pour voir ce que le scheduler exécuterait sans réellement l'exécuter :

```bash
php artisan schedule:test
```

---

## 🔍 Dépannage

### Les Articles ne se Publient Pas

**Vérification 1 : Le scheduler tourne-t-il ?**

```bash
ps aux | grep "schedule:work"
```

Si rien n'apparaît, le scheduler n'est pas démarré.

**Vérification 2 : Y a-t-il des articles à publier ?**

```bash
php artisan blog:publish-scheduled
```

**Vérification 3 : Vérifier les logs**

```bash
tail -f storage/logs/laravel.log
```

### Erreur "Command not found"

Assurez-vous d'être dans le bon répertoire :

```bash
cd /home/avent/djob/laravel/ecommerce-la-maison-p2a
php artisan blog:publish-scheduled
```

### Les Newsletters ne sont pas Envoyées

Vérifiez votre configuration SMTP dans `.env` :

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=votre_username
MAIL_PASSWORD=votre_password
```

Testez l'envoi :

```bash
php artisan tinker
```

```php
Mail::raw('Test', function($msg) {
    $msg->to('test@example.com')->subject('Test');
});
```

---

## 📊 Fréquence de Vérification

Par défaut, la commande `blog:publish-scheduled` s'exécute **toutes les 5 minutes**.

### Modifier la Fréquence

Éditez `bootstrap/app.php` ligne 24 :

```php
// Toutes les 1 minute (plus réactif)
$schedule->command('blog:publish-scheduled')->everyMinute();

// Toutes les 5 minutes (par défaut)
$schedule->command('blog:publish-scheduled')->everyFiveMinutes();

// Toutes les 10 minutes
$schedule->command('blog:publish-scheduled')->everyTenMinutes();

// Toutes les heures
$schedule->command('blog:publish-scheduled')->hourly();
```

---

## 🎓 Recommandations

### Développement Local
- Utilisez `php artisan schedule:work` dans un terminal dédié
- Réglez la fréquence sur `everyMinute()` pour des tests plus rapides

### Production
- Utilisez un cron job ou Supervisor
- Gardez la fréquence à `everyFiveMinutes()` pour économiser les ressources
- Surveillez les logs dans `storage/logs/laravel.log`

---

## 📝 Résumé Rapide

**Pour démarrer maintenant (développement) :**

```bash
# Terminal 1 : Votre serveur Laravel
php artisan serve

# Terminal 2 : Le scheduler
php artisan schedule:work
```

C'est tout ! Vos articles planifiés seront maintenant publiés automatiquement. 🚀
