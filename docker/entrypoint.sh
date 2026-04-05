#!/bin/sh
set -e

# Set Laravel environment based on APP_ENV or default to production
if [ -z "$APP_ENV" ]; then
    export APP_ENV=production
fi

# Generate application key if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" == "base64:" ]; then
    echo "Generating Laravel application key..."
    php artisan key:generate --force
fi

# Clear and cache configuration based on environment
if [ "$APP_ENV" == "production" ]; then
    echo "Caching configuration for production..."
    php artisan config:cache
    php artisan route:cache
else
    echo "Clearing cache for development..."
    php artisan config:clear
    php artisan route:clear
fi

# Set proper permissions for storage and bootstrap cache
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

# Start supervisor
exec "$@"