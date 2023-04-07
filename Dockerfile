FROM  newdeveloper/apache-php-composer
WORKDIR /var/www/html/
RUN apt update && apt upgrade -y && apt install php-intl
EXPOSE 80
