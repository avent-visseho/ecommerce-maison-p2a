# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

La Maison P2A is a Laravel 12 e-commerce platform for interior and event decoration. It features:
- Product catalog with variants (sizes, colors, etc.)
- Equipment rental system with date-based availability
- Blog with newsletter subscriptions
- FedaPay payment integration (Mobile Money + cards for West Africa, XOF currency)
- Bilingual support (French/English)

## Common Commands

```bash
# Development - runs server, queue, logs, and Vite concurrently
composer dev

# Run tests
composer test
# Or directly:
php artisan test

# Run a single test file
php artisan test --filter=ExampleTest

# Code formatting with Laravel Pint
./vendor/bin/pint

# Build frontend assets
npm run build
npm run dev
```

## Architecture

### Controllers Structure
- `App\Http\Controllers\Admin\*` - Admin dashboard controllers (products, orders, blog, rentals)
- `App\Http\Controllers\Client\*` - Customer dashboard controllers
- `App\Http\Controllers\Blog\*` - Public blog controllers
- Root controllers handle public pages (HomeController, ShopController, CartController, etc.)

### Key Services
- `App\Services\CartService` - Session-based cart with support for products, variants, and rentals. Cart keys: `p{id}` for products, `p{id}_v{id}` for variants, `r{id}_{start}_{end}` for rentals.
- `App\Services\FedaPayService` - Payment gateway integration
- `App\Services\ProductVariantService` - Variant management

### Middleware
Registered in `bootstrap/app.php`:
- `admin` - Requires admin role
- `customer` - Requires customer role
- `CheckMaintenanceMode` - Site maintenance mode
- `SetLocale` - Language switching (supports `?lang=en` or `?lang=fr`)
- `TrackVisitor` - Analytics

### Models
- Products have variants (ProductVariant) with attributes (ProductAttribute/ProductAttributeValue)
- Orders contain OrderItems which can reference products or rental items
- Blog system: BlogPost, BlogCategory, BlogTag, BlogComment, BlogNewsletter
- Rentals: RentalCategory, RentalItem, RentalReservation

### Localization
Translation files in `lang/en/` and `lang/fr/`. Use `__('file.key')` syntax.

## Testing

Tests use SQLite in-memory database (configured in `phpunit.xml`). Test classes in `tests/Unit/` and `tests/Feature/`.

## Environment Variables

Key configuration:
- `FEDAPAY_API_KEY`, `FEDAPAY_ENVIRONMENT` (sandbox/live) - Payment gateway
- Standard Laravel DB, MAIL, and APP settings
