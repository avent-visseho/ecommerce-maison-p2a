# 📊 Système de Tracking des Visiteurs

## Vue d'ensemble

Le système de tracking a été amélioré pour compter les **visiteurs uniques** au lieu de compter chaque page vue comme une visite séparée.

### Principe de fonctionnement

- **Visiteur unique** : Une combinaison IP + User Agent dans une fenêtre de **30 minutes**
- Si la même IP visite plusieurs pages dans les 30 minutes, c'est compté comme **1 seul visiteur**
- Le compteur de `page_views` s'incrémente à chaque page visitée par le même visiteur

## Exemple

```
┌─────────────────────────────────────────────────────────────┐
│ Visiteur A (IP: 192.168.1.1)                                │
├─────────────────────────────────────────────────────────────┤
│ 10:00:00 → Visite page d'accueil                            │
│ 10:05:00 → Visite boutique                                  │
│ 10:10:00 → Visite blog                                      │
│ 10:15:00 → Visite contact                                   │
├─────────────────────────────────────────────────────────────┤
│ Résultat:                                                    │
│ ✅ 1 visiteur unique                                         │
│ ✅ 4 pages vues                                              │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│ Visiteur B (IP: 192.168.1.2)                                │
├─────────────────────────────────────────────────────────────┤
│ 10:05:00 → Visite page d'accueil                            │
│ 10:08:00 → Visite produits                                  │
├─────────────────────────────────────────────────────────────┤
│ Résultat:                                                    │
│ ✅ 1 visiteur unique                                         │
│ ✅ 2 pages vues                                              │
└─────────────────────────────────────────────────────────────┘

TOTAL: 2 visiteurs uniques, 6 pages vues
```

## Commandes disponibles

### Afficher les statistiques

```bash
php artisan visitor:stats
```

Affiche :
- Visiteurs uniques et pages vues **aujourd'hui**
- Visiteurs uniques et pages vues **cette semaine**
- Visiteurs uniques et pages vues **ce mois**
- Visiteurs uniques et pages vues **au total**

### Nettoyer toutes les données

```bash
php artisan visitor:stats --clean
```

⚠️ Supprime **toutes** les données de visites (avec confirmation).

## Utilisation dans le code

### Compter les visiteurs uniques

```php
use App\Models\SiteVisit;

// Visiteurs uniques aujourd'hui
$today = SiteVisit::countUniqueVisitors('today');

// Visiteurs uniques cette semaine
$week = SiteVisit::countUniqueVisitors('week');

// Visiteurs uniques ce mois
$month = SiteVisit::countUniqueVisitors('month');

// Visiteurs uniques au total
$total = SiteVisit::countUniqueVisitors();
```

### Compter les pages vues

```php
// Pages vues aujourd'hui
$todayViews = SiteVisit::countPageViews('today');

// Pages vues cette semaine
$weekViews = SiteVisit::countPageViews('week');

// Pages vues ce mois
$monthViews = SiteVisit::countPageViews('month');

// Pages vues au total
$totalViews = SiteVisit::countPageViews();
```

### Utiliser les scopes

```php
// Tous les visiteurs uniques
$uniqueVisitors = SiteVisit::uniqueVisitors()->get();

// Visiteurs uniques aujourd'hui
$todayUnique = SiteVisit::uniqueVisitors()->today()->get();

// Visiteurs uniques cette semaine
$weekUnique = SiteVisit::uniqueVisitors()->thisWeek()->get();
```

## Structure de la table `site_visits`

| Colonne | Type | Description |
|---------|------|-------------|
| `ip_address` | string | Adresse IP du visiteur |
| `user_agent` | string | Navigateur utilisé |
| `url` | string | Dernière URL visitée |
| `referer` | string | Page de provenance |
| `session_id` | string | ID de session Laravel |
| `user_id` | bigint | ID utilisateur (si connecté) |
| `visited_at` | timestamp | Date/heure de la visite |
| `is_unique_visit` | boolean | **true** si c'est un nouveau visiteur unique |
| `page_views` | integer | Nombre de pages vues par ce visiteur |

## Routes exclues du tracking

Le middleware ne track **pas** :
- Routes admin (`/admin/*`)
- Routes API (`/api/*`)
- Routes Livewire (`/livewire/*`)
- Assets statiques (`/build/*`, `/storage/*`, `/css/*`, `/js/*`, `/fonts/*`, `/images/*`)
- Bots et crawlers (User-Agent contenant "bot", "crawler", "spider", "scraper")

## Fenêtre de temps

La fenêtre de **30 minutes** signifie :
- Si un visiteur revient après 30 minutes, il sera compté comme un **nouveau visiteur unique**
- Cela suit les standards de Google Analytics et autres outils d'analytics professionnels

## Tests

Des tests complets sont disponibles dans `tests/Feature/TrackVisitorTest.php` :

```bash
php artisan test --filter=TrackVisitorTest
```

## Migration

La migration a automatiquement :
- ✅ Nettoyé les anciennes données biaisées
- ✅ Ajouté les colonnes `is_unique_visit` et `page_views`
- ✅ Créé des index pour optimiser les performances

## Performance

Des index ont été ajoutés pour optimiser les requêtes :
- `ip_ua_visited_idx` : Combinaison (ip_address, user_agent, visited_at)
- Requêtes très rapides même avec des millions de visiteurs
