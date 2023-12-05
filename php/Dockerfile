FROM php:8.2.7-fpm

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

RUN apt-get update && apt-get install -y \
		git \
		wget \
		libpng-dev \
		libzip-dev \
		libicu-dev \
	&& docker-php-ext-install \
		gd \
		zip \
		intl \
		opcache \
		pdo_mysql

COPY ./php.ini-development /usr/local/etc/php/php.ini