Jalanin ini di template laravel kalian

```bash
# dependencies
composer require laravel/sanctum setasign/fpdf phpoffice/phpspreadsheet

# Sanctum API scaffolding
php artisan install:api

# frontend dependencies
npm install -D tailwindcss @tailwindcss/vite

# avatar
php artisan storage:link

# migrate
php artisan migrate

# seeding
php artisan migrate:fresh --seed

# clone repo
git clone https://github.com/Volzeur/final-projects.git
```

Masuk ke folder "final-projects" terus Ctrl+A dan Ctrl+X semua file disitu terus pindahin ke template laravel kalian

```bash
# jalanin
php artisan serve
```
