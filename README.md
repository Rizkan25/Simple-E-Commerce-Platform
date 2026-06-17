<div align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
  
  # 🛒 SimpleShop — E-Commerce Platform
  
  **Platform E-Commerce Multi-Seller yang Ringan & Modern** dibangun dengan TALL stack (Tailwind, Alpine, Laravel) dan terintegrasi dengan Filament untuk kemudahan manajemen.
  
  [![Laravel 13](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
  [![PHP 8.2+](https://img.shields.io/badge/PHP_8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
  [![Tailwind CSS 4](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
  [![Alpine.js](https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)](https://alpinejs.dev)
</div>

---

## 📖 Tentang Aplikasi

**SimpleShop** adalah platform e-commerce yang dirancang khusus untuk mendukung sistem **Multi-Seller Marketplace**. Melalui platform ini, pendaftaran pengguna difasilitasi dalam dua peran utama, yaitu sebagai **Buyer** (Pembeli) untuk melakukan transaksi pembelian atau sebagai **Seller** (Penjual) untuk membuka toko secara mandiri.

Fitur yang disediakan mencakup manajemen produk, keranjang belanja berbasis AJAX, proses checkout yang didukung oleh _Pessimistic Locking_ (untuk menghindari duplikasi checkout), hingga integrasi dengan sistem dompet digital (wallet) dan mekanisme penyelesaian sengketa (dispute).

---

## ✨ Fitur Utama

### 🛍️ Modul Buyer (Pembeli)

- **Katalog & Live Search**: Pencarian dan penyaringan produk berdasarkan kategori yang terintegrasi dengan fungsi pencarian _real-time_ (AJAX) tanpa memuat ulang halaman.
- **Profil & Avatar**: Dukungan bagi pengguna untuk mengunggah dan mengubah foto profil sesuai preferensi.
- **Produk Populer (View Tracking)**: Menampilkan produk yang sedang menjadi tren berdasarkan jumlah _views_ atau tayangan pada masing-masing produk.
- **Smart Cart (AJAX)**: Penambahan, pengurangan, atau penghapusan produk di keranjang belanja yang berjalan secara asinkronus. Terdapat batasan _single-seller_ per proses checkout.
- **Checkout Dinamis**: Mendukung metode pembayaran transfer bank, COD (Cash on Delivery), serta pembayaran menggunakan saldo wallet bawaan dari aplikasi.
- **Manajemen Pesanan**: Pemantauan status pesanan, peninjauan riwayat transaksi, serta fitur pembatalan untuk pesanan yang masih bersatus _pending_.
- **Sistem Sengketa (Dispute)**: Fasilitas bagi pembeli untuk mengajukan komplain apabila terdapat permasalahan pada pesanan.

### 🏬 Modul Seller (Penjual) & Admin

- **Dashboard Terintegrasi (Powered by Filament)**: Pemantauan performa toko, statistik penjualan, dan grafik pendapatan yang disajikan dengan antarmuka yang modern dan intuitif.
- **Manajemen Produk (CRUD)**: Fasilitas lengkap untuk menambah, mengubah, serta menghapus produk, didukung dengan sistem penyimpanan gambar yang terstruktur.
- **Pemrosesan Pesanan**: Pembaruan status pesanan yang dapat dikelola secara bertahap: `Pending` ➔ `Paid` ➔ `Shipped` ➔ `Completed`.
- **Penarikan Saldo (Withdrawal)**: Fasilitas bagi penjual untuk mencairkan saldo yang didapatkan dari hasil penjualan produk.
- **Notifikasi Otomatis**: Pengiriman email notifikasi secara otomatis ke pembeli setiap kali terdapat perubahan pada status pesanan.
- **Export Data (Excel)**: Kemudahan dalam mengekspor data penjualan ke dalam format Excel untuk keperluan pembukuan dan pelaporan.

### ⚙️ Sistem & Keamanan

- **Role-Based Access Control (RBAC)**: Diimplementasikan menggunakan `spatie/laravel-permission` untuk menjaga batasan dan otoritas akses secara ketat antara _Buyer_, _Seller_, dan _Admin_.
- **Pessimistic Locking**: Mekanisme pencegahan _race-condition_ untuk menjamin keamanan dan konsistensi data pada saat proses transaksi (_checkout_) berlangsung secara bersamaan.
- **Asynchronous Queues**: Penanganan proses pengiriman email serta tugas latar belakang lainnya dikelola dengan antrean (_queue_) agar responsivitas aplikasi tetap terjaga.
- **Sistem Wallet**: Pengelolaan saldo pengguna yang terintegrasi secara langsung menggunakan paket `bavix/laravel-wallet`.

---

## 🚀 Panduan Instalasi Lokal

Ikuti langkah-langkah di bawah ini untuk mengonfigurasi dan menjalankan aplikasi pada lingkungan pengembangan (_development environment_).

> [!IMPORTANT]  
> **Prasyarat:** Pastikan sistem telah terinstal **PHP >= 8.3**, **Composer**, **Node.js >= 18**, serta sistem manajemen basis data **SQLite/MySQL**.

```bash
# 1. Kloning repositori
git clone <repository-url>
cd Simple-E-Commerce-Platform

# 2. Instalasi dependensi Backend & Frontend
composer install
npm install

# 3. Konfigurasi file environment
cp .env.example .env
php artisan key:generate

# 4. Migrasi basis data beserta isian awal (secara default menggunakan SQLite)
php artisan migrate --seed

# 5. Pembuatan tautan simbolik (Wajib untuk menampilkan gambar produk dan avatar)
php artisan storage:link

# 6. Kompilasi aset frontend
npm run build
```

> [!NOTE]  
> **Menjalankan Aplikasi**  
> Diperlukan beberapa terminal yang berjalan secara bersamaan:
>
> - Terminal 1: `php artisan serve` (Menjalankan server PHP)
> - Terminal 2: `npm run dev` (Menjalankan Vite Hot Reload)
> - Terminal 3: `php artisan queue:work` (Menjalankan pekerja antrean latar belakang)
>
> Sebagai alternatif, perintah `npm run dev` atau `composer dev` dapat dijalankan, karena telah terkonfigurasi dengan paket _concurrently_.
>
> Aplikasi dapat diakses melalui peramban pada alamat: **http://localhost:8000**

---

## 🔐 Kredensial Pengujian (Demo)

Sistem telah dilengkapi dengan _Database Seeder_ untuk memudahkan proses pengujian. Silakan gunakan kredensial berikut untuk melakukan proses masuk (_login_):

### 🛡️ Akses Admin

| Jabatan              | Email                 | Kata Sandi        |
| -------------------- | --------------------- | ----------------- |
| **Super Admin**      | `admin@example.com`   | `SecretShop@2026` |

### 🏪 Akses Seller

| Nama Toko            | Email                 | Kata Sandi        |
| -------------------- | --------------------- | ----------------- |
| **TeknoMart**        | `seller1@example.com` | `SecretShop@2026` |
| **Siti Style House** | `seller2@example.com` | `SecretShop@2026` |

### 🛒 Akses Buyer

| Email                | Kata Sandi        |
| -------------------- | ----------------- |
| `buyer1@example.com` | `SecretShop@2026` |
| `buyer2@example.com` | `SecretShop@2026` |
| `buyer3@example.com` | `SecretShop@2026` |

---

## 📂 Struktur Direktori Utama

Berikut adalah letak direktori penting untuk mempelajari dan memodifikasi _source code_ dari aplikasi:

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/                   # Endpoint API (Contoh: Live Product Search)
│   │   ├── Auth/                  # Sistem Login & Registrasi dengan Breeze
│   │   ├── CartController.php     # Manajemen operasi keranjang belanja (AJAX)
│   │   ├── CheckoutController.php # Logika transaksi checkout
│   │   └── ProfileController.php  # Pembaruan profil dan avatar
│   └── Middleware/                # Proteksi rute berbasis peran
├── Jobs/                          # Pekerjaan asinkronus latar belakang
├── Models/                        # Penghubung basis data (Product, Order, Wallet, dll)
└── Services/                      # Lapisan Logika Bisnis
    ├── CartService.php            # Validasi batasan keranjang untuk penjual tunggal
    ├── DashboardService.php       # Kalkulasi statistik pada dashboard penjual
    ├── OrderService.php           # Logika perekaman transaksi pada basis data
    └── StockService.php           # Validasi serta pengurangan jumlah stok otomatis
```

---

## 🛠️ Stack Teknologi

- **Kerangka Kerja Utama**: [Laravel 13](https://laravel.com)
- **Lapisan Antarmuka**: [Blade Template](https://laravel.com/docs/blade), [Tailwind CSS 4](https://tailwindcss.com), [Alpine.js](https://alpinejs.dev)
- **Panel Administratif**: [Filament](https://filamentphp.com)
- **Pembangun Aset**: Vite
- **Basis Data**: SQLite (Lingkungan Pengembangan) / MySQL (Siap Produksi)
- **Autentikasi**: Laravel Breeze
- **Manajemen Akses**: Spatie Laravel Permission
- **Dompet Digital**: Laravel Wallet
- **Ekspor Data**: Laravel Excel

---

## 🧪 Pengujian Sistem (Testing)

Proyek ini dilengkapi dengan **Feature Tests** berbasis Pest/PHPUnit untuk memverifikasi bahwa fitur-fitur yang ada berfungsi sebagaimana mestinya.

> [!TIP]
> Jalankan perintah berikut di terminal untuk memulai proses pengujian secara menyeluruh:
>
> ```bash
> php artisan test
> ```

---

## 📧 Konfigurasi Layanan Email Lokal

Secara bawaan, log pengiriman email akan dicatat di dalam berkas `storage/logs/laravel.log`. Jika pengujian ingin dilakukan dengan layanan simulasi seperti **Mailtrap**, berkas `.env` dapat disesuaikan menjadi sebagai berikut:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=nama_pengguna_disini
MAIL_PASSWORD=kata_sandi_disini
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@simpleshop.test"
MAIL_FROM_NAME="SimpleShop"
```

---

<div align="center">
  Disusun untuk keperluan pembelajaran pengembangan platform E-Commerce berbasis Laravel.
</div>
