#!/bin/sh
set -e
cd /var/www/html

echo "[entrypoint] menunggu database ${DB_HOST:-db}:${DB_PORT:-3306} ..."
if [ -n "${DB_HOST:-}" ]; then
  until php -r 'try { new PDO("mysql:host=".getenv("DB_HOST").";port=".(getenv("DB_PORT")?:3306), getenv("DB_USERNAME"), getenv("DB_PASSWORD")); echo "ok\n"; } catch (Exception $e) { exit(1); }' 2>/dev/null; do
    echo "  ... database belum siap, coba lagi dalam 3 detik"
    sleep 3
  done
  echo "[entrypoint] database siap."
fi

# Generate APP_KEY kalau kosong (tanpa butuh file .env)
if [ -z "${APP_KEY:-}" ]; then
  echo "[entrypoint] APP_KEY kosong -> generate (env)..."
  export APP_KEY="base64:$(php -r 'echo base64_encode(random_bytes(32));')"
fi

echo "[entrypoint] migrate..."
php artisan migrate --force --no-interaction

if [ "${DB_SEED:-false}" = "true" ]; then
  echo "[entrypoint] seed data..."
  php artisan db:seed --force --no-interaction || echo "  (seed warning diabaikan)"
fi

echo "[entrypoint] optimize cache config/route..."
php artisan config:clear --ansi >/dev/null 2>&1 || true
php artisan route:clear --ansi >/dev/null 2>&1 || true
php artisan view:clear --ansi >/dev/null 2>&1 || true

echo "[entrypoint] starting $@"
exec "$@"