# Web API PC Synergy
### Requirements
- Download and Install XAMPP https://www.apachefriends.org/download.html
- Download and Install Composer https://getcomposer.org/download/
- Install Laravel https://laravel.com/docs/5.8#installing-laravel
Write in console:
```php
composer global require laravel/installer
```

###Create local Database
- Open XAPP
- Start Apache and MySQL
- Go to MySQL Admin
- Create data base with the following options:
 - **Name**: pcsynergy_dev
 - **Cotejamiento**: utf8mb4_unicode_ci

### Configuration
In the project, write in console:
```bash
cp .env.example .env
```
Open file .env and configure your connection to the database, example:
```
DB_DATABASE=pcsynergy_dev
DB_USERNAME=root
DB_PASSWORD=
```
By last, write in conole:
```bash
composer install
php artisan key:generate
```

###Migrations for Database
In the project, write in console:
```bash
php artisan migrate
```

### Run
In the project, write in console:
```bash
php artisan serve
```

###Heroku
Login heroku app
```bash
heroku ps:exec -a pcs-webapi
```
