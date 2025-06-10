# Dockerfile para Laravel
FROM php:8.2-fpm

WORKDIR /var/www/html

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip git unzip curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Instala Node.js y npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copia los archivos de npm primero para aprovechar la cache de Docker
COPY package*.json ./

# Instala dependencias de npm
RUN npm install --legacy-peer-deps

# Copia el resto del código de la app (incluye vite.config.mjs y resources/)
COPY . .

# Compila los assets
RUN npm run build

# Instala las dependencias de PHP y optimiza el autoloader
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Da permisos a storage y bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Exponer el puerto 9000 para PHP-FPM
EXPOSE 9000

# Comando de inicio
CMD ["php-fpm"]
