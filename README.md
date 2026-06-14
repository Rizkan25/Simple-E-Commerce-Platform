# SimpleShop — Simple E-Commerce Platform

Platform e-commerce sederhana yang dibangun dengan **Laravel 13**, **Breeze**, **Blade**, **Alpine.js**, dan **Tailwind CSS 4**. Mendukung fitur multi-seller marketplace dengan sistem autentikasi berbasis role (Buyer & Seller).

## ✨ Fitur Utama

### Buyer
- 🛍️ Browse katalog produk dengan search & filter kategori
- 🛒 Keranjang belanja dengan AJAX (tambah, update jumlah, hapus)
- 📦 Checkout dengan pilihan metode pembayaran (Transfer Bank / COD)
- 📋 Riwayat pesanan dan detail pesanan
- ❌ Pembatalan pesanan (status pending)

### Seller
- 📊 Dashboard dengan statistik penjualan, grafik 7 hari, dan produk terlaris
- 📦 CRUD produk lengkap dengan upload gambar
- 📋 Manajemen pesanan masuk dengan update status (Pending → Paid → Shipped → Completed)
- 📧 Notifikasi email otomatis saat status pesanan berubah

### Sistem
- 🔐 Autentikasi berbasis role (buyer/seller)
- 🛡️ Middleware role protection
- 📝 Policy-based authorization
- 🔒 Pessimistic locking pada checkout (mencegah race condition)
- 🛒 Single-seller cart constraint
- 📧 Queued email notifications
- 🖼️ Upload gambar dengan nama unik (timestamp + random)

## 🚀 Instalasi

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js >= 18
- SQLite (default) atau MySQL

### Setup

```bash
# Clone repository
git clone <repository-url>
cd Simple-E-Commerce-Platform

# Install dependencies
composer install
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Set database di .env (default sudah SQLite)
# DB_CONNECTION=sqlite

# Jalankan migrasi dan seeder
php artisan migrate --seed

# Buat symlink untuk storage
php artisan storage:link

# Build frontend assets
npm run build

# Jalankan queue worker (terminal terpisah, untuk email notifications)
php artisan queue:work

# Jalankan development server
php artisan serve
```

Akses aplikasi di **http://localhost:8000**

### Development Mode (Hot Reload)

```bash
# Di terminal terpisah, jalankan Vite dev server
npm run dev
```

## 👤 Akun Demo

### Seller

| Email | Password | Toko |
|-------|----------|------|
| `seller1@example.com` | `password` | TeknoMart |
| `seller2@example.com` | `password` | Siti Style House |

### Buyer

| Email | Password |
|-------|----------|
| `buyer1@example.com` | `password` |
| `buyer2@example.com` | `password` |
| `buyer3@example.com` | `password` |

## 📁 Struktur Proyek

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/                    # Login, Register (role-based)
│   │   ├── Seller/                  # Dashboard, Product CRUD, Order management
│   │   ├── CartController.php       # Keranjang (AJAX)
│   │   ├── CheckoutController.php   # Proses checkout
│   │   ├── OrderController.php      # Pesanan buyer
│   │   └── ShopController.php       # Katalog produk
│   ├── Middleware/
│   │   └── RoleMiddleware.php       # Role-based access control
│   └── Requests/                    # Form validation
├── Jobs/
│   └── SendOrderConfirmation.php    # Queued email job
├── Mail/
│   ├── OrderConfirmation.php        # Mailable: konfirmasi pesanan
│   └── OrderStatusUpdated.php       # Mailable: update status
├── Models/                          # Eloquent models with relationships
├── Policies/
│   └── ProductPolicy.php           # Authorization rules
└── Services/
    ├── CartService.php              # Cart logic (single-seller)
    ├── DashboardService.php         # Stats & analytics
    ├── OrderService.php             # Checkout with DB transaction
    └── StockService.php             # Stock validation & deduction
```

## 🧪 Testing

```bash
# Jalankan semua test
php artisan test

# Jalankan test tertentu
php artisan test --filter=RegistrationTest
php artisan test --filter=ProductManagementTest
php artisan test --filter=CheckoutTest
```

### Test Cases

| Test | Deskripsi |
|------|-----------|
| **RegistrationTest** | Registrasi buyer & seller, validasi role, store_name required untuk seller |
| **ProductManagementTest** | Seller CRUD produk, buyer tidak bisa akses, cross-seller authorization |
| **CheckoutTest** | Checkout sukses dengan stok cukup, gagal dengan stok kurang (rollback), validasi form |

## 🛠️ Tech Stack

- **Backend**: Laravel 13, PHP 8.2+
- **Frontend**: Blade, Alpine.js, Tailwind CSS 4
- **Database**: SQLite (development), MySQL (production)
- **Build Tool**: Vite
- **Auth**: Laravel Breeze (Blade stack)
- **Queue**: Database driver (configurable)
- **Mail**: Mailtrap / Log (development)

## 📧 Konfigurasi Email

Untuk development, email disimpan di log (`storage/logs/laravel.log`). Untuk menggunakan Mailtrap:

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

## 📝 Lisensi

MIT License
