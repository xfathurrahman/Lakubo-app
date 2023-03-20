#!/bin/bash

set -e

#check if vendor directory exists
if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction
fi

#check if .env file exists
if [ ! -f ".env" ]; then
    echo "Creating env file for env $APP_ENV"
    cp .env.example .env
else
    echo "env file exists."
fi

# composer commands
php artisan key:generate --ansi
php artisan config:clear
php artisan view:clear
php artisan cache:clear
php artisan optimize:clear

#check if node_modules exists
if [ ! -d "node_modules" ]; then
    npm update
fi

#check if public/build exists
if [ ! -d "public/build" ]; then
    npm run build
fi

#check if storage directory already linked
if [ ! -d "public/storage" ]; then
    php artisan storage:link --ansi
fi

# Test MySQL connection
if mysqladmin ping -s -h "$MYSQL_HOST" -u root -p"$MYSQL_ROOT_PASSWORD"; then
echo ""
    # Create database if it doesn't exist yet
    if ! mysql -s -h "$MYSQL_HOST" -u root -p"$MYSQL_ROOT_PASSWORD" -e "use $MYSQL_DATABASE"; then
        mysql -h "$MYSQL_HOST" -u root -p"$MYSQL_ROOT_PASSWORD" -e "CREATE DATABASE $MYSQL_DATABASE;"
        printf '%-110s%s\n' "[MySQL]  |  Creating new database '$MYSQL_DATABASE'..." "DONE"
        echo ""
    else
        printf '%-110s%s\n' "[MySQL]  |  Database '$MYSQL_DATABASE' already exists, skipping creation..." "DONE"
        echo ""
    fi
    # Create user and grant privileges on the newly created database if it doesn't exist yet
    if ! mysql -h "$MYSQL_HOST" -u root -p"$MYSQL_ROOT_PASSWORD" -e "SELECT User FROM mysql.user WHERE User='$MYSQL_USER'" | grep -q "$MYSQL_USER"; then
        printf '%-110s%s\n' "[MySQL]  |  User '$MYSQL_USER' not found, Creating new user '$MYSQL_USER'..." "DONE"
        echo ""
        printf '%-110s%s\n' "[MySQL]  |  granting privileges on database '$MYSQL_DATABASE' to  User '$MYSQL_USER'..." "DONE"
        create_user_query="CREATE USER '$MYSQL_USER'@'%' IDENTIFIED BY '$MYSQL_PASSWORD'; GRANT ALL PRIVILEGES ON $MYSQL_DATABASE.* TO '$MYSQL_USER'@'%'; FLUSH PRIVILEGES;"
        mysql -h "$MYSQL_HOST" -u root -p"$MYSQL_ROOT_PASSWORD" -e "$create_user_query"
        echo ""
    else # grant privileges if user already exists
        grant_query="GRANT ALL PRIVILEGES ON $MYSQL_DATABASE.* TO '$MYSQL_USER'@'%'; FLUSH PRIVILEGES;"
        mysql -h "$MYSQL_HOST" -u root -p"$MYSQL_ROOT_PASSWORD" -e "$grant_query"
        printf '%-110s%s\n' "[MySQL]  |  User '$MYSQL_USER' found, granting privileges on database '$MYSQL_DATABASE'" "DONE"
        echo ""
    fi
    # check if database is empty
    table_count=$(mysql -h "$MYSQL_HOST" -u root -p"$MYSQL_ROOT_PASSWORD" -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$MYSQL_DATABASE'" -s --silent)
    if [ $table_count -eq 0 ]; then
        printf '%-110s%s\n' "[MySQL]  |  Database '$MYSQL_DATABASE' is empty, running migrations..." "DONE"
        echo ""
        php artisan migrate --seed
    else
        printf '%-110s%s\n' "[MySQL]  |  Database '$MYSQL_DATABASE' is not empty, skipping migrations..." "DONE"
        echo ""
    fi
else
    echo "[MySQL]  |  MySQL is unavailable - sleeping"
    echo ""
fi

php-fpm -D
nginx -g "daemon off;"
