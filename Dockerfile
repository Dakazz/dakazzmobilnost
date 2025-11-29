# base image
FROM php:8.2-apache

# set working directory
WORKDIR /var/www/html

# kopiraj fajlove u container
COPY . /var/www/html

# instaliraj dependencies
RUN apt-get update && apt-get install -y \
        libpq-dev \
        && docker-php-ext-install pdo pdo_pgsql

# postavi permisije **nakon što su fajlovi kopirani**
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# expose port
EXPOSE 80

# start apache
CMD ["apache2-foreground"]
