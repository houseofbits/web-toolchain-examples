**Zend Framework(Laminas) - CRUD application example**

Based on laminas/laminas-mvc-skeleton

Setup 
```
docker-compose up -d --build
docker-compose exec php composer install
docker-compose exec php php bin/doctrine orm:schema-tool:update --force
```

