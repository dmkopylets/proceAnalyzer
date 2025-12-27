DOCKER_COMPOSE = docker-compose
EXEC_PHP       = $(DOCKER_COMPOSE) exec php-fpm
EXEC_HTTP       = $(DOCKER_COMPOSE) exec apache
DOCKER_COMPOSE_FILE = -f docker-compose.yml

local-compose-file:
	$(eval DOCKER_COMPOSE_FILE = -f docker-compose.yml)

dc-build:
	$(DOCKER_COMPOSE) $(DOCKER_COMPOSE_FILE) build php-fpm

dc-up:
	$(DOCKER_COMPOSE) $(DOCKER_COMPOSE_FILE) up -d php-fpm

dc-down:
	$(DOCKER_COMPOSE) $(DOCKER_COMPOSE_FILE) down --remove-orphans

bash:
	$(EXEC_PHP) sh

first-run:
	$(EXEC_PHP) sh -c " composer setup"

clear-cache:
	$(EXEC_PHP) sh -c "  php artisan route:clear &&  php artisan config:cache && php artisan view:clear && php artisan route:clear && php artisan optimize:clear"

swagger-generate:
	$(EXEC_PHP) sh -c " php artisan l5-swagger:generate"

migrate:
	$(EXEC_PHP) sh -c " php artisan migrate"
