.PHONY: up
up:
	@docker-compose up -d

.PHONY: install
install:
	@docker-compose up -d
	@docker exec app sh -c "composer install"

.PHONY: migration
migration:
	docker exec app sh -c "php bin/console make migration"

.PHONY: migrate
migrate:
	@docker exec app sh -c "php bin/console d:m:m"

.PHONY: ssh
ssh:
	@docker exec -it app sh

.PHONY: test
test:
	@docker-compose -f docker-compose.test.yaml up -d
	@docker exec test-app sh -c "APP_ENV=test ./bin/console --no-interaction d:m:m"
	@docker exec test-app sh -c "APP_ENV=test ./bin/console d:f:l --no-interaction"
	@docker exec test-app sh -c "APP_ENV=test ./vendor/bin/phpunit"
	@docker-compose -f docker-compose.test.yaml down
