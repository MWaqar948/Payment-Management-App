# Payment Management App

It is a simple payment management app written in Laravel

## Setup

Clone this app repository

```bash
git clone http://github.com/Payment-Management-App
```
Install composer dependencies

```bash
composer install
```
Setup environment file

Create .env file from .env.example
```bash
cp .env.example .env
```
Setup Database Connection in .env file
```php
DB_CONNECTION=mysql
DB_HOST=database
DB_PORT=3306
DB_DATABASE=payment-db
DB_USERNAME=root
DB_PASSWORD=
```
Generate key in terminal
```
php artisan key:generate
```

Run migrations
```bash
php artisan migrate --seed
```

Install npm dependencies

```bash
npm install
```

## Run
Start up the laravel server
```bash
php artisan serve
```
Start node server
```bash
npm run dev
```
Open this URL in browser
```php
http://localhost:8000
```
## Testing
Run test command in terminal
```bash
php artisan test
```
