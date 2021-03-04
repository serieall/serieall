.PHONY: lint tests \
		install-dependencies update-dependencies \
		start-db stop-db \
		start-db-tests stop-db-tests \
		start-redis stop-redis

default: start-db start-redis

lint:
	vendor/bin/php-cs-fixer fix --dry-run

lint-fix:
	vendor/bin/php-cs-fixer fix

tests:
	vendor/bin/phpunit --configuration phpunit.xml

tests:
	php -f /usr/bin/composer dump-autoload
	vendor/bin/phpunit --configuration phpunit.xml

install-dependencies:
	composer install

update-dependencies:
	composer update

start-db:
	docker run \
		--name serieall-mysql \
		-p 3307:3306 \
		-v /var/lib/mysql/serieall-dev:/var/lib/mysql \
		-e MYSQL_DATABASE="serieall" \
		-e MYSQL_ROOT_PASSWORD="serieall" \
		-d mysql:5.7

stop-db:
	docker stop serieall-mysql
	docker rm serieall-mysql

start-db-tests:
	docker run \
		--name serieall-tests-mysql \
		-p 3306:3306 \
		-e MYSQL_DATABASE="serieall-tests" \
		-e MYSQL_ROOT_PASSWORD="serieall" \
		-d mysql:5.7

stop-db-tests:
	docker stop serieall-tests-mysql
	docker rm serieall-tests-mysql

start-redis:
	docker run \
		--name serieall-redis \
		-p 6379:6379 \
		-d redis

stop-redis:
	docker stop serieall-redis
	docker rm serieall-redis
