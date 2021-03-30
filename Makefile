.DEFAULT_GOAL := ci

.PHONY: install
install:
	docker run --rm --volume $(CURDIR):/app composer install --ignore-platform-reqs

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
	docker-compose exec php-fpm ./vendor/bin/codecept build

.PHONY: test
test: prepare-test
	docker-compose exec php-fpm ./vendor/bin/codecept run

.PHONY: prepare-storage
prepare-storage:
	docker-compose exec php-fpm ./bin/console core:persistence:event-store:create \
		&& docker-compose exec php-fpm ./bin/console core:persistence:projection:create-indices

.PHONY: replay-events
replay-events:
	docker-compose exec php-fpm ./bin/console core:persistence:event-store:replay
