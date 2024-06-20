FOLDERS=(
    "/var/www/html/storage/app/public"
    "/var/www/html/storage/framework/cache/data"
    "/var/www/html/storage/framework/sessions"
    "/var/www/html/storage/framework/testing"
    "/var/www/html/storage/framework/views"
    "/var/www/html/storage/logs"
    "/var/www/html/storage/debugbar"
)

for FOLDER in "${FOLDERS[@]}"
do
    if [ ! -d "$FOLDER" ]; then
        echo "$FOLDER is not a directory, creating directory"
        mkdir -p "$FOLDER"
    fi

    chmod -R 775 "$FOLDER"
    chown -R www-data:www-data "$FOLDER"
done


