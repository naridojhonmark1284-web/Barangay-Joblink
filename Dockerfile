FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libsqlite3-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN chmod -R 777 storage bootstrap/cache database

# Entrypoint script
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]

EXPOSE 80
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]