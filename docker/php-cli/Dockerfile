FROM php:cli

RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && pecl install xdebug \
    && docker-php-ext-enable pdo_mysql xdebug
