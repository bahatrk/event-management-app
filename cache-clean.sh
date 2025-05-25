#!/bin/bash

# Clear Laravel caches
php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "Artisan caches cleared."