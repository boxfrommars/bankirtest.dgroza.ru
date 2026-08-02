#!/bin/sh
set -eu

if [ ! -f vendor/autoload.php ]; then
    composer install --no-interaction --prefer-dist
fi

if [ ! -f .env ]; then
    cp .env.example .env
fi

if ! grep -Eq '^APP_KEY=base64:.+' .env; then
    php artisan key:generate --force
fi

mkdir -p storage/app/data storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache

database_path="${DB_DATABASE:-/var/www/html/storage/app/data/database.sqlite}"
seed_marker="${database_path}.seeded"
touch "$database_path"

php artisan migrate --force

if [ ! -f "$seed_marker" ]; then
    php artisan db:seed --force
    touch "$seed_marker"
fi

chown -R www-data:www-data storage bootstrap/cache

exec php-fpm
