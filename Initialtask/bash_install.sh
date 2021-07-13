#!/bin/bash
git clone https://github.com/partizan2dot0/ItransitionInitial.git
cd ItransitionInitial
git checkout NKTNEDU-106
git pull
cd Initialtask
composer update
docker kill $(docker ps -q)
docker rm $(docker ps -a -q)
docker-compose up -d
sleep 10
php bin/console doctrine:migrations:migrate -n
