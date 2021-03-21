placeholder:
	@echo "------------------------------------------------------------------"
	@echo "| COMMAND            | DESCRIPTION                               |"
	@echo "------------------------------------------------------------------"
	@echo "| init               | Up from the ground                        |"
	@echo "| start              | Up all docker containers                  |"
	@echo "| stop               | Down all docker containers                |"
	@echo "| restart            | Restart all docker containers             |"
	@echo "| ------------------ | ----------------------------------------- |"
	@echo "| cache              | Clear cache                               |"
	@echo "| ------------------ | ----------------------------------------- |"
	@echo "| deptrac            | Run deptrac                               |"
	@echo "| phpcs              | Run phpcs                                 |"
	@echo "| psalm              | Run psalm                                 |"
	@echo "| ecs                | Object Calisthenics rules                 |"
	@echo "| php-test           | Run phpunit tests                         |"
	@echo "| postman-test       | Run postman tests                         |"
	@echo "| pre-commit         | Run all check command before commit       |"

init:
	docker network create game
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

deptrac:
	docker-compose exec php sh -c "vendor/bin/deptrac analyze depfile/dictionary.yaml --no-cache"
	docker-compose exec php sh -c "vendor/bin/deptrac analyze depfile/crossword.yaml --no-cache"
	docker-compose exec php sh -c "vendor/bin/deptrac analyze depfile/shared_kernel.yaml --no-cache"
	@echo "deptrac done"

phpcs:
	docker-compose exec php sh -c "vendor/bin/phpcs --standard=PSR2 src/"
	@echo "phpcs done"

psalm:
	docker-compose exec php sh -c "vendor/bin/psalm"
	@echo "psalm done"

ecs:
	docker-compose exec php sh -c "vendor/bin/ecs check src"
	@echo "ecs done"

rector:
	docker-compose exec php sh -c "vendor/bin/rector process"
	@echo "rector done"

php-test:
	docker-compose exec php sh -c "vendor/bin/phpunit tests/"

postman-test:
	docker-compose run newman

pre-commit: deptrac phpcs psalm ecs rector php-test postman-test
	@: