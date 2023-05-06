FROM php:8.2-alpine


RUN apk --no-cache add git unzip zip icu-dev libzip-dev $PHPIZE_DEPS
RUN docker-php-ext-install pdo pdo_mysql zip

WORKDIR /var/www/ticket-service

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

COPY . .

ENV APP_ENV=test

RUN composer install