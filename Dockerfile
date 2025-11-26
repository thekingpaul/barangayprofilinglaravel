# PHP 8.3 with required extensions
FROM php:8.3-fpm

# Install system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    git zip unzip curl \
    sqlite3 libsqlite3-dev \
    libpng-dev libzip-dev \
    libicu-dev \
    && docker-php-ext-install pdo pdo_sqlite zip gd intl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install PHP dependencies
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader

# Setup Laravel environment
RUN cp .env.example .env
RUN php artisan key:generate

# Expose port
EXPOSE 8000

# Start Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
