#!/usr/bin/env sh
set -eu

php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan app:deploy-prepare --seed-demo
