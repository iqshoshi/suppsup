#!/bin/bash
set -e

# Wait for PostgreSQL to be ready
echo "Waiting for PostgreSQL at ${DB_HOST}:${DB_PORT}..."
until nc -z "$DB_HOST" "$DB_PORT"; do
  sleep 1
done
echo "PostgreSQL is ready."

# Run migrations
php artisan migrate --force

# Clear caches
php artisan optimize:clear

# Start Apache
exec apache2-foreground
