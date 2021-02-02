.DEFAULT_GOAL := ci

DOCKER_COMPOSE_TEST=docker-compose -f docker-compose.yml -f docker-compose-test.yml

.PHONY: install
install:
	docker run --rm --volume $(CURDIR):/app composer install --ignore-platform-reqs

.PHONY: spin-up
spin-up: start wait-for-storage

.PHONY: start
start: install
	docker-compose up -d --build

.PHONY: stop
stop:
	docker-compose down --remove-orphans

.PHONY: ci
ci: stop start prepare-storage test stop

.PHONY: prepare-test
prepare-test:
	$(DOCKER_COMPOSE_TEST) run --rm tester ./vendor/bin/codecept build

.PHONY: test
test: prepare-test
	$(DOCKER_COMPOSE_TEST) run --rm tester ./vendor/bin/codecept run

.PHONY: wait-for-storage
wait-for-storage:
	./docker/mysql/wait.sh

.PHONY: prepare-storage
prepare-storage: wait-for-storage
	docker-compose exec php-fpm ./bin/console core:persistence:event-store:create \
		&& docker-compose exec php-fpm ./bin/console core:persistence:read-model:create-indices
