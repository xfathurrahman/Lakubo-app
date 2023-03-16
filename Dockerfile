FROM php:8.1-fpm as php

ENV PHP_OPCACHE_ENABLE=1
ENV PHP_OPCACHE_ENABLE_CLI=0
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=1
ENV PHP_OPCACHE_REVALIDATE_FREQ=1

RUN usermod -u 1000 www-data

RUN apt-get update -y
RUN apt-get install -y unzip nginx libpq-dev libcurl4-gnutls-dev libfreetype6-dev libjpeg62-turbo-dev
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_mysql bcmath curl opcache -j$(nproc) gd
# RUN docker-php-ext-enable opcache

ARG APP_NAME
WORKDIR /var/www/${APP_NAME}

COPY --chown=www-data:www-data . .

COPY ./docker/php/php.ini /usr/local/etc/php/php.ini
COPY ./docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN chmod -R 755 /var/www/${APP_NAME}/storage
RUN chmod -R 755 /var/www/${APP_NAME}/bootstrap

ENTRYPOINT [ "docker/entrypoint.sh" ]
