#!/bin/sh

php artisan storage:link
php artisan migrate --seed
php artisan serve --host=0.0.0.0
