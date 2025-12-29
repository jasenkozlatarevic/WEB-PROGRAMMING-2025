FROM php:8.2-apache

# PHP ekstenzije
RUN docker-php-ext-install pdo pdo_mysql

# Apache rewrite (FlightPHP treba)
RUN a2enmod rewrite

# Backend ide u web root
COPY backend/ /var/www/html/

WORKDIR /var/www/html/

EXPOSE 80
