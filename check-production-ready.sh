#!/bin/bash

# ===================================
# Script de vérification Production Ready
# Pour Stripe et Sécurité
# ===================================

echo "🔍 Vérification de l'état de préparation pour la PRODUCTION"
echo "============================================================"
echo ""

# Couleurs
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

ERRORS=0
WARNINGS=0

# Fonction pour vérifier une variable .env
check_env_var() {
    local var_name=$1
    local expected_value=$2
    local current_value=$(grep "^${var_name}=" .env 2>/dev/null | cut -d '=' -f2-)

    if [ -z "$current_value" ]; then
        echo -e "${RED}❌ $var_name n'est pas défini${NC}"
        ((ERRORS++))
        return 1
    fi

    if [ "$expected_value" != "" ] && [ "$current_value" == "$expected_value" ]; then
        echo -e "${RED}❌ $var_name a encore sa valeur par défaut${NC}"
        ((ERRORS++))
        return 1
    fi

    echo -e "${GREEN}✅ $var_name est défini${NC}"
    return 0
}

# Fonction pour vérifier une valeur spécifique
check_env_value() {
    local var_name=$1
    local expected=$2
    local current_value=$(grep "^${var_name}=" .env 2>/dev/null | cut -d '=' -f2-)

    if [ "$current_value" == "$expected" ]; then
        echo -e "${GREEN}✅ $var_name = $expected${NC}"
        return 0
    else
        echo -e "${RED}❌ $var_name = $current_value (devrait être $expected)${NC}"
        ((ERRORS++))
        return 1
    fi
}

# Fonction pour vérifier qu'une valeur commence par un préfixe
check_env_prefix() {
    local var_name=$1
    local prefix=$2
    local current_value=$(grep "^${var_name}=" .env 2>/dev/null | cut -d '=' -f2-)

    if [[ "$current_value" == ${prefix}* ]]; then
        echo -e "${GREEN}✅ $var_name utilise la clé LIVE${NC}"
        return 0
    else
        echo -e "${RED}❌ $var_name n'utilise PAS la clé LIVE (commence par $prefix)${NC}"
        ((ERRORS++))
        return 1
    fi
}

echo "📋 1. Vérification des Variables d'Environnement"
echo "------------------------------------------------"
check_env_value "APP_ENV" "production"
check_env_value "APP_DEBUG" "false"

echo ""
echo "🔒 2. Vérification HTTPS"
echo "------------------------------------------------"
APP_URL=$(grep "^APP_URL=" .env 2>/dev/null | cut -d '=' -f2-)
if [[ "$APP_URL" == https://* ]]; then
    echo -e "${GREEN}✅ APP_URL utilise HTTPS${NC}"
else
    echo -e "${RED}❌ APP_URL n'utilise PAS HTTPS : $APP_URL${NC}"
    ((ERRORS++))
fi

echo ""
echo "💳 3. Vérification Clés Stripe"
echo "------------------------------------------------"
check_env_prefix "STRIPE_PUBLISHABLE_KEY" "pk_live_"
check_env_prefix "STRIPE_SECRET_KEY" "sk_live_"

WEBHOOK_SECRET=$(grep "^STRIPE_WEBHOOK_SECRET=" .env 2>/dev/null | cut -d '=' -f2-)
if [[ "$WEBHOOK_SECRET" == whsec_* ]] && [[ "$WEBHOOK_SECRET" != "whsec_xxxxxxxxxxxxxxxxxxxx" ]]; then
    echo -e "${GREEN}✅ STRIPE_WEBHOOK_SECRET configuré${NC}"
else
    echo -e "${RED}❌ STRIPE_WEBHOOK_SECRET non configuré ou valeur par défaut${NC}"
    ((ERRORS++))
fi

echo ""
echo "🔧 4. Vérification Code Source"
echo "------------------------------------------------"

# Vérifier que AppServiceProvider force HTTPS
if grep -q "URL::forceScheme('https')" app/Providers/AppServiceProvider.php; then
    echo -e "${GREEN}✅ HTTPS forcé dans AppServiceProvider${NC}"
else
    echo -e "${YELLOW}⚠️  HTTPS pas forcé dans AppServiceProvider (non critique si géré par serveur web)${NC}"
    ((WARNINGS++))
fi

# Vérifier que le webhook est exclu du CSRF
if grep -q "stripe/webhook" bootstrap/app.php; then
    echo -e "${GREEN}✅ Webhook Stripe exclu du CSRF${NC}"
else
    echo -e "${RED}❌ Webhook Stripe NON exclu du CSRF${NC}"
    ((ERRORS++))
fi

echo ""
echo "📝 5. Vérification Fichiers Sensibles"
echo "------------------------------------------------"

# Vérifier que .env n'est pas committé
if git ls-files | grep -q "^.env$"; then
    echo -e "${RED}❌ DANGER: .env est tracké par Git !${NC}"
    ((ERRORS++))
else
    echo -e "${GREEN}✅ .env n'est pas tracké par Git${NC}"
fi

# Vérifier .gitignore
if grep -q "^\.env$" .gitignore; then
    echo -e "${GREEN}✅ .env dans .gitignore${NC}"
else
    echo -e "${RED}❌ .env absent de .gitignore${NC}"
    ((ERRORS++))
fi

echo ""
echo "🌐 6. Vérification Certificat SSL (si disponible)"
echo "------------------------------------------------"

DOMAIN=$(echo "$APP_URL" | sed 's/https\?:\/\///' | sed 's/\/.*//')
if command -v openssl &> /dev/null; then
    if timeout 5 bash -c "echo | openssl s_client -servername $DOMAIN -connect $DOMAIN:443 2>/dev/null | grep -q 'Verify return code: 0'"; then
        echo -e "${GREEN}✅ Certificat SSL valide pour $DOMAIN${NC}"
    else
        echo -e "${YELLOW}⚠️  Certificat SSL non valide ou domaine inaccessible${NC}"
        ((WARNINGS++))
    fi
else
    echo -e "${YELLOW}⚠️  openssl non disponible, impossible de vérifier le certificat${NC}"
    ((WARNINGS++))
fi

echo ""
echo "🗄️  7. Vérification Base de Données"
echo "------------------------------------------------"

# Vérifier que la connexion DB n'est pas sqlite
DB_CONNECTION=$(grep "^DB_CONNECTION=" .env 2>/dev/null | cut -d '=' -f2-)
if [ "$DB_CONNECTION" == "mysql" ] || [ "$DB_CONNECTION" == "pgsql" ]; then
    echo -e "${GREEN}✅ Base de données : $DB_CONNECTION${NC}"
else
    echo -e "${YELLOW}⚠️  Base de données : $DB_CONNECTION (sqlite pas recommandé en production)${NC}"
    ((WARNINGS++))
fi

echo ""
echo "============================================================"
echo "📊 RÉSUMÉ"
echo "============================================================"
echo -e "Erreurs critiques  : ${RED}$ERRORS${NC}"
echo -e "Avertissements     : ${YELLOW}$WARNINGS${NC}"
echo ""

if [ $ERRORS -eq 0 ]; then
    echo -e "${GREEN}✅ PRÊT POUR LA PRODUCTION !${NC}"
    echo ""
    echo "Prochaines étapes :"
    echo "1. Tester un paiement avec une vraie carte (petit montant)"
    echo "2. Vérifier que le webhook Stripe est bien reçu"
    echo "3. Tester 3D Secure avec carte : 4000 0027 6000 3184"
    echo "4. Surveiller les logs pendant 24h après déploiement"
    exit 0
else
    echo -e "${RED}❌ PAS PRÊT POUR LA PRODUCTION${NC}"
    echo ""
    echo "Corrigez les erreurs ci-dessus avant de déployer."
    echo "Consultez AUDIT_STRIPE_PRODUCTION.md pour plus de détails."
    exit 1
fi
