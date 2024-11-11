FROM php:8.1-fpm

# Copia de configuraciones opcionales de PHP
COPY custom.ini /usr/local/etc/php/conf.d/

# Instala extensiones si es necesario
RUN docker-php-ext-install mysqli pdo pdo_mysql
