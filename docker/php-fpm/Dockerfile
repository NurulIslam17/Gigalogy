FROM php:8.2-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git curl libpq-dev libzip-dev unzip libxml2-dev \
    libpng-dev libjpeg-dev libfreetype6-dev libwebp-dev \
    libonig-dev libicu-dev && \
    rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-configure intl \
    && docker-php-ext-install intl

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install gd

RUN docker-php-ext-install pdo pdo_pgsql mbstring zip xml

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

COPY . /var/www

RUN composer install --no-interaction --prefer-dist --no-progress

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

USER www-data

CMD ["php-fpm"]
