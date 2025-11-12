install: setup

setup:
	composer install
	cp -n .env.example .env
	php artisan key:gen --ansi
	npm ci
	npm run build

migrate:
	php artisan migrate

test:
	php artisan test

test-coverage:
	XDEBUG_MODE=coverage php artisan test --coverage-clover build/logs/clover.xml

lint:
	composer phpcs

start:
	php artisan serve --host 0.0.0.0

start-frontend:
	npm run dev
