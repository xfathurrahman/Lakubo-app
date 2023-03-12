# Gunakan image PHP 8.2 dengan FPM
FROM php:8.2-fpm

# Set working directory ke /var/www/html
WORKDIR /var/www/html

# Install dependensi yang dibutuhkan
RUN apt-get update && \
    apt-get install -y \
        libzip-dev \
        zip \
        unzip \
        git && \
    docker-php-ext-install pdo_mysql zip && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug

# Salin file konfigurasi PHP-FPM
COPY php-fpm.conf /usr/local/etc/php-fpm.d/zzz-docker.conf

# Salin file konfigurasi xdebug
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Salin source code Laravel ke container
COPY . .

# Jalankan perintah composer install
RUN composer install --prefer-dist --no-scripts --no-dev --no-autoloader && \
    composer clear-cache && \
    rm -rf /root/.composer/cache/*

# Generate autoload file
RUN composer dump-autoload --no-scripts --no-dev --optimize

# Set permission untuk storage dan bootstrap cache
RUN chmod -R 777 storage bootstrap/cache

# Gunakan image Nginx
FROM nginx:latest

# Salin file konfigurasi Nginx
COPY nginx.conf /etc/nginx/nginx.conf

# Salin konfigurasi virtual host
COPY app1.conf /etc/nginx/conf.d/app1.conf
COPY app2.conf /etc/nginx/conf.d/app2.conf
