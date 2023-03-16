#!/bin/bash

if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction
fi

if [ ! -f ".env" ]; then
    echo "Creating env file for env $APP_ENV"
    cp .env.example .env
else
    echo "env file exists."
fi

php artisan key:generate --ansi
php artisan config:clear
php artisan view:clear
php artisan cache:clear
php artisan storage:link

if php artisan migrate:status | grep -q "No migrations found"; then
    echo "Running migrations..."
    php artisan migrate --seed
else
    echo "Migrations already executed. Fresh migrations will be executed."
    php artisan migrate:fresh --seed
fi

php-fpm -D
nginx -g "daemon off;"
