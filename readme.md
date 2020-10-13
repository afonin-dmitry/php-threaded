Запуск: 
```bash
docker-compose build && docker-compose up
```

Заполнить очередь: 
```bash
docker exec -it php-zts bin/console app:publisher
```

Прогнать тесты:
```bash
docker exec -it php-zts bin/phpunit
```

Логи: **/var/log**
