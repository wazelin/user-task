FROM php:fpm

RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && pecl install xdebug \
    && docker-php-ext-enable pdo_mysql xdebug

COPY configuration/* /usr/local/etc/php/conf.d/
