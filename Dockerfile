# Use PHP 8.3 as the base image
FROM php:8.3-fpm

# Install system dependencies, zip, gd, and PostgreSQL extension
RUN apt-get update -y && apt-get install -y \
    openssl \
    zip \
    unzip \
    git \
    curl \
    nodejs \
    npm \
    libpq-dev \
    libpng-dev \
    libzip-dev \
    && docker-php-ext-install pdo_pgsql gd zip

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /app

# Copy the application code
COPY . /app

# Install PHP dependencies using Composer
RUN composer install --no-dev --optimize-autoloader

# Install Node.js dependencies and build frontend assets
RUN npm install
RUN npm run build

# Expose the application on port 9000
EXPOSE 9000

# Command to start the Laravel application on port 9000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]
