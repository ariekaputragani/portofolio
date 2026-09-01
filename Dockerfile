# Laravel 11 portfolio — production-ready Apache image
FROM php:8.3-apache

# System deps & PHP extensions yang diperlukan Laravel
RUN apt-get update && apt-get install -y --no-install-recommends \
      git unzip libzip-dev libpng-dev libjpeg-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd bcmath exif \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

# Composer (dari image resmi binary)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Salin kode aplikasi
COPY . .

# Set DocumentRoot Apache ke folder public Laravel
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/docker-php.conf

# Install dependency PHP (tanpa dev, tanpa trigger scripts dulu)
RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts \
    && php artisan package:discover --ansi

# Direktori writable untuk Laravel (storage & cache)
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache storage/logs \
    && chown -R www-data:www-data storage bootstrap/cache

# Entrypoint: tunggu DB -> migrate -> (seed) -> optimize -> jalankan Apache
COPY docker/entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

EXPOSE 80

# PHP tuning ringan untuk produksi
RUN printf 'memory_limit=512M\nupload_max_filesize=20M\npost_max_size=20M\n' > /usr/local/etc/php/conf.d/app.ini

ENTRYPOINT ["entrypoint"]
CMD ["apache2-foreground"]
