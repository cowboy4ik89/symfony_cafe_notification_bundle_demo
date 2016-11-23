FROM php:7.0-fpm
 
RUN useradd -ms /bin/bash docker
 
USER docker
 
WORKDIR /app

COPY configs/php-fpm.conf /etc/php-fpm.conf