# Use an official PHP image with FPM
FROM php:8.2-fpm

# set working dir
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    libzip-dev \
    unzip \
    zip \
    libonig-dev \
    libxml2-dev \
    gnupg2 \
    sudo \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpng-dev \
    libwebp-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions required by Laravel
RUN docker-php-ext-install pdo pdo_pgsql zip intl mbstring xml gd

# Install composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Create www-data user (uid/gid 1000 to match typical dev user, adjust if needed)
RUN groupadd -g 1000 www && useradd -u 1000 -ms /bin/bash -g www www

# Copy composer.lock and composer.json to install dependencies
COPY composer.lock composer.json /var/www/

# Composer install (no dev in production; we will use dev in docker-compose for convenience)
RUN composer install --no-interaction --prefer-dist --no-progress

# Copy application code
COPY . /var/www

# Set permissions for storage and bootstrap cache
RUN chown -R www:www /var/www/storage /var/www/bootstrap/cache

# Expose port for php-fpm socket is via unix socket; container doesn't expose tcp by default
USER www

# Default command
CMD ["php-fpm"]
