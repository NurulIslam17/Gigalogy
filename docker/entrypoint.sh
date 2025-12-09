#!/usr/bin/env bash
set -e

# ensure storage permissions
chown -R www:www /var/www/storage /var/www/bootstrap/cache || true

# run migrations if env var set
if [ "$RUN_MIGRATIONS" = "true" ]; then
  php artisan migrate --force
fi

exec "$@"
