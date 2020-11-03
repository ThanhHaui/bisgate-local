FROM php:7-apache

RUN cd /etc/apache2/mods-enabled && ln -s ../mods-available/rewrite.load
RUN apt-get update && apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev
RUN pecl install mongodb-1.6.1 \
    &&  echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongo.ini
RUN docker-php-ext-install mysqli
