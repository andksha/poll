#!make

start:
	docker-compose up -d

#start web only
swo:
	docker-compose up -d poll_nginx poll_phpfpm

stop:
	docker-compose stop

queue_work:
	docker-compose exec $(d) poll_phpfpm php artisan queue:work

queue_restart:
	docker-compose exec $(d) poll_phpfpm php artisan queue:restart

init:
	docker-compose exec poll_phpfpm composer install
	docker-compose exec poll_phpfpm php artisan key:generate
	docker-compose exec poll_phpfpm php artisan migrate --seed
	docker-compose exec poll_phpfpm php artisan route:clear
	docker-compose exec poll_phpfpm php artisan config:clear
	docker-compose exec poll_phpfpm php artisan cache:clear
	docker-compose exec poll_phpfpm usermod -aG sudo www-data
	docker-compose exec poll_phpfpm chown -R www-data:www-data storage bootstrap/cache
	docker-compose exec poll_phpfpm chgrp -R www-data storage bootstrap/cache
	docker-compose exec poll_phpfpm chmod -R 755 storage/logs

permissions:
	docker-compose exec poll_phpfpm php artisan route:clear
	docker-compose exec poll_phpfpm php artisan config:clear
	docker-compose exec poll_phpfpm php artisan cache:clear
	docker-compose exec poll_phpfpm usermod -aG sudo www-data
	docker-compose exec poll_phpfpm chown -R www-data:www-data storage bootstrap/cache
	docker-compose exec poll_phpfpm chgrp -R www-data storage bootstrap/cache
	docker-compose exec poll_phpfpm chmod -R 755 storage/logs

refresh:
	docker-compose exec poll_phpfpm chmod -R 755 /application1/logs/

update:
	docker-compose exec poll_phpfpm chmod -R 755 /application1/logs/

supervisor_start:
	docker-compose exec poll_queue service supervisor stop
	docker-compose exec poll_queue service supervisor start
	docker-compose exec poll_queue supervisorctl reread
	docker-compose exec poll_queue supervisorctl update
	docker-compose exec poll_queue supervisorctl start laravel-worker:*