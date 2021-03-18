placeholder:
	@echo "----------------------------------------------------------"
	@echo "| COMMAND            | DESCRIPTION                       |"
	@echo "----------------------------------------------------------"
	@echo "| init               | Up from the ground                |"
	@echo "| start              | Up all docker containers          |"
	@echo "| stop               | Down all docker containers        |"
	@echo "| restart            | Restart all docker containers     |"
	@echo "| ------------------ | --------------------------------- |"
	@echo "| cache              | Clear cache                       |"
	@echo "| ------------------ | --------------------------------- |"
	@echo "| postman-test       | Run postman tests                 |"
	@echo "| phpcs              | Run phpcs                         |"
	@echo "| psalm              | Run psalm                         |"
	@echo "| php-test           | Run phpunit tests                 |"
	@echo "| pre-commit         | phpcs psalm test-run postman-test |"

init:
	docker-compose down -v --remove-orphans
	docker-compose pull
	docker-compose build
	docker-compose up -d

start:
	docker-compose up -d

stop:
	docker-compose down

restart: stop start

cache:
	rm -rf code/var/cache/*
	@echo "Cache is clean"

phpcs:
	docker-compose exec php sh -c "vendor/bin/phpcs --standard=PSR2 src/"
	@echo "phpcs done"

psalm:
	docker-compose exec php sh -c "vendor/bin/psalm"
	@echo "psalm done"

php-test:
	docker-compose exec php sh -c "vendor/bin/phpunit tests/"

postman-test:
	docker-compose run newman

pre-commit: phpcs psalm php-test postman-test
	@: