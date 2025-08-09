# Use official PHP 8.2 image with Apache
FROM php:8.2-apache

# === 1. Install System Dependencies ===
RUN apt-get update && apt-get install -y \
    libzip-dev \       # For Zip extension
    zip \              # For Composer
    libpq-dev \        # For PostgreSQL
    && docker-php-ext-install pdo pdo_pgsql zip  # Enable PHP extensions

# === 2. Configure Apache ===
# Enable URL rewriting (for Laravel routes)
RUN a2enmod rewrite

# Copy Apache config (we'll create this next)
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf

# === 3. Set Up Laravel ===
# Copy all files to the container
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies (no dev packages)
RUN composer install --no-dev

# === 4. Fix Permissions ===
# Allow Laravel to write to storage/logs
RUN chown -R www-data:www-data /var/www/html/storage
RUN chmod -R 775 /var/www/html/storage