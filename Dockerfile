FROM php:8.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libsqlite3-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . .

# Set permissions FIRST — critical fix
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html
RUN chmod -R 777 storage bootstrap/cache database

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Expose port
EXPOSE 80

# Start command — NO cache:clear here, run as www-data
USER www-data
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]