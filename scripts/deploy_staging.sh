#!/bin/bash

echo Deploy started

ssh -t $SSH_USER@$SSH_HOST -o StrictHostKeyChecking=no <<-EOF
cd $STAGING_APP_PATH &&
git pull origin development
docker-compose pull
docker-compose run --rm php-fpm composer install
docker-compose run --rm php-fpm php artisan migrate --force
docker-compose run --rm php-fpm php artisan db:seed
docker-compose run --rm php-fpm php artisan view:clear
docker-compose run --rm php-fpm composer dump-autoload -o
docker-compose run --rm frontend yarn install
docker-compose run --rm frontend yarn run prod

EOF