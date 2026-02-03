#!make
include .env

IMAGE_VERSION ?= latest
DOCKER_REGISTRY ?= registry.linkbee.id/meamo

export IMAGE_VERSION
export DOCKER_REGISTRY

ps:
	@if [ "$(APP_ENV)" = "local" ]; then \
		docker compose -f docker-compose.local.yaml -p ${DOCKER_NAME} ps; \
	else \
		docker compose -f docker-compose.production.yaml -p ${DOCKER_NAME} ps; \
	fi

serve:
	@if [ "$(APP_ENV)" = "local" ]; then \
		docker compose -f docker-compose.local.yaml -p ${DOCKER_NAME} up -d; \
	else \
		docker compose -f docker-compose.production.yaml -p ${DOCKER_NAME} up -d; \
	fi

serve-with-util:
	@if [ "$(APP_ENV)" = "local" ]; then \
		docker compose -f docker-compose.local.yaml -f docker-compose.util.yaml -p ${DOCKER_NAME} up -d; \
	else \
		docker compose -f docker-compose.production.yaml -f docker-compose.util.yaml -p ${DOCKER_NAME} up -d; \
	fi

down:
	@if [ "$(APP_ENV)" = "local" ]; then \
		docker compose -f docker-compose.local.yaml -f docker-compose.util.yaml -p ${DOCKER_NAME} down; \
	else \
		docker compose -f docker-compose.production.yaml -f docker-compose.util.yaml -p ${DOCKER_NAME} down; \
	fi

shell:
	@if [ "$(APP_ENV)" = "local" ]; then \
		docker compose -f docker-compose.local.yaml -p ${DOCKER_NAME} exec -it web sh; \
	else \
		docker compose -f docker-compose.production.yaml -p ${DOCKER_NAME} exec -it web sh; \
	fi

docker-build-composer:
	docker build --build-arg IMAGE_VERSION=${IMAGE_VERSION} -f ops/${APP_ENV}/composer.Dockerfile -t meamo/composer:${IMAGE_VERSION} .

docker-build-frontend:
	docker build --build-arg IMAGE_VERSION=${IMAGE_VERSION} -f ops/${APP_ENV}/frontend.Dockerfile -t meamo/frontend:${IMAGE_VERSION} .

docker-build-cli:
	docker build --build-arg IMAGE_VERSION=${IMAGE_VERSION} -f ops/${APP_ENV}/cli.Dockerfile -t meamo/cli:${IMAGE_VERSION} .

docker-build-fpm-prod:
	docker build --build-arg IMAGE_VERSION=${IMAGE_VERSION} -f ops/${APP_ENV}/fpm.Dockerfile -t meamo/fpm:${IMAGE_VERSION} .

docker-build-web:
	docker build --build-arg IMAGE_VERSION=${IMAGE_VERSION} -f ops/${APP_ENV}/web.Dockerfile -t meamo/web:${IMAGE_VERSION} .

docker-build-local:
	docker build --build-arg IMAGE_VERSION=${IMAGE_VERSION} -f ops/local/Dockerfile -t meamo/web:${IMAGE_VERSION} .
docker-build-prod: docker-build-composer docker-build-frontend docker-build-cli docker-build-fpm-prod docker-build-web
