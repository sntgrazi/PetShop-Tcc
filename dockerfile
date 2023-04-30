FROM php:7.4-apache

RUN apt-get update && \
    apt-get install -y zlib1g-dev && \
    docker-php-ext-install pdo pdo_mysql && \
    docker-php-ext-install zip && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug

WORKDIR /var/www/html

COPY . /var/www/html

RUN composer install --no-dev --no-scripts --no-progress --no-suggest --optimize-autoloader

EXPOSE 80

CMD ["apache2-foreground"]