env:
	@docker-compose exec --user=docker php bash

chown:
	@docker-compose exec --user=docker php chown -R docker:www-data ./

helper:
	php artisan ide-helper:eloquent && \
	php artisan ide-helper:generate && \
	php artisan ide-helper:meta

cs:
	composer cs

cs-fix:
	composer cs-fix

docker: docker-up

docker-start: docker-up

docker-up:
	@docker-compose up -d --build --remove-orphans

docker-stop:
	@docker-compose stop

docker-restart:
	@docker-compose restart

