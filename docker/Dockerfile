# Imagen base PHP 8.2 FPM multi-arquitectura
FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring bcmath exif pcntl gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Crear directorio de trabajo
WORKDIR /var/www

# Copiar todo el proyecto al contenedor
COPY . /var/www

# Instalar dependencias
RUN composer install --no-dev --optimize-autoloader

# Evitar problemas de permisos (opcional para dev)
RUN mkdir -p storage bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache
# Comando por defecto (PHP-FPM)
CMD ["php-fpm"]