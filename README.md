# La Maison P2A - E-Commerce Platform

## 📋 Description
Plateforme e-commerce moderne spécialisée dans la décoration d'intérieur et d'événements, construite avec Laravel 12 et TailwindCSS.

## 🚀 Installation

### Prérequis
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL 8.0+
- FedaPay Account

### Étapes d'installation

```bash
# 1. Cloner le projet
git clone <repository-url>
cd la-maison-p2a

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances NPM
npm install

# 4. Copier le fichier d'environnement
cp .env.example .env

# 5. Générer la clé d'application
php artisan key:generate

# 6. Configurer la base de données dans .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=la_maison_p2a
DB_USERNAME=root
DB_PASSWORD=

# 7. Configurer FedaPay dans .env
FEDAPAY_API_KEY=your_api_key_here
FEDAPAY_ENVIRONMENT=sandbox
FEDAPAY_CURRENCY=XOF

# 8. Configurer l'email dans .env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@lamaisonp2a.com"
MAIL_FROM_NAME="La Maison P2A"

# 9. Créer la base de données
mysql -u root -p
CREATE DATABASE la_maison_p2a;
exit;

# 10. Exécuter les migrations
php artisan migrate

# 11. Exécuter les seeders
php artisan db:seed

# 12. Créer le lien symbolique pour le storage
php artisan storage:link

# 13. Compiler les assets
npm run dev

# 14. Lancer le serveur
php artisan serve
```

## 👤 Comptes de test

### Admin
- Email: admin@lamaisonp2a.com
- Password: Admin123!

### Client
- Email: client@test.com
- Password: Client123!

## 🔧 Commandes utiles

```bash
# Compiler les assets pour la production
npm run build

# Nettoyer le cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Générer des données de test
php artisan db:seed --class=ProductSeeder

# Vérifier les routes
php artisan route:list
```

## 📂 Structure du projet

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   ├── Client/
│   │   └── Public/
│   ├── Middleware/
│   └── Requests/
├── Models/
├── Services/
└── Mail/

resources/
├── views/
│   ├── layouts/
│   ├── admin/
│   ├── client/
│   └── public/
└── js/

database/
├── migrations/
├── seeders/
└── factories/
```

## 🔐 Sécurité

- Protection CSRF activée
- Validation des entrées utilisateur
- Hachage sécurisé des mots de passe
- Protection contre XSS et SQL Injection
- Vérification des webhooks FedaPay

## 📧 Fonctionnalités Email

- Confirmation de commande (client)
- Notification de nouvelle commande (admin)
- Génération de factures PDF

## 💳 Paiements

- Intégration FedaPay complète
- Support Mobile Money
- Support Carte bancaire
- Gestion des webhooks
- Suivi des statuts de paiement

## 🎨 Design

- TailwindCSS 3
- Alpine.js pour les interactions
- Chart.js pour les statistiques
- Heroicons pour les icônes
- Design responsive et moderne

## 📞 Support

Pour toute question ou problème, contactez l'équipe de développement.

## 📄 Licence

Propriétaire - La Maison P2A © 2025