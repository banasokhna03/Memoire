#!/usr/bin/env bash

echo "Running Composer..."
composer install --no-dev --optimize-autoloader --working-dir=/var/www/html

echo "Generating application key..."
php artisan key:generate --force # --force pour la production

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Caching views..."
php artisan view:cache

echo "Running database migrations..."
php artisan migrate --force # --force pour la production

# Si vous utilisez Vite/NPM, décommentez et ajustez ces lignes
# echo "Running NPM install..."
# npm install --prefix /var/www/html
# echo "Building assets..."
# npm run build --prefix /var/www/html