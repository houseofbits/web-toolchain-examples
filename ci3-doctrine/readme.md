**Most basic setup of CodeIgniter3, DoctrineORM 2.7, Bootstrap4, HMVC Module**

- [CodeIgniter 3](https://codeigniter.com/userguide3/index.html)
- [DoctrineORM](https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/index.html)

Setup
```
cd ci3-doctrine
npm install
docker-compose up -d
docker-compose exec php composer install
docker-compose exec php php doctrine.php orm:schema-tool:update --force
```