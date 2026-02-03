FROM php:8.4-fpm-alpine AS php_builder

ARG PHP_EXTS="pdo_mysql pcntl gd zip intl exif mysqli pdo pdo_pgsql pgsql bcmath opcache"
ARG PHP_PECL_EXTS="redis"

RUN apk add --no-cache \
    $PHPIZE_DEPS autoconf make gcc g++ \
    icu-dev libxml2-dev oniguruma-dev \
    libpng-dev jpeg-dev freetype-dev libwebp-dev \
    libzip-dev zlib-dev \
    postgresql-dev \
    nodejs npm

RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp

RUN docker-php-ext-install -j$(nproc) ${PHP_EXTS}
RUN pecl install ${PHP_PECL_EXTS} && docker-php-ext-enable ${PHP_PECL_EXTS}
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress --no-scripts
COPY . /var/www

RUN composer dump-autoload --optimize
RUN npm ci
RUN npm run build
FROM php:8.4-fpm-alpine AS runtime

RUN apk add --no-cache nginx \
    icu libjpeg-turbo libpng freetype libwebp libzip \
    php-pgsql

COPY --from=php_builder /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=php_builder /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

WORKDIR /var/www
COPY --from=php_builder --chown=www-data:www-data /var/www /var/www

COPY ops/web/nginx/nginx.conf /etc/nginx/nginx.conf
RUN mkdir -p /run/nginx

ENV PORT=8080
CMD ["sh", "-c", "sh /var/www/ops/nginx/startup.sh"]
