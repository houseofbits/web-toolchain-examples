**Zend Framework(Laminas) - CRUD application example + SlmQueue**

Based on laminas/laminas-mvc-skeleton. 

Setup 
```
docker-compose up -d --build
docker-compose exec php composer install
docker-compose exec php php bin/doctrine orm:schema-tool:update --force
```

Run SlmQueue jobs
``` 
php public/index.php queue doctrine main --start
```

Debug queue jobs
``` 
php public/index.php queue doctrine main --recover

docker-compose exec mysql mysql -u dummy -pdummy dummy
mysql> select * from queue_default;
```

