#!/bin/bash
#=============================================================================
# Script de déploiement - La Maison P2A
#
# Usage:
#   ./deploy.sh              Déploiement initial complet (zip + upload)
#   ./deploy.sh update       Mise à jour rapide (rsync, envoie uniquement les changements)
#   ./deploy.sh quick        Mise à jour code seul (pas de npm build, pas de composer)
#=============================================================================

set -e

#-----------------------------------------------------------------------------
# CONFIGURATION - Modifier ces valeurs selon ton serveur
#-----------------------------------------------------------------------------
SSH_USER="u908740715"
SSH_HOST="lamaisonp2a.com"
SSH_PORT="65002"                    # Port SSH Hostinger (souvent 65002, sinon 22)
REMOTE_DIR="/home/u908740715/domains/lamaisonp2a.com/public_html"
SSH_CMD="ssh -p $SSH_PORT $SSH_USER@$SSH_HOST"
ARCHIVE_NAME="deploy_$(date +%Y%m%d_%H%M%S).zip"

# Mode de déploiement (full, update, quick)
DEPLOY_MODE="${1:-full}"

#-----------------------------------------------------------------------------
# COULEURS
#-----------------------------------------------------------------------------
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
NC='\033[0m'

log_info()  { echo -e "${BLUE}[INFO]${NC}  $1"; }
log_ok()    { echo -e "${GREEN}[OK]${NC}    $1"; }
log_warn()  { echo -e "${YELLOW}[WARN]${NC}  $1"; }
log_error() { echo -e "${RED}[ERROR]${NC} $1"; }
log_step()  { echo -e "\n${CYAN}--- $1 ---${NC}"; }

#-----------------------------------------------------------------------------
# EXCLUSIONS COMMUNES
#-----------------------------------------------------------------------------
RSYNC_EXCLUDES=(
    ".git"
    "node_modules"
    ".env"
    "storage/logs/*.log"
    "storage/framework/cache/data/*"
    "storage/framework/sessions/*"
    "storage/framework/views/*"
    "storage/app/public/*"
    "public/storage"
    "tests"
    ".phpunit*"
    "deploy.sh"
    ".DS_Store"
    "*.log"
    "bootstrap/cache/*"
    ".claude"
    "CLAUDE.md"
)

ZIP_EXCLUDES=(
    ".git/*"
    "node_modules/*"
    ".env"
    "storage/logs/*"
    "storage/framework/cache/data/*"
    "storage/framework/sessions/*"
    "storage/framework/views/*"
    "storage/app/public/*"
    "public/storage"
    "tests/*"
    ".phpunit*"
    "deploy.sh"
    ".DS_Store"
    "*.log"
    "bootstrap/cache/*"
    ".claude/*"
    "CLAUDE.md"
)

#-----------------------------------------------------------------------------
# BANNIÈRE
#-----------------------------------------------------------------------------
echo ""
echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}  Déploiement - La Maison P2A${NC}"
echo -e "${BLUE}  Mode: ${CYAN}${DEPLOY_MODE}${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""

#-----------------------------------------------------------------------------
# VÉRIFICATIONS
#-----------------------------------------------------------------------------
if [ ! -f "artisan" ]; then
    log_error "Ce script doit être exécuté depuis la racine du projet Laravel."
    exit 1
fi

log_info "Vérification de la connexion SSH..."
if ! $SSH_CMD "echo ok" &>/dev/null; then
    log_error "Impossible de se connecter au serveur. Vérifie :"
    echo "  - SSH_USER: $SSH_USER"
    echo "  - SSH_HOST: $SSH_HOST"
    echo "  - SSH_PORT: $SSH_PORT"
    echo ""
    echo "  Configure ta clé SSH :"
    echo "    ssh-copy-id -p $SSH_PORT $SSH_USER@$SSH_HOST"
    exit 1
fi
log_ok "Connexion SSH OK"

#=============================================================================
# MODE UPDATE : rsync (rapide, envoie uniquement les différences)
#=============================================================================
deploy_update() {
    log_step "Build des assets frontend"
    if [ -f "package.json" ]; then
        npm run build 2>&1 | tail -3
        log_ok "Assets compilés"
    fi

    log_step "Installation Composer (production)"
    composer install --no-dev --optimize-autoloader --no-interaction 2>&1 | tail -3
    log_ok "Dépendances prêtes"

    log_step "Synchronisation avec le serveur (rsync)"

    # Construire les exclusions rsync
    EXCLUDE_ARGS=""
    for pattern in "${RSYNC_EXCLUDES[@]}"; do
        EXCLUDE_ARGS="$EXCLUDE_ARGS --exclude=$pattern"
    done

    # Rsync : envoie uniquement les fichiers modifiés
    rsync -avz --delete \
        $EXCLUDE_ARGS \
        -e "ssh -p $SSH_PORT" \
        ./ "$SSH_USER@$SSH_HOST:$REMOTE_DIR/"

    log_ok "Fichiers synchronisés"

    # Commandes post-déploiement sur le serveur
    run_remote_post_deploy
}

#=============================================================================
# MODE QUICK : rsync code uniquement (pas de build, pas de composer)
#=============================================================================
deploy_quick() {
    log_step "Synchronisation du code uniquement (sans build)"

    EXCLUDE_ARGS=""
    for pattern in "${RSYNC_EXCLUDES[@]}"; do
        EXCLUDE_ARGS="$EXCLUDE_ARGS --exclude=$pattern"
    done

    # Exclure aussi vendor et public/build en mode quick
    EXCLUDE_ARGS="$EXCLUDE_ARGS --exclude=vendor --exclude=public/build"

    rsync -avz \
        $EXCLUDE_ARGS \
        -e "ssh -p $SSH_PORT" \
        ./ "$SSH_USER@$SSH_HOST:$REMOTE_DIR/"

    log_ok "Code synchronisé"

    # Post-déploiement léger
    log_step "Nettoyage du cache distant"
    $SSH_CMD bash -s "$REMOTE_DIR" << 'REMOTE'
        REMOTE_DIR="$1"
        cd "$REMOTE_DIR"
        php artisan cache:clear 2>/dev/null || true
        php artisan config:cache
        php artisan route:cache
        php artisan view:cache

        # Corriger le symlink storage (toujours pointer vers le chemin serveur)
        EXPECTED="$REMOTE_DIR/storage/app/public"
        CURRENT=$(readlink public/storage 2>/dev/null)
        if [ "$CURRENT" != "$EXPECTED" ]; then
            rm -f public/storage
            ln -s "$EXPECTED" public/storage
            echo "[REMOTE] Storage link corrigé"
        fi

        # Permissions des fichiers uploadés
        chmod -R 775 storage/app/public 2>/dev/null || true

        echo "[REMOTE] Cache rechargé"
REMOTE
    log_ok "Cache rechargé"
}

#=============================================================================
# MODE FULL : zip + upload (premier déploiement)
#=============================================================================
deploy_full() {
    log_step "Build des assets frontend"
    if [ -f "package.json" ]; then
        npm run build 2>&1 | tail -3
        log_ok "Assets compilés"
    fi

    log_step "Optimisation Laravel"
    php artisan config:clear 2>/dev/null || true
    php artisan route:clear 2>/dev/null || true
    php artisan view:clear 2>/dev/null || true
    log_ok "Caches nettoyés"

    log_step "Installation Composer (production)"
    composer install --no-dev --optimize-autoloader --no-interaction 2>&1 | tail -3
    log_ok "Dépendances installées"

    log_step "Création de l'archive"
    EXCLUDE_ARGS=""
    for pattern in "${ZIP_EXCLUDES[@]}"; do
        EXCLUDE_ARGS="$EXCLUDE_ARGS -x \"$pattern\""
    done
    eval zip -r -q "$ARCHIVE_NAME" . $EXCLUDE_ARGS
    FILESIZE=$(du -h "$ARCHIVE_NAME" | cut -f1)
    log_ok "Archive créée ($FILESIZE)"

    log_step "Envoi sur le serveur"
    scp -P "$SSH_PORT" "$ARCHIVE_NAME" "$SSH_USER@$SSH_HOST:$REMOTE_DIR/$ARCHIVE_NAME"
    log_ok "Archive envoyée"

    log_step "Extraction et installation sur le serveur"
    $SSH_CMD bash -s "$ARCHIVE_NAME" "$REMOTE_DIR" << 'REMOTE_SCRIPT'
        set -e
        ARCHIVE_NAME="$1"
        REMOTE_DIR="$2"
        cd "$REMOTE_DIR"

        # Sauvegarder .env et uploads
        [ -f ".env" ] && cp .env /tmp/.env_backup_lamaisonp2a
        [ -d "storage/app/public" ] && cp -r storage/app/public /tmp/storage_public_backup

        # Extraire
        unzip -o -q "$ARCHIVE_NAME"

        # Restaurer .env et uploads
        [ -f /tmp/.env_backup_lamaisonp2a ] && cp /tmp/.env_backup_lamaisonp2a .env && rm /tmp/.env_backup_lamaisonp2a
        if [ -d /tmp/storage_public_backup ]; then
            cp -r /tmp/storage_public_backup/* storage/app/public/ 2>/dev/null || true
            rm -rf /tmp/storage_public_backup
        fi

        # Permissions
        chmod -R 775 storage bootstrap/cache

        # Storage link
        rm -f public/storage
        ln -s "$REMOTE_DIR/storage/app/public" public/storage

        # Nettoyage archive
        rm -f "$ARCHIVE_NAME"

        echo "[REMOTE] Extraction terminée"
REMOTE_SCRIPT

    log_ok "Extraction terminée"

    # Post-déploiement
    run_remote_post_deploy

    # Nettoyage local
    rm -f "$ARCHIVE_NAME"
}

#=============================================================================
# COMMANDES POST-DÉPLOIEMENT (communes à full et update)
#=============================================================================
run_remote_post_deploy() {
    log_step "Post-déploiement sur le serveur"

    $SSH_CMD bash -s "$REMOTE_DIR" << 'REMOTE'
        REMOTE_DIR="$1"
        cd "$REMOTE_DIR"

        echo "[REMOTE] Permissions..."
        chmod -R 775 storage bootstrap/cache

        echo "[REMOTE] Migrations..."
        php artisan migrate --force 2>/dev/null || echo "[REMOTE] Migrations: rien à faire"

        echo "[REMOTE] Optimisation du cache..."
        php artisan config:cache
        php artisan route:cache
        php artisan view:cache

        # Corriger le symlink storage (toujours pointer vers le chemin serveur)
        EXPECTED="$REMOTE_DIR/storage/app/public"
        CURRENT=$(readlink public/storage 2>/dev/null)
        if [ "$CURRENT" != "$EXPECTED" ]; then
            rm -f public/storage
            ln -s "$EXPECTED" public/storage
            echo "[REMOTE] Storage link corrigé"
        fi

        # Permissions des fichiers uploadés
        chmod -R 775 storage/app/public 2>/dev/null || true

        echo "[REMOTE] Terminé !"
REMOTE

    log_ok "Post-déploiement terminé"
}

#=============================================================================
# EXÉCUTION
#=============================================================================
case "$DEPLOY_MODE" in
    full)
        deploy_full
        ;;
    update)
        deploy_update
        ;;
    quick)
        deploy_quick
        ;;
    *)
        log_error "Mode inconnu: $DEPLOY_MODE"
        echo ""
        echo "Usage:"
        echo "  ./deploy.sh              Premier déploiement complet (zip)"
        echo "  ./deploy.sh update       Mise à jour (rsync + build + composer + migrations)"
        echo "  ./deploy.sh quick        Mise à jour code seul (rsync, pas de build/composer)"
        echo ""
        exit 1
        ;;
esac

# Réinstaller les dépendances dev en local (sauf en mode quick)
if [ "$DEPLOY_MODE" != "quick" ]; then
    log_info "Réinstallation des dépendances dev en local..."
    composer install --no-interaction 2>&1 | tail -3
fi

echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}  Déploiement réussi ! ($DEPLOY_MODE)${NC}"
echo -e "${GREEN}  https://lamaisonp2a.com${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
