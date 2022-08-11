# Installing the project

- Works alongside TTH wordpress project structure.
- Uses the same database as wordpress.
- Tables of this project has a tth_ prefix in database.
- Place the files in root wordpress folder's admin/ directory.

## Steps to install as follows

Create a database. Import the wordpress database into this db.
.env as follows
```
APP_NAME=TTH
APP_ENV=local
APP_KEY=base64:/rb86wihD8cYv4IzNLRqpv0/ELvQa+JICsJByy1H/OY=
APP_DEBUG=true
APP_URL=127.0.0.1

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tthadmin
DB_USERNAME=root
DB_PASSWORD=password
```
Do a composer install.
cp .env.example .env
php artisan config:clear
php artisan key:generate
php artisan migrate:install
php artisan db:seed
php artisan serve
Use the credentials, admin@trekthehimalayas.com, Admin@123 to login
