# Laravel basic, Management Contact(s) data

## Features

-   Database with SQLITE3
-   Tailwind CSS
-   CRUD
-   Upload image (sym-link)
-   Search data
-   Laravel Breeze
-   Export into .xlsx
-   API with Authentication

## How to run on your local

```sh
git clone https://github.com/graphiert/contact-laravel.git
cd contact-laravel
composer install
cp .env.example .env # or copy .env.example .env
nano .env # or notepad.exe .env (change FILESYSTEM_DISK into public)
php artisan key:generate
php artisan migrate
php artisan storage:link
npm install
npm run dev
php artisan serve
```

### Note

If you encounter errors while generating APP_KEY,
run this command before and after generating key.
[Read more here.](https://stackoverflow.com/a/76339865)

```sh
php artisan config:cache
```
