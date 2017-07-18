#!/bin/sh

php artisan clear-compiled
wait
php artisan cache:clear
wait
php artisan config:clear
wait
php artisan route:clear
wait
php artisan view:clear
wait
