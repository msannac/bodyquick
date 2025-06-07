# Dockerfile para Laravel
FROM php:8.2-fpm

WORKDIR /var/www/html

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip git unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copia el código de la app
COPY . .

# Instala las dependencias de PHP y optimiza el autoloader
RUN composer install --no-dev --optimize-autoloader \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Da permisos a storage y bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Exponer el puerto 9000 para PHP-FPM
EXPOSE 9000

# Comando de inicio
CMD ["php-fpm"]
