FROM php:7.4-apache

RUN apt-get update && \
    apt-get install -y git zip unzip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

CMD ["apache2-foreground"]

RUN a2enmod rewrite