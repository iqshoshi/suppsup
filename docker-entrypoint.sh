#!/bin/bash
set -e

# Wait for PostgreSQL (with timeout)
timeout 30s bash -c 'until php artisan db:monitor >/dev/null 2>&1; do sleep 1; done'

# Run migrations
php artisan migrate --force

# Clear cache
php artisan optimize:clear

# Start Apache
exec apache2-foreground