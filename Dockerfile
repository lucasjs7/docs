FROM php:8.1-apache
RUN docker-php-ext-install fileinfo
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql
RUN a2enmod rewrite