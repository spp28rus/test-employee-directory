## Описание
Каталог сотрудников.
## Инструкция
Для установки перейдите в каталог с проектом и выполните следующие команды:
``` bash
git clone https://github.com/spp28rus/test-employee-directory .
```

Создайте файл .env из файла .env.example и укажите следующие параметры:
``` bash
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

После чего выполните команды
``` bash
composer install
php artisan migrate
php artisan db:seed
php artisan key:generate
```

Для запуска приложение можете использовать команду
``` bash
php artisan serve
```