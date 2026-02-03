ARG IMAGE_VERSION=production

FROM meamo/composer:${IMAGE_VERSION} AS composer_base
FROM meamo/frontend:${IMAGE_VERSION} AS frontend

FROM php:8.4-fpm-alpine

ARG PHP_EXTS="bcmath ctype fileinfo mbstring pdo pdo_mysql gd pcntl zip"
ARG PHP_PECL_EXTS="redis"

WORKDIR /opt/apps/meamo

RUN apk add --no-cache --virtual .build-deps ${PHPIZE_DEPS} \
        freetype-dev libjpeg-turbo-dev libpng-dev libzip-dev curl-dev oniguruma-dev libxml2-dev \
    && apk add --no-cache freetype libjpeg-turbo libpng libzip curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure zip \
    && docker-php-ext-install -j$(nproc) ${PHP_EXTS} \
    && pecl install ${PHP_PECL_EXTS} \
    && docker-php-ext-enable ${PHP_PECL_EXTS} \
    && apk del .build-deps

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini && \
    sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 600M/g' /usr/local/etc/php/php.ini && \
    sed -i 's/post_max_size = 8M/post_max_size = 600M/g' /usr/local/etc/php/php.ini

USER  www-data

COPY --from=composer_base --chown=www-data /opt/apps/meamo /opt/apps/meamo
COPY --from=frontend --chown=www-data /opt/apps/meamo/public /opt/apps/meamo/public

RUN php artisan event:cache && \
    php artisan route:cache && \
    php artisan view:cache
