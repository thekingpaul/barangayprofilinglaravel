FROM php:8.3-fpm

# System dependencies
RUN apt-get update && apt-get install -y \
    git zip unzip curl sqlite3 libsqlite3-dev \
    libpng-dev libzip-dev libicu-dev nodejs npm \
    && docker-php-ext-install pdo pdo_sqlite zip gd intl

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy project
COPY . .

# PHP dependencies
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader

# Node dependencies and Vite build
RUN npm install
RUN npm run build
RUN npm run dev

# SQLite
RUN mkdir -p /var/data && touch /var/data/database.sqlite && chmod -R 777 /var/data

# Writable dirs
RUN chmod -R 777 storage bootstrap/cache

# Laravel environment
RUN if [ ! -f .env ]; then cp .env.example .env; fi
RUN php artisan key:generate

# Clear caches
RUN php artisan config:clear \
    && php artisan cache:clear \
    && php artisan route:clear \
    && php artisan view:clear

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
