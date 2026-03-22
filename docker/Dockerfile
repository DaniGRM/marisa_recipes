FROM arm32v7/php:8.2-fpm-buster

# 🔥 FIX repositorios EOL
RUN sed -i 's|deb.debian.org|archive.debian.org|g' /etc/apt/sources.list \
    && sed -i 's|security.debian.org|archive.debian.org|g' /etc/apt/sources.list \
    && echo "Acquire::Check-Valid-Until false;" > /etc/apt/apt.conf.d/99no-check-valid

WORKDIR /var/www

# 1. Update básico
RUN apt-get update

# 2. Git
RUN apt-get install -y git

# 3. unzip
RUN apt-get install -y unzip

# 4. curl
RUN apt-get install -y curl

# 5. certificados
RUN apt-get install -y ca-certificates

# 6. libzip
RUN apt-get install -y libzip-dev

# 7. libonig (para mbstring)
RUN apt-get install -y libonig-dev

# 8. libxml
RUN apt-get install -y libxml2-dev

# 9. (OPCIONAL) libpng
RUN apt-get install -y libpng-dev

# 10. (OPCIONAL) libjpeg
RUN apt-get install -y libjpeg62-turbo-dev

# 11. (OPCIONAL) freetype
RUN apt-get install -y libfreetype6-dev

# ---- EXTENSIONES PHP ----

# 12. pdo_mysql
RUN docker-php-ext-install pdo_mysql

# 13. mbstring
RUN docker-php-ext-install mbstring

# 14. zip
RUN docker-php-ext-install zip

# 15. (OPCIONAL) gd
# RUN docker-php-ext-configure gd --with-freetype --with-jpeg
# RUN docker-php-ext-install gd

# Limpieza final
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN git config --global url."https://github.com/".insteadOf git@github.com:

COPY . /var/www
COPY --from=composer:2.6 /usr/bin/composer /usr/local/bin/composer

RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader

RUN mkdir -p storage bootstrap/cache && chmod -R 777 storage bootstrap/cache

# Copiar entrypoint para desarrollo con volumen
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

CMD ["php-fpm"]