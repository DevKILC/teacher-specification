#!/usr/bin/env bash
set -e

container_mode=${CONTAINER_MODE:-app}
octane_server=${OCTANE_SERVER:-swoole}
echo "Container mode: $container_mode"

php() {
  su octane -c "php $*"
}

initialStuff() {
    php artisan optimize:clear; \
    php artisan package:discover --ansi; \
    php artisan event:cache; \
    echo "Generating Scribe documentation..."
    php artisan scribe:generate --force --ansi;
    # php artisan config:cache; \
    # php artisan route:cache;
}

applyPermissions() {
    echo "Applying permissions..."
    # Permissions for the Scribe directory
    mkdir -p /var/www/html/.scribe && \
    chown -R octane:octane /var/www/html/.scribe && \
    chmod -R 775 /var/www/html/.scribe && \
    
    # Permissions for the public directory
    chown -R octane:octane /var/www/html/public && \
    chmod -R 775 /var/www/html/public && \
    
    # Permissions for the resources directory
    chown -R octane:octane /var/www/html/resources && \
    chmod -R 775 /var/www/html/resources
}

if [ "$1" != "" ]; then
    exec "$@"
elif [ ${container_mode} = "app" ]; then
    echo "Octane server: $octane_server"
    initialStuff
    applyPermissions
    if [ ${octane_server}  = "swoole" ]; then
        exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.app.conf
    elif [ ${octane_server}  = "roadrunner" ]; then
        exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.app.roadrunner.conf
    else
        echo "Invalid Octane server supplied."
        exit 1
    fi
elif [ ${container_mode} = "horizon" ]; then
    initialStuff
    applyPermissions
    exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.horizon.conf
elif [ ${container_mode} = "scheduler" ]; then
    initialStuff
    exec supercronic /etc/supercronic/laravel
else
    echo "Container mode mismatched."
    exit 1
fi

# Run Scribe docs generation after all other processes
echo "Running Scribe documentation generation post-entrypoint."
php artisan scribe:generate --force --ansi
