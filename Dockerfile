# Use PHP 8.4 with FPM
FROM php:8.4-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpng-dev \
    libicu-dev \
    && docker-php-ext-install pdo pdo_mysql zip intl gd mbstring

# Install Composer globally
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files first (cache optimization)
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Copy the rest of the application
COPY . .

# Generate application key
RUN php artisan key:generate --force

# Expose Laravel default port
EXPOSE 8000

# Start Laravel server using Render's $PORT
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
