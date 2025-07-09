#!/bin/bash

echo "📦 Mendownload composer.phar versi 2..."
php -r "copy('https://getcomposer.org/composer-2.phar', 'composer.phar');"

echo "✅ composer.phar versi 2 berhasil diunduh."
echo "👟 Menjalankan composer install via composer.phar..."

php composer.phar install --no-dev --optimize-autoloader

echo "✅ composer install selesai."

echo "🔐 Menjalankan php artisan key:generate..."
php artisan key:generate

echo "📁 Menyusun config cache..."
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🔒 Set permission folder storage dan bootstrap/cache..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache

echo "🎉 SEMUA SELESAI! Laravel kamu sudah siap jalan!"