FROM  newdeveloper/apache-php-composer
WORKDIR /var/www/html/
ONBUILD CMD composer install
EXPOSE 80
