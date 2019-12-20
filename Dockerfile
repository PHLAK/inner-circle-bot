# Install PHP dependencies
FROM composer:1.9 AS php-dependencies
COPY . /app
RUN composer install --working-dir /app --ignore-platform-reqs \
    --no-cache --no-dev --no-interaction

# Build application image
FROM php:7.4-apache as application
LABEL maintainer="The Inner Circle <https://github.com/TheInnerCircleO>"

COPY --from=php-dependencies /app /var/www/html

RUN a2enmod rewrite

# Build (local) development image
FROM application as development
COPY ./.docker/php/config/php.dev.ini /usr/local/etc/php/php.ini
COPY ./.docker/apache2/config/000-default.dev.conf /etc/apache2/sites-available/000-default.conf
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Build production image
FROM application as production
COPY ./.docker/php/config/php.prd.ini /usr/local/etc/php/php.ini
COPY ./.docker/apache2/config/000-default.prd.conf /etc/apache2/sites-available/000-default.conf
RUN docker-php-ext-install opcache
