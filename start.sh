#!/bin/sh

php artisan optimize:clear
php artisan optimize
php artisan config:clear
php artisan storage:link
php artisan migrate --seed
php artisan serve --host=0.0.0.0
