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

## 👥 Anggota Kelompok 3

1. **Rahmi Mariati**
2. **Farhan Alfarisi**
3. **Ulun Nuha Mafri**
4. **Muhamad Adzky Maulana**
5. **Maula Rizkan**

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

Untuk menjalankan aplikasi ini di komputer Anda, ikuti langkah-langkah sederhana berikut:

> [!IMPORTANT]
> **Persiapan Awal:** Pastikan komputer Anda sudah terpasang **PHP (Minimal versi 8.3)**, **Composer**, dan **Node.js (Minimal versi 18)**. Secara bawaan, sistem akan menggunakan _database_ SQLite sehingga Anda tidak perlu mengatur server MySQL/MariaDB jika hanya untuk mencoba.

**Langkah 1: Unduh Kode & Masuk ke Folder**
Buka terminal Anda, unduh (_clone_) kode sumber aplikasi, lalu pindah ke dalam folder proyek:

```bash
git clone <repository-url>
cd Simple-E-Commerce-Platform
```

**Langkah 2: Instalasi Kebutuhan Sistem**
Unduh semua paket pendukung (_library_) yang dibutuhkan oleh _Backend_ (PHP) maupun _Frontend_ (Node.js):

```bash
composer install
npm install
```

**Langkah 3: Persiapkan Pengaturan Sistem**
Buat _file_ konfigurasi lokal (`.env`) dengan menyalin dari contoh yang sudah disediakan, lalu buat kunci keamanan untuk aplikasi:

```bash
cp .env.example .env
php artisan key:generate
```

**Langkah 4: Siapkan Database & Foto Produk**
Buat struktur _database_ beserta akun-akun pengujian (_dummy_) secara otomatis, lalu hubungkan folder penyimpanan agar gambar produk dan avatar bisa ditampilkan di peramban:

```bash
php artisan migrate --seed
php artisan storage:link
```

**Langkah 5: Nyalakan Aplikasi!**
Aplikasi modern ini membutuhkan 3 mesin yang berjalan bersamaan. Silakan buka **3 jendela terminal yang berbeda**, lalu jalankan perintah ini satu per satu di masing-masing terminal:

1. `php artisan serve` _(Terminal 1: Menjalankan server website utama)_
2. `npm run dev` _(Terminal 2: Memproses desain visual CSS/JS secara instan)_
3. `php artisan queue:work` _(Terminal 3: Memproses antrean email di latar belakang)_

> [!TIP]
> **Selamat! 🎉** Aplikasi Anda sudah menyala. Silakan buka _browser_ Anda dan kunjungi alamat: **http://localhost:8000**

---

## 🔐 Kredensial Pengujian (Demo)

Sistem telah dilengkapi dengan _Database Seeder_ untuk memudahkan proses pengujian. Silakan gunakan kredensial berikut untuk melakukan proses masuk (_login_):

### 🛡️ Akses Admin

| Jabatan         | Email               | Kata Sandi        |
| --------------- | ------------------- | ----------------- |
| **Super Admin** | `admin@example.com` | `SecretShop@2026` |

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

Aplikasi ini telah dibekali dengan pengujian otomatis (_Automated Tests_) menggunakan **Pest/PHPUnit** guna memastikan fitur-fitur krusial selalu berfungsi dengan baik dan bebas _bug_.

Beberapa skenario utama yang diuji oleh sistem secara otomatis meliputi:

- **Autentikasi & Hak Akses**: Memastikan Admin, Seller, dan Buyer hanya bisa mengakses halamannya masing-masing.
- **Keranjang & Checkout**: Memastikan aturan batasan "satu toko per _checkout_" berjalan dengan benar.
- **Keamanan Transaksi**: Menguji mekanisme _Pessimistic Locking_ agar tidak ada pesanan ganda saat _traffic_ sedang tinggi.

**Cara Menjalankan Pengujian:**
Anda cukup menjalankan satu baris perintah berikut di terminal:

```bash
php artisan test
```

> [!TIP]
> Sistem akan secara otomatis menyimulasikan seluruh skenario di atas di latar belakang, lalu menampilkan laporan centang hijau (✅) jika seluruh fitur dipastikan aman dan siap digunakan!

---

## 📧 Konfigurasi Layanan Email Lokal

Sistem pengiriman email di aplikasi ini berjalan **secara asinkronus di latar belakang** (_background queue_) untuk mencegah aplikasi menjadi lambat saat pelanggan melakukan transaksi. Berikut adalah langkah detail untuk menguji sistem email di komputer lokal:

### 1. Menjalankan Pekerja Antrean (Queue Worker)

Karena email menggunakan sistem antrean, Anda **WAJIB** menjalankan satu proses khusus di terminal agar email yang tertunda dapat diproses dan dikirimkan:

```bash
php artisan queue:work
```

> [!IMPORTANT]
> Biarkan terminal yang menjalankan perintah ini tetap terbuka (_running_) di latar belakang selama Anda ingin menguji fitur-fitur notifikasi email (seperti fitur perubahan status pesanan).

### 2. Metode 1: Melihat Email via Teks (Bawaan)

Secara bawaan, Anda tidak perlu mengkonfigurasi internet atau layanan apapun. Aplikasi akan sekadar "mencatat" isi email ke dalam sebuah file teks lokal.

1. Buka file `.env` di folder utama aplikasi, pastikan pengaturannya seperti ini: `MAIL_MAILER=log`
2. Lakukan aktivitas di aplikasi yang memicu email (misal: Admin mengubah status pesanan).
3. Buka file `storage/logs/laravel.log`. Anda bisa membaca seluruh isi pesan email dan tautannya dari file tersebut.

### 3. Metode 2: Kotak Masuk Visual dengan Mailtrap

Jika Anda ingin simulasi yang lebih nyata dan ingin melihat bentuk asli emailnya (lengkap dengan desain dan warna), Anda bisa menggunakan layanan gratis seperti **[Mailtrap](https://mailtrap.io)**.

1. Buat akun gratis di Mailtrap dan akses bagian _Inboxes_.
2. Pilih menu _SMTP Settings_, lalu salin kredensial yang diberikan.
3. Buka file `.env` Anda, ubah bagian email menyesuaikan data dari Mailtrap:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=paste_username_dari_mailtrap_disini
MAIL_PASSWORD=paste_password_dari_mailtrap_disini
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@simpleshop.test"
MAIL_FROM_NAME="SimpleShop"
```

> [!TIP]
> Setelah Anda mengubah isi file `.env`, jangan lupa untuk **mematikan lalu menyalakan ulang** (_restart_) perintah `php artisan queue:work` dan `php artisan serve` Anda agar pengaturan baru dapat terbaca oleh sistem.

---

<div align="center">
  Disusun untuk keperluan pembelajaran pengembangan platform E-Commerce berbasis Laravel.
</div>
