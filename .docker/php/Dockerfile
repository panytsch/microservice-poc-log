FROM php:7.4.2-fpm

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y libzip-dev && \
    apt-get install -y librabbitmq-dev && \
    docker-php-ext-install pcntl && \
    pecl install xdebug-2.9.2 && \
    docker-php-ext-install zip && \
    docker-php-ext-install bcmath && \
    docker-php-ext-install sockets && \
    docker-php-ext-enable sockets bcmath xdebug zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer