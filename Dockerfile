# Menggunakan image PHP 8.1 FPM dengan Alpine
FROM php:8.1-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    git \
    libpng \
    libjpeg-turbo \
    freetype \
    libzip \
    mysql-client \
    && apk add --no-cache --virtual .build-deps \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo_mysql mysqli \
    && apk del --no-cache .build-deps

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Copy Nginx configuration
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copy entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /var/www/html

# Copy aplikasi
COPY . .

# Install dependencies (tanpa dev dependencies untuk production)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Optimize Laravel untuk production
RUN cp .env.example .env \
    && php artisan key:generate \
    && php artisan storage:link

# Set permissions
RUN mkdir -p /var/www/html/storage/framework/cache \
    && chown -R www-data:www-data /var/www/html

# Set PHP production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && echo "memory_limit = 256M" >> "$PHP_INI_DIR/conf.d/memory-limit.ini" \
    && echo "upload_max_filesize = 50M" >> "$PHP_INI_DIR/conf.d/upload.ini" \
    && echo "post_max_size = 50M" >> "$PHP_INI_DIR/conf.d/upload.ini" \
    && echo "max_execution_time = 300" >> "$PHP_INI_DIR/conf.d/execution-time.ini" \
    && echo "opcache.enable=1" >> "$PHP_INI_DIR/conf.d/opcache.ini"

EXPOSE 80

ENTRYPOINT ["entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]