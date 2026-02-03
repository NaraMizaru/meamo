FROM composer:2 AS composer_build

WORKDIR /opt/apps/meamo
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-progress \
    --no-scripts

COPY . .
RUN composer dump-autoload --optimize

FROM node:22-alpine AS frontend_build

WORKDIR /opt/apps/meamo
COPY --from=composer_build /opt/apps/meamo /opt/apps/meamo

RUN npm ci
RUN npm run build

FROM php:8.4-fpm-alpine AS app

ARG PHP_EXTS="bcmath ctype fileinfo mbstring pdo pdo_mysql gd pcntl zip"
ARG PHP_PECL_EXTS="redis"

WORKDIR /opt/apps/meamo
RUN apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        freetype-dev libjpeg-turbo-dev libpng-dev \
        libzip-dev oniguruma-dev libxml2-dev \
    && apk add --no-cache \
        freetype libjpeg-turbo libpng libzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) ${PHP_EXTS} \
    && pecl install ${PHP_PECL_EXTS} \
    && docker-php-ext-enable ${PHP_PECL_EXTS} \
    && apk del .build-deps

COPY --from=frontend_build /opt/apps/meamo /opt/apps/meamo
RUN chown -R www-data:www-data \
    storage bootstrap/cache

USER www-data
RUN php artisan event:cache && \
    php artisan route:cache && \
    php artisan view:cache

FROM nginx:1.25-alpine

WORKDIR /opt/apps/meamo
COPY ops/production/nginx/nginx.conf.template \
     /etc/nginx/templates/default.conf.template
COPY --from=app /opt/apps/meamo/public /opt/apps/meamo/public
