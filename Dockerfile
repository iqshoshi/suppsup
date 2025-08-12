FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    libpq-dev \
    netcat-openbsd \  # ← This provides the 'nc' command
    && docker-php-ext-install pdo pdo_pgsql zip

# Apache setup
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# App setup
WORKDIR /var/www/html
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev

# Fix permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Simplified entrypoint
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]