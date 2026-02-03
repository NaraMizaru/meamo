ARG IMAGE_VERSION=production

FROM meamo/composer:${IMAGE_VERSION} AS composer_base
FROM node:22

COPY --from=composer_base /opt/apps/meamo /opt/apps/meamo

WORKDIR /opt/apps/meamo

RUN npm ci && \
    npm run build
