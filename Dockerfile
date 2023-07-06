FROM php:8.2-fpm as php

ARG APP_NAME

RUN usermod -u 1000 www-data

RUN apt-get update -y
RUN apt-get install -y unzip nginx libpq-dev libcurl4-gnutls-dev libfreetype6-dev libjpeg62-turbo-dev default-mysql-client libzip-dev

RUN curl -fsSL https://deb.nodesource.com/setup_19.x | bash - && apt-get install -y nodejs

RUN npm install -g npm@latest

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_mysql bcmath curl -j$(nproc) gd opcache zip

WORKDIR /var/www/${APP_NAME}

COPY --chown=www-data:www-data . .

COPY ./docker/php/php.ini /usr/local/etc/php/php.ini
COPY ./docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN touch /var/www/${APP_NAME}/storage/logs/laravel.log

RUN chmod -R 775 /var/www/${APP_NAME}/storage/*
RUN chmod -R 775 /var/www/${APP_NAME}/bootstrap/*

ENTRYPOINT [ "docker/entrypoint.sh" ]