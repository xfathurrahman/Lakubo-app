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
php artisan optimize:clear
npm run build

if [ ! -d "public/storage" ]; then
    php artisan storage:link
else
    echo "Storage directory already linked"
fi

# Connect to MySQL server and create database
if ! mysql -h "$MYSQL_HOST" -u root -p"$MYSQL_ROOT_PASSWORD" -e "use $MYSQL_DATABASE"; then
  echo "Creating new database $MYSQL_DATABASE..."
  mysql -h "$MYSQL_HOST" -u root -p"$MYSQL_ROOT_PASSWORD" -e "CREATE DATABASE $MYSQL_DATABASE;"
else
  # Check if the database is empty
  if mysql -h "$MYSQL_HOST" -u root -p"$MYSQL_ROOT_PASSWORD" "$MYSQL_DATABASE" -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$MYSQL_DATABASE'" | grep -q -v "0"; then
    echo "Database exists and has data, skipping migrations..."
  else
    echo "Database exists but is empty, running migrations..."
    php artisan migrate --seed
  fi
fi
# Create user and grant privileges on the newly created database
if ! mysql -h "$MYSQL_HOST" -u root -p"$MYSQL_ROOT_PASSWORD" -e "SELECT User FROM mysql.user WHERE User='$MYSQL_USER'" | grep -q "$MYSQL_USER"; then
  echo "Creating new user $MYSQL_USER..."
  mysql -h "$MYSQL_HOST" -u root -p"$MYSQL_ROOT_PASSWORD" -e "CREATE USER '$MYSQL_USER'@'%' IDENTIFIED BY '$MYSQL_PASSWORD';"
  mysql -h "$MYSQL_HOST" -u root -p"$MYSQL_ROOT_PASSWORD" -e "GRANT ALL PRIVILEGES ON $MYSQL_DATABASE.* TO '$MYSQL_USER'@'%';"
  mysql -h "$MYSQL_HOST" -u root -p"$MYSQL_ROOT_PASSWORD" -e "FLUSH PRIVILEGES;"
  mysql -h "$MYSQL_HOST" -u root -p"$MYSQL_ROOT_PASSWORD" -e "SHOW GRANTS FOR '$MYSQL_USER'@'%';"
fi

php-fpm -D
nginx -g "daemon off;"
