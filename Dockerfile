# Imagen base de PHP con Apache
FROM php:8.2-apache

# Instala extensiones comunes necesarias (ajusta según tu app)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia los archivos del proyecto al servidor web del contenedor
COPY . /var/www/html/

# Establece el directorio de trabajo
WORKDIR /var/www/html/

# Configuración opcional de permisos
RUN chown -R www-data:www-data /var/www/html

# Exponer el puerto 80 (Apache)
EXPOSE 80

# Comando de inicio del servidor
CMD ["apache2-foreground"]
