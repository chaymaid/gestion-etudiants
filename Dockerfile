FROM php:8.2-cli

# Installer extensions
RUN docker-php-ext-install pdo pdo_mysql

# Installer composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=8080
