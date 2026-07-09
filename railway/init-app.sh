#!/usr/bin/env sh
set -eu

if [ -z "${APP_KEY:-}" ]; then
    echo "ERROR: APP_KEY is missing. Generate one with: php artisan key:generate --show"
    echo "Then add it to the Railway service variables before redeploying."
    exit 1
fi

if [ "${APP_ENV:-}" != "production" ]; then
    echo "ERROR: APP_ENV must be set to production on Railway."
    exit 1
fi

if [ "${DB_CONNECTION:-}" = "sqlite" ]; then
    echo "ERROR: DB_CONNECTION=sqlite is not supported for this Railway deployment."
    echo "Create a Railway MySQL service and set DB_CONNECTION=mysql with DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME and DB_PASSWORD."
    exit 1
fi

php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan app:deploy-prepare --seed-demo
