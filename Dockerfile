FROM php:8.2-apache

# Instalar dependencias del sistema, incluyendo netcat para el script de espera
RUN apt-get update && apt-get install -y \
    libpng-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    zip \
    curl \
    unzip \
    git \
    netcat-traditional && \ 
    apt-get clean && rm -rf /var/lib/apt/lists/* 

# Instalar extensiones PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Copiar el código de la aplicación
COPY . /var/www/html

# Configurar Apache para apuntar al directorio public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Instalar Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Instalar dependencias de Composer (ejecutar ANTES de cambiar permisos para que funcione como root)
# Considera correr composer install --no-dev --optimize-autoloader para producción
RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist --optimize-autoloader
# RUN composer update # Generalmente no querrías 'update' en el build, sino 'install'

# Copiar y dar permisos al script de entrada
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Establecer permisos para storage y bootstrap/cache DESPUÉS de composer install
# Y ANTES de cambiar a www-data si lo hicieras
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Configurar el script como punto de entrada
ENTRYPOINT ["docker-entrypoint.sh"]

# Comando por defecto que ejecutará el entrypoint script al final (iniciar Apache)
CMD ["apache2-foreground"]