# Use PHP 8.2 FPM Alpine as the base image
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nodejs \
    npm \
    postgresql-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql zip gd

# Configure GD extension
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project files
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --no-scripts --no-progress --prefer-dist

# Install Node.js dependencies
RUN npm install

# Build assets with Vite (uncomment if needed)
# RUN npm run build

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]