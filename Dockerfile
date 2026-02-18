# Stage 1: PHP + Composer
FROM php:8.4-fpm

WORKDIR /var/www/html

# Install system dependencies + PostgreSQL dev library
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev \
    libxml2-dev libcurl4-openssl-dev pkg-config \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring xml curl zip gd

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project
COPY . .

# Git safe directory
RUN git config --global --add safe.directory /var/www/html

# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expose PHP-FPM port
EXPOSE 9000

CMD ["php-fpm"]