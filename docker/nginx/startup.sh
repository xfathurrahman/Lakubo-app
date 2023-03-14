#!/bin/bash

if [ ! -f /etc/nginx/ssl/default.crt ]; then
    openssl genrsa -out "/etc/nginx/ssl/default.key" 2048
    openssl req -new -key "/etc/nginx/ssl/default.key" -out "/etc/nginx/ssl/default.csr" -subj "/CN=default/O=default/C=UK"
    openssl x509 -req -days 365 -in "/etc/nginx/ssl/default.csr" -signkey "/etc/nginx/ssl/default.key" -out "/etc/nginx/ssl/default.crt"
    chmod 644 /etc/nginx/ssl/default.key
fi


# cron job to restart nginx every 6 hour
(crontab -l ; echo "0 0 */4 * * nginx -s reload") | crontab -

# Start crond in background
crond -l 2 -b


#* * * * * root nginx -s reload >> /var/log/cron.log

# Start nginx in foreground
echo "NGINX started, daemon will restart every 6 hours now.";
nginx

