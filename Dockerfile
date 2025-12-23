FROM php:8.4-cli

WORKDIR /app

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y unzip git libzip-dev \
    && docker-php-ext-install ctype iconv

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

# Copy the entire project
COPY . .

# Install PHP dependencies without interaction
RUN composer install --no-interaction --no-cache

# Default command
CMD ["php", "bin/console"]
