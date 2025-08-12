#!/bin/bash
set -e

# Wait for PostgreSQL
echo "Waiting for PostgreSQL at ${DB_HOST}:${DB_PORT}..."
for i in {1..30}; do
    if command -v nc >/dev/null 2>&1 && nc -z "$DB_HOST" "$DB_PORT"; then
        echo "PostgreSQL is ready."
        break
    fi
    echo "PostgreSQL not ready yet... ($i/30)"
    sleep 1
    if [ $i -eq 30 ]; then
        echo "Error: PostgreSQL did not become ready in time."
        exit 1
    fi
done

# Run migrations only if pending
if php artisan migrate:status | grep -q "Pending"; then
    php artisan migrate --force
else
    echo "No pending migrations."
fi

# Clear caches
php artisan optimize:clear

# Start Apache
exec apache2-foreground
