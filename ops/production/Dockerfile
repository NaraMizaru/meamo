FROM php:8.4-fpm-alpine AS php_builder

ARG PHP_EXTS="bcmath ctype fileinfo mbstring pdo pdo_mysql gd pcntl zip"
ARG PHP_PECL_EXTS="redis"

RUN apk add --no-cache \
    $PHPIZE_DEPS autoconf make gcc g++ \
    icu-dev libxml2-dev oniguruma-dev \
    libpng-dev jpeg-dev freetype-dev libwebp-dev \
    libzip-dev zlib-dev \
    nodejs npm

RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp

RUN docker-php-ext-install -j$(nproc) ${PHP_EXTS}
RUN pecl install ${PHP_PECL_EXTS} && docker-php-ext-enable ${PHP_PECL_EXTS}
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /opt/apps/meamo
COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress --no-scripts
COPY . /opt/apps/meamo
RUN composer dump-autoload --optimize

RUN npm ci
RUN npm run build

FROM php:8.4-fpm-alpine AS runtime

RUN apk add --no-cache nginx \
    icu libjpeg-turbo libpng freetype libwebp libzip \
    php-pgsql

COPY --from=php_builder /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=php_builder /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

WORKDIR /opt/apps/meamo
COPY --from=php_builder --chown=www-data:www-data /opt/apps/meamo /opt/apps/meamo
COPY ops/web/nginx/nginx.conf /etc/nginx/nginx.conf

RUN mkdir -p /run/nginx

ENV PORT=8080

CMD ["sh", "-c", "sh /opt/apps/meamo/ops/web/nginx/startup.sh"]
