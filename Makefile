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
	rm -rf ../code/var/cache/*
	@echo "Cache is clean"

deptrac:
	cd ./docker && docker-compose exec php sh -c "vendor/bin/deptrac analyze depfile/modules.yaml --no-cache"
	cd ./docker && docker-compose exec php sh -c "vendor/bin/deptrac analyze depfile/game.yaml --no-cache"
	cd ./docker && docker-compose exec php sh -c "vendor/bin/deptrac analyze depfile/dictionary.yaml --no-cache"
	cd ./docker && docker-compose exec php sh -c "vendor/bin/deptrac analyze depfile/crossword.yaml --no-cache"
	cd ./docker && docker-compose exec php sh -c "vendor/bin/deptrac analyze depfile/shared_kernel.yaml --no-cache"
	@echo "deptrac done"

phpcs:
	cd ./docker && docker-compose exec php sh -c "vendor/bin/phpcs --standard=PSR12 src/"
	@echo "phpcs done"

psalm:
	cd ./docker && docker-compose exec php sh -c "vendor/bin/psalm"
	@echo "psalm done"

ecs:
	cd ./docker && docker-compose exec php sh -c "vendor/bin/ecs check src"
	@echo "ecs done"

rector:
	cd ./docker && docker-compose exec php sh -c "vendor/bin/rector process"
	@echo "rector done"

php-test:
	cd ./docker && docker-compose exec php sh -c "vendor/bin/phpunit"

postman-test:
	cd ./docker && docker-compose run newman

ci-test:
	cd ./docker && docker-compose -f docker-compose.test.yml run tests

pre-commit: deptrac phpcs psalm ecs rector php-test postman-test
	@: