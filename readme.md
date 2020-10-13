Запуск: docker-compose build && docker-compose up

Заполнить очередь: sudo docker exec -it php-zts bin/console app:publisher

Тесты: sudo docker exec -it php-zts bin/phpunit
