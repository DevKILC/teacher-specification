# Use the official PHP image as the base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    unzip \
    zip \
    nodejs \
    npm \
    libpq-dev

# Install PHP extensions, including PostgreSQL and Zip
RUN docker-php-ext-install pdo_pgsql zip mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the existing application directory contents
COPY . /var/www/html

# Install project dependencies using Composer
RUN composer install --optimize-autoloader --no-dev --ignore-platform-req=ext-zip

# Install NPM packages for Vite
RUN npm install && npm run build

# Change ownership of application
RUN chown -R www-data:www-data /var/www/html

# Set the user to www-data (the default user for PHP-FPM)
USER www-data

# Expose the port for PHP
EXPOSE 9000

# Start the PHP-FPM server
CMD ["php-fpm"]
