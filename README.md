### 1. Встановлення залежностей для фреймворка Laravel.
```
composer install
```

### 2. Генерація ключа застосунку.
```
php artisan key:generate
```

### 3. Запуск міграцій (створення таблиць БД).
```
php artisan migrate --path=./database/migrations/2023_11_30_145143_create_halls_table.php \
    && php artisan migrate --path=./database/migrations/2023_11_30_145144_create_shows_table.php \
    && php artisan migrate --path=./database/migrations/2023_12_02_124645_create_orders_table.php \
    && php artisan migrate --path=./database/migrations/2023_12_02_125343_create_order_hall_seats_table.php
```

### 4. Запуск посіву даних (заповнення таблиць базовими даними).
```
php artisan db:seed --class=HallSeeder \
    && php artisan db:seed --class=ShowSeeder
```