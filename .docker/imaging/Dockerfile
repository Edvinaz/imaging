FROM php:8.2.3-fpm-bullseye

WORKDIR /var/www/html

RUN apt-get update
RUN apt-get -y install less vim git iputils-ping zip libzip-dev libpng-dev libxml2-dev mariadb-client
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev && \
    docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && \
    docker-php-ext-install gd

RUN docker-php-ext-install zip bcmath exif intl opcache pcntl mysqli pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
