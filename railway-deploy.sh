#!/bin/bash

# Wait for database to be ready
echo "Waiting for database..."
sleep 10

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