<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Требования

- #### PHP >= 8.1
- #### Composer
- #### Node.js и npm
- #### MySQL
- #### Git

## Команды для сборки

1. Клонировать репозиторий</br>
`git clone https://github.com/Status404NotFound/miniShopTest`</br>
перейти в корень проекта</br></br>
2. Выполнить установку зависимостей</br>
`composer install` </br></br>
`npm install`</br></br>
3. Настройка файла конфигурации</br>
Скопируйте файл .env.example и сохраните его с именем .env.</br>
Откройте файл .env и укажите доступы к вашей базе данных в блоке DB </br>
`DB_CONNECTION=mysql`</br>
`DB_HOST=127.0.0.1`</br>
`DB_PORT=3306`</br>
`DB_DATABASE=имя_вашей_бд`</br>
`DB_USERNAME=ваш_пользователь`</br>
`DB_PASSWORD=ваш_пароль`</br></br>
4. Команда для гинерации ключа приложения</br>
`php artisan key:generate`</br></br>
5. Команда для миграции и сидов</br>
`php artisan migrate --seed`</br></br>
6. Билд фронта</br>
`npm run build`</br></br>
7. Запуск локального сервера</br>
`php artisan serve`</br></br>


## Тесты
`php artisan test`
### Тесты делают RefreshDatabase - очищают базу поэтому после тестов запустите:
`php artisan db:seed`
`
