FROM php:8.2-apache

# Installer MySQL driver
RUN docker-php-ext-install pdo pdo_mysql

# Activer rewrite
RUN a2enmod rewrite

# Dossier de travail
WORKDIR /var/www/html

# Copier le projet
COPY . .

# Installer dépendances
RUN apt-get update && apt-get install -y unzip git curl
RUN curl -sS https://getcomposer.org/installer | php
RUN php composer.phar install --no-dev --optimize-autoloader

# Permissions Laravel
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 storage bootstrap/cache

# Port
EXPOSE 80

# Lancer Apache
CMD ["apache2-foreground"]
