**Symfony - basic create/edit/view controller**

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
