FROM php:fpm

RUN apt-get update && apt-get install -y librabbitmq-dev libssh-dev \
    && docker-php-source extract \
    && mkdir /usr/src/php/ext/amqp \
    && curl -L https://github.com/php-amqp/php-amqp/archive/master.tar.gz | tar -xzC /usr/src/php/ext/amqp --strip-components=1 \
    && docker-php-ext-install amqp mysqli pdo pdo_mysql \
    && docker-php-source delete \
    && pecl install opcache xdebug \
    && docker-php-ext-enable pdo_mysql opcache xdebug

COPY configuration/* /usr/local/etc/php/conf.d/
