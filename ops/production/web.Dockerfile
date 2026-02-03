ARG IMAGE_VERSION=production

FROM meamo/frontend:${IMAGE_VERSION} AS frontend
FROM nginx:1.20-alpine

WORKDIR /opt/apps/meamo
COPY ops/production/nginx/nginx.conf.template /etc/nginx/templates/default.conf.template

COPY --from=frontend /opt/apps/meamo/public /opt/apps/meamo/public
