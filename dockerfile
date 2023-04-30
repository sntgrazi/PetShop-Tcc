# Define a imagem base
FROM php:8.0-apache

# Atualiza o gerenciador de pacotes e instala as dependências necessárias
RUN apt-get update && \
    apt-get install -y \
        libicu-dev \
        libzip-dev \
        unzip && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl pdo pdo_mysql zip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-interaction --no-dev --optimize-autoloader

# Copia o código fonte da sua aplicação para o diretório /var/www/html
COPY . /var/www/html/

# Expõe a porta 80 para o tráfego HTTP
EXPOSE 80

# Inicia o servidor Apache
CMD ["apache2-foreground"]