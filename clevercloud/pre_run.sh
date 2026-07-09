#!/usr/bin/env bash
set -euo pipefail

php artisan app:clever-deploy --seed-demo --ansi
