FROM php:7.4-fpm

RUN apt-get update && \
    apt-get install -y \
        libicu-dev \
        libzip-dev \
        unzip && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl pdo pdo_mysql zip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-interaction --no-dev --optimize-autoloader

COPY . /var/www/html

WORKDIR /var/www/html

EXPOSE 9000