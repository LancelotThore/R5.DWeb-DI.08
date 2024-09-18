FROM php:7.4-apache

# Installer les extensions nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Copier le fichier php.ini personnalisé
COPY php.ini /usr/local/etc/php/

# Copier le contenu du répertoire www dans le répertoire de l'application web
COPY www/ /var/www/html/