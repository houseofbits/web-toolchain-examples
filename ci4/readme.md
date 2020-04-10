**Playing around with CodeIgniter 4, Vue+Axios and BootstrapVue**
- [CodeIgniter 4](https://codeigniter4.github.io/userguide/intro/index.html)
- [Bootstrap Vue](https://bootstrap-vue.js.org/)

Setup
```
cd ci4
docker-compose build
docker-compose up -d
docker-compose exec php composer install
```
To rebuild Assets/
```
npm install
npm run build
```
To migrate DB
```
docker-compose exec php php spark migrate
docker-compose exec php php spark migrate:status
```
To populate DB with some test data
```
docker-compose exec php php spark db:seed ProductTestSeeder
```