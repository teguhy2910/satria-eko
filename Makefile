# Docker commands for Satria Eko application

.PHONY: help build build-dev up down restart logs shell composer test clean

# Default target
help:
	@echo "Available commands:"
	@echo "  make build      - Build production Docker image"
	@echo "  make build-dev  - Build development Docker image"
	@echo "  make up         - Start development environment"
	@echo "  make up-prod    - Start production environment"
	@echo "  make down       - Stop and remove containers"
	@echo "  make restart    - Restart development environment"
	@echo "  make logs       - Show container logs"
	@echo "  make shell      - Open shell in app container"
	@echo "  make composer   - Run composer command (e.g., make composer CMD=\"install\")"
	@echo "  make artisan    - Run artisan command (e.g., make artisan CMD=\"migrate\")"
	@echo "  make test       - Run tests"
	@echo "  make clean      - Remove unused Docker resources"

# Build production image
build:
	docker build -t satria-eko:latest .

# Build development image
build-dev:
	docker build -f Dockerfile.dev -t satria-eko:dev .

# Start development environment
up:
	docker-compose up -d

# Start production environment
up-prod:
	docker-compose -f docker-compose.prod.yml up -d

# Stop and remove containers
down:
	docker-compose down

# Restart development environment
restart: down up

# Show container logs
logs:
	docker-compose logs -f

# Open shell in app container
shell:
	docker-compose exec app bash

# Run composer command
composer:
	docker-compose exec app composer $(CMD)

# Run artisan command
artisan:
	docker-compose exec app php artisan $(CMD)

# Run tests
test:
	docker-compose exec app php artisan test

# Clean unused Docker resources
clean:
	docker system prune -f

# Database commands
db-shell:
	docker-compose exec db mysql -u root -p

db-backup:
	docker-compose exec db mysqldump -u root -p$(shell docker-compose exec db printenv MYSQL_ROOT_PASSWORD) $(shell docker-compose exec db printenv MYSQL_DATABASE) > backup_$(shell date +%Y%m%d_%H%M%S).sql

# Development utilities
npm-install:
	docker-compose exec app npm install

npm-dev:
	docker-compose exec app npm run dev

npm-build:
	docker-compose exec app npm run build

# Production deployment
deploy: build
	docker tag satria-eko:latest your-registry/satria-eko:latest
	docker push your-registry/satria-eko:latest