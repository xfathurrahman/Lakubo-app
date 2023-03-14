#!/bin/bash

# Destination of env file inside container
ENV_FILE="/var/www/.env"

# Loop through XDEBUG, PHP_IDE_CONFIG and REMOTE_HOST variables and check if they are set.
# If they are not set then check if we have values for them in the env file, if the env file exists. If we have values
# in the env file then add exports for these in in the ~./bashrc file.
for VAR in XDEBUG PHP_IDE_CONFIG REMOTE_HOST
do
  if [ -z "${!VAR}" ] && [ -f "${ENV_FILE}" ]; then
    VALUE=$(grep $VAR $ENV_FILE | cut -d '=' -f 2-)
    if [ ! -z "${VALUE}" ]; then
      # Before adding the export we clear the value, if set, to prevent duplication.
      sed -i "/$VAR/d"  ~/.bashrc
      echo "export $VAR=$VALUE" >> ~/.bashrc;
    fi
  fi
done

# If there is still no value for the REMOTE_HOST variable then we set it to the default of host.docker.internal. This
# value will be sufficient for windows and mac environments.
if [ -z "${REMOTE_HOST}" ]; then
  REMOTE_HOST="host.docker.internal"
  sed -i "/REMOTE_HOST/d"  ~/.bashrc
  echo "export REMOTE_HOST=\"$REMOTE_HOST\"" >> ~/.bashrc;
fi

# Source the .bashrc file so that the exported variables are available.
. ~/.bashrc

# Start the cron service.
service cron start

# Toggle xdebug
if [ "true" == "$XDEBUG" ] && [ ! -f /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ]; then
  # Remove PHP_IDE_CONFIG from cron file so we do not duplicate it when adding below
  sed -i '/PHP_IDE_CONFIG/d' /etc/cron.d/laravel-scheduler
  if [ ! -z "${PHP_IDE_CONFIG}" ]; then
    # Add PHP_IDE_CONFIG to cron file. Cron by default does not load enviromental variables. The server name, set here, is
    # used by PHPSTORM for path mappings
    echo -e "PHP_IDE_CONFIG=\"$PHP_IDE_CONFIG\"\n$(cat /etc/cron.d/laravel-scheduler)" > /etc/cron.d/laravel-scheduler
  fi
  # Enable xdebug estension and set up the docker-php-ext-xdebug.ini file with the required xdebug settings
  docker-php-ext-enable xdebug && \
  echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
  echo "xdebug.remote_autostart=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
  echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
  echo "xdebug.remote_host=$REMOTE_HOST" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini;

elif [ -f /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ]; then
  # Remove PHP_IDE_CONFIG from cron file if already added
  sed -i '/PHP_IDE_CONFIG/d' /etc/cron.d/laravel-scheduler
  # Remove Xdebug config file disabling xdebug
  rm -rf /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
fi

exec "$@"