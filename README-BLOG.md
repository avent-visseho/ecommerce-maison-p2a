# Guide de Démarrage Rapide - Blog La Maison P2A

## Table des Matières
1. [Installation](#installation)
2. [Première Configuration](#première-configuration)
3. [Accès à l'Administration](#accès-à-ladministration)
4. [Créer votre Premier Article](#créer-votre-premier-article)
5. [Gérer les Catégories et Tags](#gérer-les-catégories-et-tags)
6. [Modération des Commentaires](#modération-des-commentaires)
7. [Système de Newsletter](#système-de-newsletter)
8. [Fonctionnalités Avancées](#fonctionnalités-avancées)
9. [Résolution de Problèmes](#résolution-de-problèmes)

---

## Installation

### 1. Exécuter les Migrations

Assurez-vous que votre base de données est configurée, puis exécutez les migrations :

```bash
php artisan migrate
```

Cela créera les tables suivantes :
- `blog_categories` - Catégories du blog
- `blog_posts` - Articles du blog
- `blog_tags` - Tags pour les articles
- `blog_post_tag` - Table pivot articles-tags
- `blog_comments` - Commentaires sur les articles
- `blog_newsletters` - Abonnés à la newsletter

### 2. Créer un Lien Symbolique pour le Stockage

Pour que les images téléchargées soient accessibles :

```bash
php artisan storage:link
```

### 3. Configuration SMTP (Optionnel)

Pour que les newsletters fonctionnent, configurez votre SMTP dans `.env` :

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=votre_username
MAIL_PASSWORD=votre_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@lamaisonp2a.com
MAIL_FROM_NAME="La Maison P2A"
```

---

## Première Configuration

### Éditeur WYSIWYG - Trix

Votre blog utilise **Trix**, un éditeur WYSIWYG moderne, gratuit et open source créé par Basecamp.

**Avantages de Trix :**
- ✅ Totalement gratuit, sans clé API nécessaire
- ✅ Simple et intuitif
- ✅ Génère du HTML propre et sémantique
- ✅ Supporte le formatage de texte, listes, liens, citations
- ✅ Léger et rapide

Aucune configuration supplémentaire n'est nécessaire - Trix fonctionne directement via CDN !

---

## Accès à l'Administration

### Tableau de Bord du Blog

Une fois connecté en tant qu'administrateur, accédez au blog via :

**URL :** `http://votre-domaine.com/admin/blog/dashboard`

ou via le menu latéral : **Gestion du Blog** > **Tableau de bord**

Le tableau de bord affiche :
- ✅ Statistiques globales (articles total, publiés, brouillons, planifiés)
- ✅ Nombre de commentaires en attente
- ✅ Nombre d'abonnés à la newsletter
- ✅ Graphiques de tendances (derniers 7 jours)
- ✅ Articles récents
- ✅ Commentaires récents

---

## Créer votre Premier Article

### Étape 1 : Accéder à la Création

**Navigation :** Gestion du Blog > Articles > Nouveau Article

**URL :** `http://votre-domaine.com/admin/blog/posts/create`

### Étape 2 : Remplir les Informations de Base

#### Informations Générales

- **Titre** (obligatoire) : Le titre de votre article
- **Slug** (auto-généré) : L'URL de votre article (modifiable)
- **Extrait** : Résumé court (max 500 caractères, apparaît sur les listings)
- **Contenu** (obligatoire) : Corps de l'article avec éditeur WYSIWYG Trix

#### Catégorie & Tags

- **Catégorie** : Sélectionnez une catégorie (optionnel)
- **Tags** : Cochez les tags pertinents (optionnel, permet de lier des articles similaires)

#### Images

- **Image à la une** : Image principale de l'article (formats : JPG, PNG, WebP)
- **Galerie d'images** : Images supplémentaires (multi-sélection)

Les images sont stockées dans `storage/app/public/blog/`

#### Paramètres de Publication

- **Statut** :
  - `Brouillon` : Non visible publiquement
  - `Publié` : Visible immédiatement (ou à la date de publication)
  - `Planifié` : Sera publié automatiquement à la date programmée

- **Date de publication** : Quand le statut est "Publié"
- **Date de publication planifiée** : Quand le statut est "Planifié"

- **Options** :
  - ☑️ Article à la une : Apparaît dans la section héro de la page d'accueil du blog
  - ☑️ Autoriser les commentaires : Permet aux utilisateurs de commenter

#### SEO

- **Titre SEO** : Balise `<title>` pour les moteurs de recherche
- **Description SEO** : Balise meta description
- **Mots-clés SEO** : Mots-clés séparés par des virgules

### Étape 3 : Publier

Cliquez sur **Créer l'article**

**Note importante :** Si vous publiez un article (statut = Publié), une newsletter sera automatiquement envoyée à tous les abonnés !

---

## Gérer les Catégories et Tags

### Créer une Catégorie

**Navigation :** Gestion du Blog > Catégories > Nouvelle Catégorie

**Champs :**
- Nom
- Slug (auto-généré)
- Description
- Image (optionnel)
- Catégorie parente (pour créer des sous-catégories)
- Ordre d'affichage
- Statut actif/inactif

### Créer des Tags

Les tags doivent être créés via les routes de tags (à implémenter via l'interface admin si nécessaire).

Pour l'instant, vous pouvez les créer en base de données directement :

```php
// Dans tinker (php artisan tinker)
\App\Models\BlogTag::create([
    'name' => 'Décoration',
    'slug' => 'decoration'
]);

\App\Models\BlogTag::create([
    'name' => 'Événementiel',
    'slug' => 'evenementiel'
]);

\App\Models\BlogTag::create([
    'name' => 'Tendances',
    'slug' => 'tendances'
]);
```

---

## Modération des Commentaires

### Accès

**Navigation :** Gestion du Blog > Commentaires

**URL :** `http://votre-domaine.com/admin/blog/comments`

### Statuts des Commentaires

- 🟡 **En attente** : Nouveau commentaire non modéré (badge jaune avec animation)
- 🟢 **Approuvé** : Commentaire validé et visible publiquement
- 🔴 **Spam** : Marqué comme spam (non visible)

### Actions Disponibles

Pour les commentaires en attente :
- ✅ **Approuver** : Rend le commentaire visible sur l'article
- ⚠️ **Marquer Spam** : Marque comme spam (masqué)

Pour tous les commentaires :
- 🗑️ **Supprimer** : Supprime définitivement le commentaire

### Filtres

Utilisez le menu déroulant pour filtrer par statut :
- Tous les commentaires
- En attente
- Approuvés
- Spam

### Badge de Notification

Un badge orange apparaît dans le menu latéral "Commentaires" indiquant le nombre de commentaires en attente de modération.

---

## Système de Newsletter

### Comment ça Fonctionne ?

1. **Inscription des Utilisateurs**
   - Les visiteurs s'inscrivent via le formulaire dans la sidebar du blog
   - Ils reçoivent un email de vérification avec un lien de confirmation
   - Une fois confirmé, leur statut devient `actif`

2. **Envoi Automatique**
   - Quand vous **créez** ou **modifiez** un article avec le statut "Publié"
   - Un email est envoyé automatiquement à tous les abonnés actifs
   - L'email contient le titre, l'extrait et un lien vers l'article complet

3. **Email de Newsletter**
   - Template : `resources/views/emails/new-blog-post.blade.php`
   - Contient : titre, extrait, image à la une, lien "Lire l'article"
   - Lien de désabonnement inclus

### Tester la Newsletter

#### 1. S'Abonner Manuellement

Allez sur le blog public et remplissez le formulaire newsletter dans la sidebar :

**URL :** `http://votre-domaine.com/blog`

#### 2. Créer un Abonné en Base de Données

```bash
php artisan tinker
```

```php
\App\Models\BlogNewsletter::create([
    'email' => 'test@example.com',
    'token' => \Illuminate\Support\Str::random(32),
    'is_active' => true,
    'verified_at' => now()
]);
```

#### 3. Publier un Article

Créez ou modifiez un article et définissez son statut sur "Publié". L'email sera envoyé automatiquement.

### Désabonnement

Chaque email de newsletter contient un lien "Se désabonner" qui permet aux utilisateurs de se retirer de la liste.

---

## Fonctionnalités Avancées

### 1. Articles Similaires

Le système affiche automatiquement jusqu'à 3 articles similaires basés sur les tags communs.

**Méthode :** `BlogPost::relatedPosts($limit)`

### 2. Temps de Lecture

Calculé automatiquement à partir du contenu (moyenne de 200 mots/minute).

**Attribut :** `$post->reading_time`

### 3. Compteur de Vues

Chaque visite d'un article incrémente automatiquement le compteur de vues.

**Contrôleur :** `BlogController@show` (ligne avec `incrementViews()`)

### 4. Partage Social

Boutons de partage intégrés pour :
- 📘 Facebook
- 🐦 Twitter / X
- 💼 LinkedIn
- 💬 WhatsApp

**Template :** `resources/views/blog/show.blade.php`

### 5. Commentaires Imbriqués

Les commentaires supportent les réponses (commentaires enfants).

**Relation :** `parent_id` dans la table `blog_comments`

### 6. Recherche et Filtres

Sur la page index du blog :
- 🔍 Recherche par titre/contenu
- 📁 Filtre par catégorie
- 🏷️ Filtre par tag
- 📊 Tri par (Récents, Populaires, Anciens)

**URL exemple :** `http://votre-domaine.com/blog?search=décoration&category=2&tag=1&sort=popular`

### 7. SEO Optimisé

- Slugs automatiques générés à partir du titre
- Meta tags personnalisables par article
- Open Graph tags pour réseaux sociaux
- URLs propres et lisibles

---

## Résolution de Problèmes

### Les Images ne s'Affichent Pas

**Problème :** Les images téléchargées retournent une erreur 404

**Solution :**
```bash
php artisan storage:link
```

Vérifiez que le dossier `public/storage` pointe vers `storage/app/public`

### Les Newsletters ne Sont Pas Envoyées

**Problème :** Aucun email n'est reçu après publication

**Solutions :**

1. Vérifiez la configuration SMTP dans `.env`
2. Testez l'envoi d'email :
```bash
php artisan tinker
```
```php
Mail::raw('Test email', function ($message) {
    $message->to('test@example.com')->subject('Test');
});
```

3. Vérifiez les logs : `storage/logs/laravel.log`
4. Assurez-vous qu'il y a des abonnés actifs :
```bash
php artisan tinker
```
```php
\App\Models\BlogNewsletter::where('is_active', true)->count();
```

### L'Éditeur Trix ne se Charge Pas

**Problème :** L'éditeur WYSIWYG n'apparaît pas

**Solutions :**

1. Vérifiez votre connexion internet (Trix est chargé via CDN)
2. Vérifiez la console du navigateur pour les erreurs JavaScript
3. Assurez-vous que JavaScript est activé dans votre navigateur
4. Videz le cache de votre navigateur (Ctrl+F5)

### Les Commentaires n'Apparaissent Pas

**Problème :** Les commentaires soumis ne s'affichent pas

**Solution :**

Les commentaires sont en statut "pending" par défaut. Vous devez les approuver via l'admin :

**Admin** > **Gestion du Blog** > **Commentaires** > Cliquez sur "Approuver"

### Erreur 404 sur les Routes du Blog

**Problème :** Les pages du blog retournent 404

**Solutions :**

1. Vérifiez que les routes sont bien enregistrées :
```bash
php artisan route:list --name=blog
```

2. Videz le cache :
```bash
php artisan route:clear
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## URLs Principales

### Administration

| Page | URL |
|------|-----|
| Dashboard Blog | `/admin/blog/dashboard` |
| Liste des Articles | `/admin/blog/posts` |
| Créer Article | `/admin/blog/posts/create` |
| Modifier Article | `/admin/blog/posts/{id}/edit` |
| Liste Catégories | `/admin/blog/categories` |
| Commentaires | `/admin/blog/comments` |

### Public

| Page | URL |
|------|-----|
| Blog Accueil | `/blog` |
| Article Unique | `/blog/{slug}` |
| Par Catégorie | `/blog/category/{slug}` |
| Par Tag | `/blog/tag/{slug}` |
| Recherche | `/blog/search?q=...` |

---

## Astuces & Bonnes Pratiques

### 1. Optimisation des Images

Avant de télécharger des images, optimisez-les :
- Format recommandé : WebP ou JPG
- Taille recommandée : max 1920px de largeur
- Poids recommandé : < 500 Ko par image

### 2. SEO

Pour un meilleur référencement :
- ✅ Remplissez toujours le titre SEO et la description
- ✅ Utilisez des slugs descriptifs
- ✅ Ajoutez une image à la une de qualité
- ✅ Rédigez un extrait accrocheur (160 caractères max)
- ✅ Structurez votre contenu avec des titres (H2, H3)

### 3. Engagement

Pour augmenter l'engagement :
- ✅ Activez les commentaires sur les articles
- ✅ Répondez aux commentaires de vos lecteurs
- ✅ Utilisez des tags pour relier les articles
- ✅ Marquez les meilleurs articles comme "à la une"
- ✅ Publiez régulièrement pour fidéliser les abonnés

### 4. Organisation

- 📁 Créez des catégories cohérentes
- 🏷️ Utilisez 3-5 tags par article maximum
- 📅 Planifiez vos articles à l'avance avec le statut "Planifié"
- 🗂️ Utilisez les brouillons pour préparer du contenu

---

## Support & Documentation

### Fichiers Importants

- **Migrations :** `database/migrations/2025_10_30_*_create_blog_*.php`
- **Modèles :** `app/Models/Blog*.php`
- **Contrôleurs Admin :** `app/Http/Controllers/Admin/Blog*.php`
- **Contrôleurs Public :** `app/Http/Controllers/Blog*.php`
- **Vues Admin :** `resources/views/admin/blog/`
- **Vues Public :** `resources/views/blog/`
- **Emails :** `resources/views/emails/`
- **Routes :** `routes/web.php` (sections blog)

### Technologies Utilisées

- **Framework :** Laravel 12
- **Éditeur WYSIWYG :** Trix 2.0 (gratuit, open source)
- **CSS :** TailwindCSS 3
- **JavaScript :** Alpine.js 3.15
- **Base de données :** MySQL 8.0+

---

**Vous êtes maintenant prêt à utiliser votre système de blog !** 🚀

## ⏰ Important : Articles Planifiés

Pour que les articles planifiés soient publiés automatiquement, vous devez démarrer le scheduler Laravel :

```bash
php artisan schedule:work
```

📖 **Guide complet :** Consultez `SCHEDULER.md` pour toutes les options (développement, production, cron, supervisor).

## 💬 Commentaires sur les Articles

- Les visiteurs **doivent être connectés** pour commenter
- Tous les commentaires sont **en attente de modération** par défaut
- Approuvez-les dans **Admin** > **Blog** > **Commentaires**

---

Pour toute question ou problème, consultez les logs Laravel dans `storage/logs/laravel.log`.
