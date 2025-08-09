#!/bin/sh

until nc -z ${DB_HOST} 5432
do
  echo "waiting postgres boot"
  sleep 1
done

[ -f /app/artisan ] && /usr/local/bin/php /app/artisan migrate --force

exec /usr/local/bin/docker-php-entrypoint "$@"
