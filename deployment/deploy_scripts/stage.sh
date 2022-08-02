cd /home/www

php artisan config:cache
php artisan route:cache
php artisan optimize --force

service php-fpm reload
