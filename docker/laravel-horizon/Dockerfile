#
#--------------------------------------------------------------------------
# Image Setup
#--------------------------------------------------------------------------
#

# no memcached

FROM php:8.1-alpine

RUN apk --update add wget \
  curl \
  git \
  build-base \
  libmemcached-dev \
  libmcrypt-dev \
  libxml2-dev \
  zlib-dev \
  autoconf \
  cyrus-sasl-dev \
  libgsasl-dev \
  supervisor \
  oniguruma-dev \
  procps \
  libzip-dev \
  postgresql-dev \
  gmp-dev

# Install soap extention

# Install for image manipulation

# Install the PHP pcntl extention

# Install the PHP zip extention

# Install the PHP pdo_mysql extention

# Install the PHP pdo_pgsql extention

# Install the PHP bcmath extension

# Install the PHP intl extention

# Install the PHP gmp extention
#Install Sockets package:
RUN docker-php-ext-install gmp soap exif pcntl zip pdo_mysql pdo_pgsql bcmath intl sockets


#####################################
# PHPRedis:
#####################################
RUN pecl install redis && docker-php-ext-enable redis

#####################################
# Imagick:
#####################################
RUN apk add imagemagick-dev
RUN pecl install imagick && \
  docker-php-ext-enable imagick

#####################################
# GD:
#####################################

# Install the PHP gd library
RUN apk add libpng-dev jpeg-dev libjpeg-turbo-dev freetype-dev
RUN docker-php-ext-install gd && \
  docker-php-ext-configure gd --with-freetype --with-jpeg && \
  docker-php-ext-install gd


# Add a non-root user to help install ffmpeg:
ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

RUN addgroup -g ${PGID} sail && \
  adduser -D -G sail -u ${PUID} sail

#Install BZ2:
ARG INSTALL_BZ2=false
RUN if [ ${INSTALL_BZ2} = true ]; then \
  apk --update add bzip2-dev; \
  docker-php-ext-install bz2 \
  ;fi

###########################################################################
# PHP GnuPG:
###########################################################################

ARG INSTALL_GNUPG=true

RUN set -eux; if [ ${INSTALL_GNUPG} = true ]; then \
  apk add --no-cache --no-progress --virtual BUILD_DEPS_PHP_GNUPG gpgme-dev; \
  apk add --no-cache --no-progress gpgme; \
  if [ $(php -r "echo PHP_MAJOR_VERSION;") = "8" ]; then \
  pecl install gnupg-1.5.0RC2; \
  else \
  pecl install gnupg; \
  fi; \
  docker-php-ext-enable gnupg; \
  fi


#--------------------------------------------------------------------------
# Optional Supervisord Configuration
#--------------------------------------------------------------------------
#
# Modify the ./supervisor.conf file to match your App's requirements.
# Make sure you rebuild your container with every change.
#

COPY supervisord.conf /etc/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]

#
#--------------------------------------------------------------------------
# Optional Software's Installation
#--------------------------------------------------------------------------
#
# If you need to modify this image, feel free to do it right here.
#
# -- Your awesome modifications go here -- #


#--------------------------------------------------------------------------
# Check PHP version
#--------------------------------------------------------------------------
#

RUN php -v

#
#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------
#

WORKDIR /etc/supervisor/conf.d/
