#!/usr/bin/env sh
set -eu

if [ -z "${APP_KEY:-}" ]; then
    echo "ERROR: APP_KEY is missing. Generate one with: php artisan key:generate --show"
    echo "Then add it to the Railway service variables before redeploying."
    exit 1
fi

php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan app:deploy-prepare --seed-demo
