FROM php:7.4-apache

WORKDIR /var/www/html

COPY . /var/www/html

RUN apt-get add --no-cache zip libzip-dev
RUN apt-get update && \
    apt-get install -y \
        libicu-dev \
        unzip && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl pdo pdo_mysql zip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-interaction --no-dev --optimize-autoloader

ENV APACHE_DOCUMENT_ROOT /var/www/html

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf && \
    a2enmod rewrite

EXPOSE 80

CMD ["apache2-foreground"]