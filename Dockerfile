# Imagen oficial de PHP con Apache
FROM php:8.2-apache

=COPY . /var/www/html/

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
     && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
     && composer install --no-dev --optimize-autoloader
