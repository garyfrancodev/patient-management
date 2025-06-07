# Usa la imagen oficial de PHP 8.2 con FPM
FROM php:8.2-fpm

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Instala dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    librdkafka-dev \
    libffi-dev \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring exif pcntl bcmath intl ffi \
    && pecl install rdkafka \
    && docker-php-ext-enable rdkafka

# Copia Composer desde imagen oficial
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Habilita FFI
RUN echo "ffi.enable=1" > /usr/local/etc/php/conf.d/ffi.ini

# Copia tu código fuente (hazlo después de instalar dependencias si quieres cache)
COPY . .

# Permisos (puedes mover esto a docker-entrypoint.sh si prefieres que se ejecute en runtime)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Instala dependencias PHP (puede ajustarse a `--no-dev` en producción)
RUN composer install --no-dev --optimize-autoloader

# Copia script de inicio personalizado
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# No expongas puertos si usas Docker Compose, el puerto se mapea allá
# EXPOSE 9000

# Comando por defecto
CMD ["/usr/local/bin/docker-entrypoint.sh"]
