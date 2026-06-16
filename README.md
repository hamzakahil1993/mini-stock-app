# Mini Stock App

Simple inventory management (Laravel + Breeze): products with images, stock movements, and clients.

## Installation

```bash
composer install && npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
npm run build
```

## Run

```bash
php artisan serve
npm run dev
```

Available at http://127.0.0.1:8000
