# install PHP
FROM php:8.2-fpm

# install node
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash && apt-get install -y nodejs

# install requied apps and extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libicu-dev \
&& docker-php-ext-install intl

# install composer
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

# install symfony CLI
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN apt install symfony-cli

# set workdir
WORKDIR /var/www
COPY . .

# install node dependencies
RUN npm install