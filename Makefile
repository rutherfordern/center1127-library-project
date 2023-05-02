start-local:
	php -S localhost:8080 -t public public/index.php

install:
	composer install

install-db:
	php bin/console doctrine:database:create
	php bin/console doctrine:migrations:migrate

load-date-db:
	php bin/console load-publisher
	php bin/console load-author
	php bin/console load-book

delete-empty-authors:
	php bin/console delete-book-empty-author

lint:
	php vendor/bin/phpcs --standard=PSR12 src
