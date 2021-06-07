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
	@echo "| ci-test            | Run ci tests                              |"
	@echo "| pre-commit         | Run all check command before commit       |"

init:
	docker network create game
	cd ./docker && docker-compose down -v --remove-orphans
	cd ./docker && docker-compose pull
	cd ./docker && docker-compose build
	cd ./docker && docker-compose up -d

start:
	cd ./docker && docker-compose up -d

stop:
	cd ./docker && docker-compose down

restart: stop start

cache:
	docker/scripts/console cache:clear
	@echo "Cache is clean"

deptrac:
	docker/scripts/php "vendor/bin/deptrac analyze depfile.yaml --no-cache"
	docker/scripts/php "vendor/bin/deptrac analyze src/Game/config/depfile.yaml --no-cache"
	docker/scripts/php "vendor/bin/deptrac analyze src/Crossword/config/depfile.yaml --no-cache"
	docker/scripts/php "vendor/bin/deptrac analyze src/Dictionary/config/depfile.yaml --no-cache"
	@echo "deptrac done"

phpcs:
	docker/scripts/php "vendor/bin/phpcs --standard=PSR12 src/"
	@echo "phpcs done"

psalm:
	docker/scripts/php "vendor/bin/psalm"
	@echo "psalm done"

ecs:
	docker/scripts/php "vendor/bin/ecs check src"
	@echo "ecs done"

rector:
	docker/scripts/php "vendor/bin/rector process"
	@echo "rector done"

php-test:
	docker/scripts/php "vendor/bin/phpunit"

postman-test:
	cd ./docker && docker-compose run newman

ci-test:
	cd ./docker && docker-compose -f docker-compose.test.yml run analyzer
	cd ./docker && docker-compose -f docker-compose.test.yml run tests

pre-commit: deptrac phpcs psalm ecs rector php-test postman-test
	@: