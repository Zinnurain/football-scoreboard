# Use official PHP 8.4 CLI image
FROM php:8.4-cli

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    unzip git libzip-dev zip \
    && docker-php-ext-install ctype iconv

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

# Set working directory
WORKDIR /app

# Copy all project files
COPY . .

# Copy only composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-cache

# Default command
CMD ["php", "bin/console"]
