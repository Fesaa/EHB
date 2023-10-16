mkdir bootstrap
mkdir bootstrap/cache
mkdir storage
mkdir storage/framework
mkdir storage/framework/cache
mkdir storage/framework/sessions
mkdir storage/framework/views
mkdir storage/logs
cp app.php.example bootstrap/app.php
cp .env.example .env

php artisan key:generate
php artisan migrate:fresh --seed
