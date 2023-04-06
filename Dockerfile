FROM  newdeveloper/apache-php-composer
WORKDIR /var/www/html/
ONBUILD RUN composer install
EXPOSE 80
