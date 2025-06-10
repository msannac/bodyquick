# Usa una imagen oficial de PHP con FPM
FROM php:8.2-fpm

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Instala dependencias del sistema necesarias
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

# Copia primero los archivos necesarios para aprovechar la cache de Docker
COPY package*.json ./

# Instala dependencias de Node (incluye vite)
RUN npm install --legacy-peer-deps

# Copia el resto del código de la app
COPY . .

# Ejecuta el build de Vite
RUN npm run build

# Instala las dependencias de PHP y optimiza el autoload
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Asigna permisos necesarios
RUN chown -R www-data:www-data storage bootstrap/cache

# Expone el puerto para PHP-FPM
EXPOSE 9000

# Comando por defecto
CMD ["php-fpm"]
