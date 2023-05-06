FROM php:8.2-alpine

RUN apk add --no-cache linux-headers autoconf openssl-dev g++ make pcre-dev icu-dev zlib-dev libzip-dev && \
    docker-php-ext-install bcmath intl opcache zip sockets pdo pdo_mysql && \
    apk del --purge autoconf g++ make

WORKDIR /var/www/ticket-service

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./

RUN composer install --no-scripts --no-interaction

RUN ./vendor/bin/rr get-binary --location /usr/local/bin

COPY . .

CMD ["rr", "serve", "-c", ".rr.dev.yaml"]