#!/bin/bash

# start up project (app and db docker containers)
docker-compose --project-name=fususapp up --detach

# composer
docker exec -it fususapp_app bash -c "composer install"

# npm install, npm run dev
docker exec -it fususapp_app bash -c "npm install"
docker exec -it fususapp_app bash -c "npm run dev"

# run migrations
docker exec -it fususapp_app bash -c "php artisan migrate"

# seed testing data
docker exec -it fususapp_app bash -c "php artisan db:seed --class=RandomDataSeeder"
