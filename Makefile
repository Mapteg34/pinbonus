#!make

%:
	@:

up:
	docker-compose build && \
	docker-compose up -d && \
	docker-compose exec -u www-data app bash -c "php artisan migrate"
