.PHONY: setup up down build migrate seed test shell pint logs

COMPOSE = docker compose
APP = $(COMPOSE) exec app

setup: build up install env migrate seed
	@echo "Ready: http://localhost:$${APP_PORT:-8080}"
	@echo "Login: alice@example.com / password"

env:
	@test -f .env || cp .env.example .env
	$(APP) php artisan key:generate --force --ansi

build:
	$(COMPOSE) build

up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

install:
	$(APP) composer install --no-interaction

migrate:
	$(APP) php artisan migrate --force

seed:
	$(APP) php artisan db:seed --force

test:
	$(APP) php artisan test

shell:
	$(APP) bash

pint:
	$(APP) ./vendor/bin/pint

logs:
	$(COMPOSE) logs -f
