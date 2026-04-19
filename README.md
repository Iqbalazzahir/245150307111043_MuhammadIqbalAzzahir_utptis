# Pokemon Card API

API backend sederhana menggunakan Laravel dengan penyimpanan data berbasis JSON (tanpa database).

## Deskripsi
Project ini dibuat untuk memenuhi tugas UTP TIS. API ini menyediakan fitur CRUD untuk mengelola data kartu Pokemon berdasarkan rarity dan harga.

## Fitur API
- GET /api/items
- GET /api/items/{id}
- POST /api/items
- PUT /api/items/{id}
- PATCH /api/items/{id}
- DELETE /api/items/{id}

## Teknologi
- PHP
- Laravel
- JSON
- L5-Swagger

## Cara Menjalankan
1. composer install
2. cp .env.example .env
3. php artisan key:generate
4. php artisan serve

## Dokumentasi API
http://127.0.0.1:8000/api/documentation

## Author
Muhammad Iqbal Azzahir - 245150307111043