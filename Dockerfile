FROM php:8.1-apache


RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libssl-dev \
    ca-certificates \
    && update-ca-certificates

RUN ls -l /etc/ssl/certs/ca-certificates.crt

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN pecl install mongodb-1.20.0 && docker-php-ext-enable mongodb

RUN openssl version


WORKDIR /var/www/html


COPY composer.json composer.lock /var/www/html/


RUN composer install --no-scripts --no-interaction

COPY . /var/www/html/

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN a2enmod rewrite

EXPOSE 80

CMD ["apache2-foreground"]