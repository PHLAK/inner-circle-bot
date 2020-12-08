FROM php:8.0-apache
LABEL maintainer="Chris Kankiewicz <Chris@ChrisKankiewicz.com>"

COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer
COPY ./.docker/php/config/php.ini /usr/local/etc/php/php.ini
COPY ./.docker/apache2/config/000-default.conf /etc/apache2/sites-available/000-default.conf

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_HOME="/tmp"
ENV PATH="vendor/bin:${PATH}"

RUN a2enmod rewrite

RUN apt-get update && apt-get --assume-yes install libicu-dev tzdata

RUN docker-php-ext-configure intl && docker-php-ext-install intl opcache \
    && pecl install xdebug && docker-php-ext-enable xdebug
