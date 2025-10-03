FROM php:8.4-apache

RUN a2enmod rewrite

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql

COPY ./config/httpd.conf /etc/apache2/sites-available/000-default.conf

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./config/xdebug.ini          /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY ./config/error_reporting.ini /usr/local/etc/php/conf.d/error_reporting.ini
