# MotorCare API - Motorcycle Maintenance Tracker

MotorCare adalah RESTful API untuk sistem pelacakan riwayat perawatan sepeda motor. API ini memungkinkan pengguna untuk mengelola data motor, mencatat perjalanan, serta memantau kondisi dan jadwal penggantian suku cadang secara otomatis berbasis jarak tempuh (KM).

**Catatan:** Repository ini murni berisi **Backend (REST API)**. Didesain secara *headless* agar siap dikonsumsi oleh berbagai platform Frontend (React, Vue, Mobile App, dll).

---

## Fitur Utama

* **RESTful Endpoint:** Struktur API yang rapi untuk manajemen motor, perjalanan, dan suku cadang.
* **Trip Tracking System:** Mencatat perjalanan (manual / GPS) yang otomatis menambah total KM motor.
* **Smart Maintenance Tracking:** Menghitung sisa KM sebelum penggantian part berdasarkan interval.
* **Replace Part Endpoint:** Reset KM penggantian part ke KM motor saat ini secara otomatis.
* **Observer-Based Automation:** Update total KM motor secara otomatis saat trip dibuat, diubah, atau dihapus.
* **Ownership-Based Access Control:** Setiap user hanya bisa mengakses dan memodifikasi data miliknya sendiri.
* **Business Rule Enforcement:**
  * Trip dengan tipe `gps`  tidak bisa di-edit
  * Trip manual bisa di-edit
* **Secure Authentication:** Menggunakan Laravel Sanctum (Bearer Token).

---

## Teknologi yang Digunakan

* **Framework:** Laravel 13 (PHP 8.3+)
* **Database:** MySQL
* **Authentication:** Laravel Sanctum
* **Environment:** Docker (Laravel Sail)
* **Testing API:** Postman

---

**[Klik di sini untuk melihat Dokumentasi Postman MotorCare API]**  
https://crimson-satellite-1456435.postman.co/workspace/kkh's-Workspace~513eca4e-75f6-45a2-8afd-b1b7c048edb9/collection/51063118-6180ad5e-55b4-467f-b40f-644b7dab0086?action=share&source=copy-link&creator=51063118

---

## Cara Menjalankan Project (Lokal)

**1. Clone Repository:**
```bash
git clone https://github.com/kkhff/MotorCare-API.git
cd MotorCare-API
```
**2. Setup Environment**
```bash
cp .env.example .env
```

**3. Install Dependencies:** Jika kamu memiliki PHP dan Composer lokal:
```bash
composer install
```
Jika kamu **hanya ingin menggunakan** Docker (Tanpa install PHP di lokal):
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

**4. Jalankan Docker Sail**
```bash
./vendor/bin/sail up -d
```

**5. Generate Key & Migrate**
```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
```
