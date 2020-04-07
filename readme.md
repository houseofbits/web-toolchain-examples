## Web toolchain examples ##

**ci3-doctrine**

Most basic setup of CodeIgniter3, DoctrineORM 2.7, Bootstrap4, CI3 HMVC Module
```
cd ci3-doctrine
npm install
docker-compose up -d
docker-compose exec php composer install
docker-compose exec php php doctrine.php orm:schema-tool:update --force
```

**ci4**

Explore features of CodeIgniter 4