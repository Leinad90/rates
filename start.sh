docker-compose down --remove-orphans
docker-compose pull
docker-compose build
docker-compose up -d
docker-compose run app composer install