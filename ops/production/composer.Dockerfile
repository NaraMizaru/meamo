FROM php:8.4-alpine AS composer_base

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ARG PHP_EXTS="bcmath ctype fileinfo mbstring pdo pdo_mysql gd pcntl zip"
ARG PHP_PECL_EXTS="redis"

RUN apk add --no-cache --virtual .build-deps ${PHPIZE_DEPS} \
        freetype-dev libjpeg-turbo-dev libpng-dev libzip-dev curl-dev oniguruma-dev libxml2-dev \
    && apk add --no-cache freetype libjpeg-turbo libpng libzip curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure zip \
    && docker-php-ext-install -j$(nproc) ${PHP_EXTS} \
    && pecl install ${PHP_PECL_EXTS} \
    && docker-php-ext-enable ${PHP_PECL_EXTS} \
    && apk del .build-deps

WORKDIR /opt/apps/meamo

COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress --no-scripts

COPY . .

RUN composer dump-autoload --optimize
