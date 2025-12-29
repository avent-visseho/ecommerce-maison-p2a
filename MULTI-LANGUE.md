# Guide Multi-langue (Français/Anglais)

## 🌍 Système mis en place

J'ai implémenté un système multi-langue complet pour ton application Laravel avec support du **français** et de l'**anglais**.

## ✅ Ce qui a été fait

### 1. Configuration Laravel
- **Langues supportées**: `fr` (français) et `en` (anglais)
- **Langue par défaut**: Français (peut être changée dans `.env` avec `APP_LOCALE=fr`)
- **Fichiers de traduction** créés dans `/lang/fr/` et `/lang/en/`

### 2. Base de données - Traductions des contenus
Les tables suivantes ont été modifiées pour supporter les traductions:

#### **blog_posts**
- `title_translations` (JSON) - Titres traduits
- `excerpt_translations` (JSON) - Résumés traduits
- `content_translations` (JSON) - Contenus traduits
- `meta_title_translations` (JSON) - Meta titres traduits
- `meta_description_translations` (JSON) - Meta descriptions traduites

#### **blog_categories**
- `name_translations` (JSON) - Noms traduits
- `description_translations` (JSON) - Descriptions traduites

#### **blog_tags**
- `name_translations` (JSON) - Noms traduits

### 3. Trait Translatable
Un trait `App\Traits\Translatable` a été créé et ajouté aux modèles:
- `BlogPost`
- `BlogCategory`
- `BlogTag`

Ce trait gère automatiquement les traductions et retourne la bonne langue selon le contexte.

### 4. Middleware SetLocale
- Détecte et définit la langue active
- Priorité: URL (`?lang=fr`) > Session > Défaut
- Appliqué automatiquement à toutes les routes web

### 5. Sélecteur de langue
Un sélecteur de langue élégant a été ajouté dans le header avec:
- Drapeaux 🇫🇷 et 🇬🇧
- Indication de la langue active
- Dropdown avec animation

## 📖 Comment utiliser

### Dans les vues Blade - Textes statiques

Pour les textes d'interface (menus, boutons, labels), utilise la fonction `__()`:

```blade
<!-- Simple -->
<h1>{{ __('blog.hero_title') }}</h1>

<!-- Avec variables -->
<p>{{ __('blog.published_on') }} {{ $date }}</p>

<!-- Avec pluralisation -->
<span>{{ trans_choice('blog.comments', $count) }}</span>
```

### Dans les vues Blade - Contenus de BDD

Les modèles retournent automatiquement la bonne traduction:

```blade
<!-- Le titre sera automatiquement dans la bonne langue -->
<h1>{{ $post->title }}</h1>

<!-- Pareil pour excerpt, content, etc. -->
<p>{{ $post->excerpt }}</p>

<!-- Les catégories et tags aussi -->
<span>{{ $post->category->name }}</span>
```

### Dans les contrôleurs - Enregistrer des traductions

```php
// Créer un article avec traduction française
$post = BlogPost::create([
    'title' => 'Mon titre en français',
    'slug' => 'mon-article',
    'content' => 'Contenu en français...',
]);

// Ajouter la traduction anglaise
$post->setTranslation('title', 'My title in English', 'en');
$post->setTranslation('content', 'Content in English...', 'en');
$post->save();
```

### Dans les contrôleurs - Lire des traductions

```php
// Récupérer la traduction dans la langue active
$title = $post->title; // Auto selon app()->getLocale()

// Récupérer une traduction spécifique
$titleEn = $post->getTranslation('title', 'en');
$titleFr = $post->getTranslation('title', 'fr');

// Récupérer toutes les traductions d'un attribut
$allTitles = $post->getAllTranslations('title');
// Retourne: ['fr' => 'Titre FR', 'en' => 'Title EN']

// Vérifier si une traduction existe
if ($post->hasTranslation('title', 'en')) {
    // ...
}
```

## 🎨 Fichiers de traduction

Les traductions d'interface sont dans:
- `/lang/fr/blog.php` - Traductions françaises du blog
- `/lang/en/blog.php` - Traductions anglaises du blog

Tu peux ajouter plus de fichiers:
```bash
/lang/fr/
  ├── blog.php
  ├── shop.php
  ├── common.php
  └── ...

/lang/en/
  ├── blog.php
  ├── shop.php
  ├── common.php
  └── ...
```

## 🔄 Changement de langue

L'utilisateur peut changer de langue de 3 façons:

1. **Via le sélecteur** dans le header (déjà implémenté)
2. **Via l'URL**: `?lang=fr` ou `?lang=en`
3. **Programmatiquement**:
```php
Session::put('locale', 'en');
app()->setLocale('en');
```

## 📝 Exemple complet

### Créer un article multilingue dans le seeder

```php
$post = BlogPost::create([
    'title' => 'Guide de décoration',
    'slug' => 'guide-decoration',
    'excerpt' => 'Découvrez nos conseils...',
    'content' => '<p>Contenu complet...</p>',
    'author_id' => 1,
    'blog_category_id' => 1,
    'status' => 'published',
    'published_at' => now(),
]);

// Ajouter les traductions anglaises
$post->setTranslation('title', 'Decoration Guide', 'en');
$post->setTranslation('excerpt', 'Discover our tips...', 'en');
$post->setTranslation('content', '<p>Full content...</p>', 'en');
$post->save();
```

### Utiliser dans la vue

```blade
<!-- resources/views/blog/index.blade.php -->

<!-- Texte d'interface -->
<h1>{{ __('blog.hero_title') }}</h1>
<p>{{ __('blog.hero_description') }}</p>

<!-- Contenu de BDD (auto-traduit) -->
@foreach($posts as $post)
    <article>
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->excerpt }}</p>
        <span>{{ $post->category->name }}</span>

        @foreach($post->tags as $tag)
            <span>#{{ $tag->name }}</span>
        @endforeach
    </article>
@endforeach
```

## 🚀 Prochaines étapes

Pour compléter la traduction du site:

1. **Traduire les textes statiques existants**
   - Remplacer les textes en dur par `__('fichier.clé')`
   - Créer les fichiers de traduction correspondants

2. **Ajouter les traductions dans la BDD**
   - Utiliser le trait `Translatable` sur d'autres modèles si nécessaire
   - Ajouter les colonnes `*_translations` via migrations

3. **Interface admin**
   - Créer un formulaire pour gérer les traductions
   - Ajouter des onglets FR/EN dans les formulaires de création/édition

## 📚 Ressources

- [Documentation Laravel Localization](https://laravel.com/docs/localization)
- [Trait Translatable](/app/Traits/Translatable.php)
- [Middleware SetLocale](/app/Http/Middleware/SetLocale.php)

---

**Bravo!** 🎉 Ton application est maintenant multilingue!
