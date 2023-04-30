FROM php:7.4-apache

RUN apt-get update && \
    apt-get install -y git zip unzip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

RUN sed -i -e 's!/var/www/html!/app!' /etc/apache2/sites-available/*.conf && \
    sed -i -e 's!/var/www/!/app/!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

ENV APACHE_DOCUMENT_ROOT /app

EXPOSE 80

CMD ["apache2-foreground"]