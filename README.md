<div align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
  
  # 🛒 SimpleShop — E-Commerce Platform
  
  **A Lightweight, Multi-Seller E-Commerce Platform** built with the modern TALL stack (Tailwind, Alpine, Laravel).

[![Laravel 13](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP 8.2+](https://img.shields.io/badge/PHP_8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Tailwind CSS 4](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)](https://alpinejs.dev)

</div>

---

## 📖 Tentang Aplikasi

**SimpleShop** adalah platform e-commerce yang dirancang untuk mendukung sistem **Multi-Seller Marketplace**. Aplikasi ini memungkinkan pengguna untuk mendaftar sebagai **Buyer** (Pembeli) atau **Seller** (Penjual), dengan fitur lengkap mulai dari manajemen produk, keranjang belanja (AJAX), hingga proses checkout dengan manajemen stok yang aman (Pessimistic Locking).

---

## ✨ Fitur Utama

### 🛍️ Untuk Buyer (Pembeli)

- **Katalog Interaktif**: Cari dan filter produk berdasarkan kategori dengan mudah.
- **Smart Cart (AJAX)**: Tambah, kurangi, atau hapus item di keranjang tanpa reload halaman. Batasan _single-seller_ dalam satu kali checkout.
- **Checkout Fleksibel**: Mendukung metode pembayaran Transfer Bank & COD (Cash on Delivery).
- **Manajemen Pesanan**: Lacak status pesanan, riwayat belanja, dan opsi pembatalan untuk pesanan _pending_.

### 🏬 Untuk Seller (Penjual)

- **Seller Dashboard**: Pantau performa toko dengan statistik penjualan, grafik pendapatan 7 hari terakhir, dan daftar produk terlaris.
- **Manajemen Produk**: Sistem CRUD lengkap dengan fitur unggah gambar yang aman (nama unik _timestamp_).
- **Proses Pesanan Masuk**: Perbarui status pesanan dari pembeli secara bertahap: `Pending` ➔ `Paid` ➔ `Shipped` ➔ `Completed`.
- **Notifikasi Otomatis**: Sistem mengirim email notifikasi otomatis kepada pembeli ketika status pesanan berubah.

### ⚙️ Sistem & Keamanan

- **Role-Based Access Control (RBAC)**: Autentikasi dan otorisasi ketat memisahkan hak akses antara _Buyer_ dan _Seller_.
- **Pessimistic Locking**: Mencegah _race-condition_ atau bentrok pembelian barang yang sama secara bersamaan saat _checkout_.
- **Asynchronous Queues**: Pengiriman email menggunakan _Job Queue_ agar proses belanja tetap cepat.

---

## 🚀 Panduan Instalasi

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi di komputer lokal (Development Environment).

> [!IMPORTANT]
> **Prerequisites:** Pastikan Anda telah menginstal **PHP >= 8.2**, **Composer**, **Node.js >= 18**, dan **SQLite/MySQL**.

```bash
# 1. Clone repositori ini
git clone <repository-url>
cd Simple-E-Commerce-Platform

# 2. Install dependensi Backend & Frontend
composer install
npm install

# 3. Konfigurasi Environment
cp .env.example .env
php artisan key:generate

# 4. Migrasi Database dan Seeder (Otomatis menggunakan SQLite sebagai default)
php artisan migrate --seed

# 5. Buat symbolic link untuk gambar/storage
php artisan storage:link

# 6. Build aset frontend (Tailwind & Alpine)
npm run build
```

> [!NOTE]  
> **Menjalankan Aplikasi**
> Anda perlu menjalankan dua server dan satu _queue worker_ secara bersamaan. Silakan buka 3 tab terminal:
>
> - Tab 1: `php artisan serve` (Server PHP)
> - Tab 2: `npm run dev` (Vite Hot Reload)
> - Tab 3: `php artisan queue:work` (Background process untuk Email)
>
> Akses aplikasi di: **http://localhost:8000**

---

## 🔐 Akun Uji Coba (Demo)

Aplikasi sudah dilengkapi dengan _Database Seeder_ untuk memudahkan pengujian. Gunakan kredensial berikut:

### 🏪 Akun Seller

| Toko                 | Email                 | Password   |
| -------------------- | --------------------- | ---------- |
| **TeknoMart**        | `seller1@example.com` | `password` |
| **Siti Style House** | `seller2@example.com` | `password` |

### 🛒 Akun Buyer

| Email                | Password   |
| -------------------- | ---------- |
| `buyer1@example.com` | `password` |
| `buyer2@example.com` | `password` |

---

## 📂 Struktur Direktori Utama

Berikut adalah letak direktori kunci bagi Anda yang ingin mempelajari atau memodifikasi _source code_:

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/                  # Sistem Login & Register Breeze
│   │   ├── Seller/                # Logika khusus Dashboard Seller & Produk
│   │   ├── CartController.php     # Manajemen Keranjang via AJAX
│   │   └── CheckoutController.php # Logika Checkout
│   └── Middleware/
│       └── RoleMiddleware.php     # Proteksi akses berdasarkan Role
├── Jobs/
│   └── SendOrderConfirmation.php  # Pengiriman email via Queue
├── Models/                        # Eloquent ORM (User, Product, Order, dll)
├── Policies/
│   └── ProductPolicy.php          # Otorisasi CRUD Produk Seller
└── Services/                      # Business Logic Layer
    ├── CartService.php            # Logika batas cart single-seller
    ├── DashboardService.php       # Perhitungan statistik Seller
    ├── OrderService.php           # Logika transaksi DB saat Checkout
    └── StockService.php           # Validasi dan pengurangan stok barang
```

---

## 🛠️ Stack Teknologi

- **Core Framework**: [Laravel 13](https://laravel.com)
- **Frontend Stack**: [Blade Template](https://laravel.com/docs/blade), [Tailwind CSS 4](https://tailwindcss.com), [Alpine.js](https://alpinejs.dev)
- **Build Tool**: Vite
- **Database**: SQLite (Development) / MySQL (Production Ready)
- **Autentikasi**: Laravel Breeze

---

## 🧪 Pengujian Sistem (Testing)

Proyek ini dilengkapi dengan **Feature Tests** berbasis Pest/PHPUnit untuk memastikan fitur-fitur berjalan dengan baik.

> [!TIP]
> Jalankan perintah berikut untuk menjalankan seluruh pengujian:
>
> ```bash
> php artisan test
> ```

**Skenario Utama yang Diuji:**

1. **RegistrationTest**: Validasi registrasi pengguna dan pembagian peran (_role_).
2. **ProductManagementTest**: Keamanan CRUD produk, pembeli tidak bisa mengubah produk penjual, dan penjual hanya bisa mengubah produknya sendiri.
3. **CheckoutTest**: Validasi proses checkout, pencegahan order jika stok habis (DB rollback otomatis).

---

## 📧 Konfigurasi Email Lokal

Secara default, Laravel akan mencatat log email ke dalam file `storage/logs/laravel.log`. Jika Anda ingin menggunakan layanan simulasi email seperti **Mailtrap**, ubah konfigurasi `.env` Anda:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@simpleshop.test"
MAIL_FROM_NAME="SimpleShop"
```

---

<div align="center">
  Dibuat dengan ❤️🤣 untuk pembelajaran E-Commerce dengan Laravel.
</div>
