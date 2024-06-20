#!/usr/bin/env sh

# Test $DB_CONNECTION
if "$DB_CONNECTION"admin ping -h "$DB_HOST" -u root -p"$DB_ROOT_PASSWORD" -s; then
echo ""
    # Create database if it doesn't exist yet
    if ! $DB_CONNECTION -h "$DB_HOST" -u root -p"$DB_ROOT_PASSWORD" -e "use $DB_DATABASE" -s; then
        $DB_CONNECTION -h "$DB_HOST" -u root -p"$DB_ROOT_PASSWORD" -e "CREATE DATABASE $DB_DATABASE;"
        printf '%-110s%s\n' "[$DB_CONNECTION]  |  Creating new database '$DB_DATABASE'..." "DONE"
        echo ""
    else
        printf '%-110s%s\n' "[$DB_CONNECTION]  |  Database '$DB_DATABASE' already exists, skipping creation..." "DONE"
        echo ""
    fi
    # Create user and grant privileges on the newly created database if it doesn't exist yet
    if ! $DB_CONNECTION -h "$DB_HOST" -u root -p"$DB_ROOT_PASSWORD" -e "SELECT User FROM $DB_CONNECTION.user WHERE User='$DB_USERNAME'" | grep -q "$DB_USERNAME"; then
        printf '%-110s%s\n' "[$DB_CONNECTION]  |  User '$DB_USERNAME' not found, Creating new user '$DB_USERNAME'..." "DONE"
        echo ""
        printf '%-110s%s\n' "[$DB_CONNECTION]  |  granting privileges on database '$DB_DATABASE' to  User '$DB_USERNAME'..." "DONE"
        create_user_query="CREATE USER '$DB_USERNAME'@'%' IDENTIFIED BY '$DB_PASSWORD'; GRANT ALL PRIVILEGES ON $DB_DATABASE.* TO '$DB_USERNAME'@'%'; FLUSH PRIVILEGES;"
        $DB_CONNECTION -h "$DB_HOST" -u root -p"$DB_ROOT_PASSWORD" -e "$create_user_query"
        echo ""
    else # grant privileges if user already exists
        grant_query="GRANT ALL PRIVILEGES ON $DB_DATABASE.* TO '$DB_USERNAME'@'%'; FLUSH PRIVILEGES;"
        $DB_CONNECTION -h "$DB_HOST" -u root -p"$DB_ROOT_PASSWORD" -e "$grant_query"
        printf '%-110s%s\n' "[$DB_CONNECTION]  |  User '$DB_USERNAME' found, granting privileges on database '$DB_DATABASE'..." "DONE"
        echo ""
    fi
    # check if database is empty
    table_count=$($DB_CONNECTION -h "$DB_HOST" -u root -p"$DB_ROOT_PASSWORD" -se "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$DB_DATABASE'")
    if [ -n "$table_count" ] && echo "$table_count" | grep -qE '^[0-9]+$'; then
        if [ "$table_count" -eq 0 ]; then
            printf '%-110s%s\n' "[$DB_CONNECTION]  |  Database '$DB_DATABASE' is empty, running migrations..." "DONE"
            echo ""
            php artisan migrate --seed --force
        else
            printf '%-110s%s\n' "[$DB_CONNECTION]  |  Database '$DB_DATABASE' is not empty, skipping migrations..." "DONE"
            echo ""
        fi
    else
        printf '%-110s%s\n' "[$DB_CONNECTION]  |  Failed to get table count from database '$DB_DATABASE'." "FAILED"
    fi
else
    echo "[$DB_CONNECTION]  |  $DB_CONNECTION is unavailable - sleeping"
    echo ""
fi
