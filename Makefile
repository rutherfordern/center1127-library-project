start-local:
	php -S localhost:8080 -t public public/index.php

load-date-db:
	php bin/console load-publisher
	php bin/console load-author
	php bin/console load-book

delete-empty-authors:
	php bin/console delete-book-empty-author
