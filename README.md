# Pokemon Card API

API backend sederhana menggunakan Laravel dengan penyimpanan data berbasis JSON (tanpa database).

## Deskripsi

Project ini dibuat untuk memenuhi tugas UTP TIS. API ini menyediakan fitur CRUD untuk mengelola data kartu Pokemon berdasarkan rarity dan harga.

---

## Fitur API

* GET /api/items → Menampilkan semua data kartu
* GET /api/items/{id} → Menampilkan kartu berdasarkan ID
* POST /api/items → Menambahkan kartu baru
* PUT /api/items/{id} → Update seluruh data kartu
* PATCH /api/items/{id} → Update sebagian data kartu
* DELETE /api/items/{id} → Menghapus kartu

---

## Contoh Request

### POST /api/items

```json
{
  "name": "Pikachu",
  "rarity": "Rare",
  "price": 10000
}
```

---

## Teknologi

* PHP
* Laravel
* JSON (sebagai storage, tanpa database)
* L5-Swagger (API Documentation)

---

## Cara Menjalankan Project

1. composer install
2. cp .env.example .env
3. php artisan key:generate
4. php artisan serve

---

## Dokumentasi API

Swagger UI tersedia di:
http://127.0.0.1:8000/api/documentation

---

## Author

Muhammad Iqbal Azzahir
NIM: 245150307111043
