FROM  newdeveloper/apache-php-composer
WORKDIR /var/www/html/
RUN apt update && apt upgrade php-intl -y && apt autoremove --purge -y && apt clean
EXPOSE 80
