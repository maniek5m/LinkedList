FROM php:8.4-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    git \
    autoconf \
    gcc \
    make \
    && docker-php-ext-install zip

RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY docker/php/conf.d/99-xdebug.ini /usr/local/etc/php/conf.d/99-xdebug.ini

EXPOSE 80

CMD ["apache2-foreground"]

