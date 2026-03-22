#!/bin/sh
set -e

# Si hay composer.json y no existe vendor, instalar dependencias
if [ -f composer.json ] && [ ! -d vendor ]; then
    composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader
fi

exec "$@"