#!/bin/sh
set -e

cd /var/www/html

# 1) Fichier .env : créé depuis .env.example au premier démarrage.
#    Les variables passées par docker-compose (DB_*, AI_*) ont priorité
#    sur celles du fichier .env (Laravel n'écrase pas les vraies env vars).
if [ ! -f .env ]; then
    echo "[entrypoint] Création du fichier .env depuis .env.example"
    cp .env.example .env
fi

# 2) Attente de la base de données MySQL.
echo "[entrypoint] Attente de la base de données (${DB_HOST}:${DB_PORT})..."
until php -r "
    try {
        new PDO('mysql:host='.getenv('DB_HOST').';port='.getenv('DB_PORT'),
                getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        exit(0);
    } catch (Throwable \$e) { exit(1); }
"; do
    echo "[entrypoint] MySQL pas encore prêt, nouvelle tentative dans 3s..."
    sleep 3
done
echo "[entrypoint] Base de données disponible."

# 3) Clé d'application (générée une seule fois, stockée dans .env).
if ! grep -q "^APP_KEY=base64:" .env; then
    echo "[entrypoint] Génération de la clé d'application"
    php artisan key:generate --force
fi

# 4) Migrations (idempotent).
echo "[entrypoint] Exécution des migrations"
php artisan migrate --force || echo "[entrypoint] Avertissement : migrations échouées"

# 5) Lien de stockage public pour les images.
php artisan storage:link 2>/dev/null || true

# 6) Caches Laravel propres (on évite config:cache pour laisser les env vars vivantes).
php artisan config:clear || true
php artisan view:clear || true

echo "[entrypoint] Démarrage : $*"
exec "$@"
