# Use PHP 8.4 FPM
FROM php:8.4-fpm

# Install system dependencies including MySQL
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    nodejs \
    npm \
    default-mysql-server \
    default-mysql-client \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions required by Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy all project files
COPY . .

# Ensure .env exists
RUN cp .env.example .env || true

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Generate application key
RUN php artisan key:generate

# Set permissions
RUN chown -R www-data:www-data /var/www

# Expose ports (Laravel + MySQL)
EXPOSE 8000 3306

# Start MySQL and Laravel
CMD service mysql start && \
    mysql -uroot -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'ankit'; FLUSH PRIVILEGES;" && \
    mysql -uroot -pankit -e "CREATE DATABASE IF NOT EXISTS rps_api;" && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=$PORT
