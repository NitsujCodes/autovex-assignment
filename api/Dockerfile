FROM php:8.3-fpm AS compose_base

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY composer.json composer.lock ./

RUN chown -R www-data:www-data /var/www

USER www-data

RUN composer install --no-scripts --no-autoloader

USER root

COPY --chown=www-data:www-data . .

RUN composer dump-autoload --optimize

FROM compose_base AS laravel

RUN chmod -R 777 /var/www/storage /var/www/bootstrap/cache
EXPOSE 9000
