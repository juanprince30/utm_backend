# syntax=docker/dockerfile:1

# ──────────────────────────────────────────────────────────────
# Étape 1 : build des assets front (Vite + Tailwind)
# ──────────────────────────────────────────────────────────────
FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json* ./
RUN npm install
COPY . .
RUN npm run build

# ──────────────────────────────────────────────────────────────
# Étape 2 : application PHP servie par Apache
# ──────────────────────────────────────────────────────────────
FROM php:8.3-apache AS app

# Dépendances système + extensions PHP requises par Laravel/MySQL
RUN apt-get update && apt-get install -y --no-install-recommends \
        git unzip libzip-dev libpng-dev libonig-dev libxml2-dev default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring zip exif bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Apache : activer la réécriture d'URL et pointer la racine sur public/
RUN a2enmod rewrite
COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Composer (depuis l'image officielle)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Installer les dépendances PHP d'abord (meilleur cache Docker)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-interaction --prefer-dist --no-progress

# Code de l'application
COPY . .

# Assets compilés issus de l'étape 1
COPY --from=assets /app/public/build ./public/build

RUN composer dump-autoload --optimize \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Entrypoint (attente DB, migrations, storage:link, etc.)
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN sed -i 's/\r$//' /usr/local/bin/entrypoint.sh \
    && chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80
ENTRYPOINT ["entrypoint.sh"]
CMD ["apache2-foreground"]
