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
		docker compose -f docker-compose.production.yaml -p ${DOCKER_NAME} exec -it fpm sh; \
	fi

docker-build-local:
	docker build --build-arg IMAGE_VERSION=${IMAGE_VERSION} -f ops/local/Dockerfile -t meamo/web:${IMAGE_VERSION} .
docker-build-prod:
	docker build --build-arg IMAGE_VERSION=${IMAGE_VERSION} -f ops/production/Dockerfile -t meamo/web:${IMAGE_VERSION} .
