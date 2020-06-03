git submodule init
git submodule update

./init.sh

cd laradock

docker-compose up -d nginx mysql mailhog

docker-compose exec workspace bash

composer install

php artisan key:generate
