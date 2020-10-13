Запуск: 
```bash
docker-compose up
```

Заполнить очередь: 
```bash
sudo docker exec -it php-zts bin/console app:publisher
```

Прогнать тесты:
```bash
sudo docker exec -it php-zts bin/phpunit
```

Логи: **/var/log**
