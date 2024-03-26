# Use the official PHP 8.2 image as base
FROM php:8.2

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Laravel installer
RUN composer global require laravel/installer

# Add Composer bin directory to PATH
ENV PATH="${PATH}:/root/.composer/vendor/bin"

# Install npm
RUN npm install -g npm@latest

# Expose port 8000 for Laravel development server
EXPOSE 8080

# Start Laravel development server
CMD php artisan serve --host=0.0.0.0 --port=8080
