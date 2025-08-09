FROM php:8.2-apache

# 1. Install dependencies (FIXED BACKSLASHES)
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# 2. Apache setup
RUN a2enmod rewrite
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf

# 3. Copy app
COPY . /var/www/html
WORKDIR /var/www/html

# 4. Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev

# 5. Permissions
RUN chown -R www-data:www-data /var/www/html/storage
RUN chmod -R 775 /var/www/html/storage