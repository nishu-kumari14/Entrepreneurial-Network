#!/bin/bash

# Wait for database to be ready
echo "Waiting for database..."
max_attempts=30
attempt=1
while [ $attempt -le $max_attempts ]; do
    if php artisan db:monitor --timeout=1 > /dev/null 2>&1; then
        echo "Database is ready!"
        break
    fi
    echo "Attempt $attempt of $max_attempts: Database not ready yet..."
    sleep 2
    attempt=$((attempt + 1))
done

if [ $attempt -gt $max_attempts ]; then
    echo "Database connection failed after $max_attempts attempts"
    exit 1
fi

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Clear and cache configurations
echo "Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link
echo "Creating storage link..."
php artisan storage:link

# Set proper permissions
echo "Setting permissions..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

echo "Deployment completed!" 