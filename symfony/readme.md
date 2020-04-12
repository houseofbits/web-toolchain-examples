**Symfony - basic create/edit/view controller**

- [Symfony docs](https://symfony.com/doc/current/index.html#gsc.tab=0)

Setup
```
docker-compose exec php composer install
npm install
npm run build
```
Run migrations
```
docker-compose exec php php bin/console doctrine:migrations:migrate
```
