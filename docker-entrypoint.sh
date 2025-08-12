#!/bin/bash
set -e

# Wait for PostgreSQL to be ready (important!)
while ! nc -z $DB_HOST $DB_PORT; do
  sleep 1
done

# Run migrations
php artisan migrate --force

# Clear cache
php artisan optimize:clear

# Start Apache
exec apache2-foreground