# install PHP
FROM php:8.2-fpm

# install required apps
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libicu-dev \
    nodejs \
    npm \
&& docker-php-ext-install intl

# install composer
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

# install symfony CLI
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN apt install symfony-cli

# I AM NOT SURE WHAT IT REALLY DOES
WORKDIR /var/www

# install npm dependencies
RUN npm install
