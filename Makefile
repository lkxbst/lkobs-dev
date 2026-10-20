.PHONY: help up down restart logs ps shell fresh test lint build dev export-fixture

DOCKER_COMPOSE = docker compose
APP_EXEC = $(DOCKER_COMPOSE) exec -T app
NVM_EXEC = bash -c 'export NVM_DIR="$$HOME/.nvm"; [ -s "$$NVM_DIR/nvm.sh" ] && . "$$NVM_DIR/nvm.sh"; cd frontend && nvm use >/dev/null &&

help: ## Mostra os comandos disponíveis
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-18s\033[0m %s\n", $$1, $$2}'

up: ## Sobe os containers do backend (API em http://localhost:8000)
	$(DOCKER_COMPOSE) up -d --build
	@$(DOCKER_COMPOSE) ps

down: ## Para e remove os containers do backend
	$(DOCKER_COMPOSE) down -t 1

restart: ## Reinicia os containers do backend rapidamente
	$(DOCKER_COMPOSE) --progress=plain restart -t 1
	@$(DOCKER_COMPOSE) ps
	@printf "\033[32m✔ Containers reiniciados com sucesso (http://localhost:8000)\033[0m\n"

ps: ## Mostra o status dos containers
	$(DOCKER_COMPOSE) ps

logs: ## Exibe logs dos containers
	$(DOCKER_COMPOSE) logs -f

shell: ## Abre um terminal bash dentro do container PHP 8.2
	$(DOCKER_COMPOSE) exec app bash

fresh: ## Recria o banco SQLite e popula com os seeders de placeholder
	$(APP_EXEC) sh -c "touch database/database.sqlite && php artisan migrate:fresh --seed --force"

export-fixture: ## Exporta o fixture JSON da API para o frontend
	$(APP_EXEC) php artisan app:export-fixture

test: ## Roda os testes do backend (Pest) e frontend (Vitest)
	$(APP_EXEC) ./vendor/bin/pest
	@if [ -f frontend/package.json ]; then $(NVM_EXEC) npm run test -- --run'; fi

lint: ## Roda análise estática (Larastan + Pint) e lint do frontend
	$(APP_EXEC) ./vendor/bin/pint --test
	$(APP_EXEC) ./vendor/bin/phpstan analyse --memory-limit=512M
	@if [ -f frontend/package.json ]; then $(NVM_EXEC) npm run lint && npm run check'; fi

build: ## Gera o build estático do frontend (Astro)
	$(NVM_EXEC) npm run build'

dev: ## Roda o servidor de desenvolvimento do frontend (Astro)
	$(NVM_EXEC) npm run dev'
