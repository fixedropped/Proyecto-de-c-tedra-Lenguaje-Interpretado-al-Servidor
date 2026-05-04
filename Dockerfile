FROM php:8.2-apache

# Instalar extensiones necesarias para MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Habilitar mod_rewrite (útil si usas rutas amigables)
RUN a2enmod rewrite

# Copiar tu proyecto al contenedor
COPY . /var/www/html/

# Permisos (opcional pero recomendado)
RUN chown -R www-data:www-data /var/www/html