FROM arm32v7/php:8.2-fpm-buster

WORKDIR /var/www
RUN apt-get update && apt-get install -y git unzip curl ca-certificates libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2.6 /usr/bin/composer /usr/local/bin/composer
RUN git config --global url."https://github.com/".insteadOf git@github.com:

CMD ["php-fpm"]