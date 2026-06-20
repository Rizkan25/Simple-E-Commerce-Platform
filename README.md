<div align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
  
  # 🛒 SimpleShop — E-Commerce Platform
  
  **Platform E-Commerce Multi-Seller yang Ringan & Modern** dibangun dengan arsitektur TALL stack (Tailwind CSS, Alpine.js, Laravel) dan terintegrasi secara penuh dengan ekosistem Filament PHP untuk kemudahan manajemen administratif.
  
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

## 📖 Deskripsi Komprehensif Platform

**SimpleShop** adalah solusi platform e-commerce yang dirancang secara spesifik dan terstruktur untuk mendukung ekosistem **Multi-Seller Marketplace** (Pusat Perbelanjaan Multi-Penjual). Melalui arsitektur sistem ini, pendaftaran pengguna difasilitasi ke dalam berbagai klasifikasi peran utama:
- **Buyer (Pembeli):** Peran yang difokuskan pada penelusuran katalog, pengelolaan keranjang belanja, hingga penyelesaian transaksi pembelian produk.
- **Seller (Penjual):** Peran bagi pengguna yang mendaftarkan entitas toko secara mandiri untuk mengelola inventaris produk, memproses pesanan masuk, serta mengelola pencairan dana hasil penjualan.
- **Admin:** Peran administratif dengan otoritas penuh untuk memantau keberjalanan platform, memodifikasi pengaturan sistem dasar, serta melakukan intervensi jika terdapat sengketa transaksi.

Platform ini telah berevolusi dengan serangkaian pembaruan fungsionalitas tingkat lanjut. Di antaranya adalah sistem manajemen produk yang mendetail (termasuk penerapan diskon khusus dan regulasi *Cash on Delivery*), keranjang belanja asinkronus berbasis integrasi AJAX, mekanisme penyelesaian transaksi (checkout) yang divalidasi oleh sistem keamanan *Pessimistic Locking* guna mencegah duplikasi pengurang stok pada waktu bersamaan, hingga integrasi dompet digital internal (*wallet*) untuk simplifikasi perputaran dana di dalam ekosistem.

---

## ✨ Rincian Fungsionalitas Utama

### 🛍️ Modul Evaluasi dan Transaksi Pembeli (Buyer)
- **Katalog Terbuka & Pencarian Dinamis (Live Search):** Fasilitas pencarian produk yang terintegrasi dengan metode penyaringan berbasis kategori. Proses pencarian beroperasi secara *real-time* memanfaatkan antarmuka API (berbasis AJAX), yang memungkinkan pembaruan hasil pencarian secara seketika tanpa memerlukan pemuatan ulang (*reload*) pada halaman utama.
- **Manajemen Profil & Personalisasi Avatar:** Dukungan teknis bagi entitas pengguna untuk memperbarui informasi personal serta mengunggah atau mengganti foto profil (avatar) yang disimpan menggunakan sistem penamaan berkas berbasis *timestamp* secara aman.
- **Analitik Popularitas Produk (View Tracking):** Mekanisme penghitungan otomatis yang mencatat setiap kunjungan (tayangan) pada halaman detail produk. Kalkulasi metrik ini diimplementasikan untuk mendongkrak visibilitas produk yang masuk ke dalam kategori tren utama (*Trending Products*).
- **Keranjang Belanja Pintar (Smart Cart via AJAX):** Antarmuka asinkronus untuk operasi penambahan, pengurangan kuantitas, maupun penghapusan entitas produk dari keranjang belanja. Sistem ini mengimplementasikan aturan ketat berupa batasan **penjual tunggal (*single-seller*)** pada satu kali sesi keranjang belanja, guna menghindari kompleksitas perhitungan ongkos kirim dan komisi.
- **Integrasi Metode Checkout Dinamis:** Memfasilitasi fleksibilitas metode pembayaran yang mencakup Transfer Bank konvensional, layanan Bayar di Tempat (COD / *Cash on Delivery*), hingga metode mutasi saldo internal yang memanfaatkan arsitektur dompet digital (*wallet*) bawaan dari platform.
- **Pelacakan dan Manajemen Pesanan Terpusat:** Dasbor antarmuka pembeli yang menyajikan histori transaksi lengkap, pemantauan status proses pesanan secara waktu nyata, hingga kemampuan pembatalan proaktif yang diizinkan selama pesanan tersebut masih berstatus *Pending*.
- **Fasilitas Ulasan dan Penilaian (Product Reviews):** Modul interaktif pasca-transaksi yang memungkinkan pembeli untuk memberikan penilaian kuantitatif (skor bintang) serta ulasan kualitatif pada produk, setelah pesanan dinyatakan selesai secara sistem.
- **Notifikasi Terintegrasi Dalam Aplikasi (In-App Notifications):** Sistem pemberitahuan *push* pada antarmuka pengguna yang segera menyajikan informasi kritis seperti transisi status pesanan, tanpa mengharuskan pengguna untuk memeriksa kotak masuk surel.
- **Resolusi Sengketa (Dispute Mechanism):** Fasilitas formal bagi pihak pembeli untuk mengajukan eskalasi keluhan apabila terdapat indikasi ketidaksesuaian barang, kerusakan, atau kegagalan pengiriman pada pesanan yang sudah tercatat.

### 🏬 Modul Operasional Penjual (Seller) & Administratif
- **Dasbor Manajemen Analitis (Powered by Filament):** Dasbor khusus bagi penjual untuk memonitor metrik performa toko. Hal ini mencakup agregasi statistik penjualan historis, visualisasi grafik pendapatan pada interval waktu tertentu, hingga identifikasi rasio penjualan produk terlaris melalui antarmuka pengguna (UI/UX) yang dirancang khusus untuk efisiensi analisis.
- **Manajemen Inventaris Lanjutan (CRUD Produk):** Formulasi pengelolaan katalog produk yang mendalam. Penjual diizinkan untuk mengonfigurasi visibilitas produk, mengunggah dokumentasi visual (gambar), menetapkan nominal harga beserta persentase **Diskon** spesifik, hingga menonaktifkan atau mengaktifkan ketersediaan metode pengiriman **COD** pada masing-masing item produk.
- **Tahapan Pemrosesan Transaksi Pesanan:** Kemudahan operasional bagi penjual untuk melakukan transisi status pesanan dari pihak pembeli melalui empat fase validasi: `Pending` (Menunggu Pembayaran) ➔ `Paid` (Pembayaran Terverifikasi) ➔ `Shipped` (Barang dalam Pengiriman) ➔ `Completed` (Pesanan Selesai).
- **Sistem Pemotongan Komisi Berbasis Transaksi (Commission System):** Mekanisme algoritmik yang diimplementasikan untuk secara otomatis melakukan ekstraksi margin atau persentase komisi bagi pihak platform atas setiap transaksi penjualan yang berhasil diselesaikan, demi menjaga keberlanjutan operasional aplikasi.
- **Pengaturan Modul Platform Dinamis (Platform Settings):** Sebuah ruang kontrol eksklusif bagi pemegang hak administratif untuk menyesuaikan konfigurasi global platform (misalnya: mengubah besaran persentase komisi secara dinamis) tanpa intervensi langsung pada kode sumber (_ code_).
- **Mekanisme Pencairan Dana (Withdrawal):** Sistem penarikan saldo terstruktur bagi entitas penjual untuk mencairkan saldo dompet internal yang terakumulasi dari hasil penjualan produk ke rekening perbankan eksternal.
- **Distribusi Notifikasi Otomatis (Email Automation):** Pengiriman pesan elektronik (email) yang dikendalikan oleh sistem latar belakang (berbasis antrean atau *queue worker*) guna memberi informasi terkait pembaruan transisi status pesanan secara instan kepada pihak terkait.
- **Ekstraksi Data Transaksional (Export to Excel):** Fungsi khusus untuk mendukung rekapitulasi pembukuan dan audit finansial yang memungkinkan laporan data penjualan diunduh secara komprehensif ke dalam format *spreadsheet* Excel (.xlsx).

### ⚙️ Infrastruktur Sistem & Protokol Keamanan
- **Role-Based Access Control (RBAC):** Modul otorisasi berlapis dan pengelolaan kontrol akses yang ditenagai oleh paket *spatie/laravel-permission*. Protokol ini memberikan kepastian bahwa batas akses data dan fungsionalitas antara peran *Buyer*, *Seller*, serta *Admin* terisolasi secara aman.
- **Validasi Mutasi Data via Pessimistic Locking:** Pendekatan sistem basis data (tingkat relasional) yang secara aktif mengunci (*lock*) baris data produk pada saat terjadi pembacaan pada proses *checkout*. Protokol keamanan ini dihadirkan untuk mengeleminasi insiden *race-condition* (misal: dua transaksi melakukan finalisasi pemesanan pada barang dengan sisa stok 1 secara tepat bersamaan).
- **Proses Komputasi Asinkronus (Asynchronous Queues):** Pendelegasian rutinitas berintensitas tinggi, seperti inisiasi pengiriman email transaksional serta proses komputasi notifikasi massal, menuju instrumen latar belakang (*background job*). Hal ini memastikan halaman tidak mengalami proses *loading* yang berkepanjangan pada sisi pengguna.
- **Arsitektur Dompet Terdistribusi (Wallet System):** Modul pendataan fluktuasi keuangan (*ledger*) yang sangat akurat, menggunakan teknologi implementasi *bavix/laravel-wallet*. Seluruh mutasi dana atas pembayaran pesanan, pemotongan komisi, hingga permohonan pencairan terjamin validitasnya.

---

## 🚀 Panduan Instalasi dan Konfigurasi Lokal

Ikuti serangkaian instruksi instalasi di bawah ini untuk mengonfigurasi dan mereplikasi lingkungan operasional aplikasi pada infrastruktur lokal spesifikasi pengembangan (*development environment*).

> [!IMPORTANT]  
> **Prasyarat Sistem Dasar:** Pastikan ketersediaan perangkat lunak standar yang mencakup **PHP >= 8.3**, dependensi manajemen paket **Composer**, pengeksekusi sisi klien **Node.js >= 18**, serta sistem manajemen basis data relasional seperti **SQLite** atau **MySQL/MariaDB**.

```bash
# 1. Kloning repositori kode sumber ke dalam infrastruktur lokal
git clone <repository-url>
cd Simple-E-Commerce-Platform

# 2. Pengunduhan keseluruhan dependensi utilitas lapisan Backend maupun Frontend
composer install
npm install

# 3. Penetapan formulasi kredensial lingkungan aplikasi (.env)
cp .env.example .env
php artisan key:generate

# 4. Inisiasi struktur tabel basis data beserta injeksi data uji awal (Seeder)
php artisan migrate --seed

# 5. Pembuatan tautan simbolik direktori sistem berkas (Wajib untuk visualisasi gambar/avatar)
php artisan storage:link

# 6. Kompilasi modul antarmuka komponen CSS/JS (Vite & Tailwind)
npm run build
```

> [!NOTE]  
> **Menjalankan Instansi Aplikasi Terintegrasi**  
> Infrastruktur *TALL Stack* pada proyek ini merekomendasikan layanan berganda yang direpresentasikan melalui inisiasi terminal secara jamak. Bukalah tiga jendela terminal pada lingkungan kerja yang digunakan:
> - Terminal 1: `php artisan serve` (Inisiasi server HTTP utama PHP)
> - Terminal 2: `npm run dev` (Inisiasi *Hot Module Replacement* oleh Vite)
> - Terminal 3: `php artisan queue:work` (Inisiasi penanganan antrean pekerja asinkronus latar belakang)
> 
> Atau, sebagai alternatif praktis (dengan dukungan *concurrently*), pengeksekusian satu perintah eksklusif dapat dimungkinkan: `npm run dev` atau `composer dev`.
> 
> Setelah seluruh proses menyala, akses rute utama dengan menavigasikan peramban ke: **http://localhost:8000**

---

## 🔐 Kredensial Otentikasi Pengujian (Data Demo)

Instansi basis data awal mencakup rekam data pengujian operasional buatan (*Database Seeder*). Kredensial tersebut dapat segera digunakan pada antarmuka autentikasi (*login*) dengan spesifikasi di bawah ini:

### 🛡️ Akses Peran Admin
| Identitas | Alamat Surel (Email) | Konfigurasi Kata Sandi |
|---|---|---|
| **Super Admin** | `admin@example.com` | `SecretShop@2026` |

### 🏪 Akses Peran Penjual (Seller)
| Identitas Entitas Toko | Alamat Surel (Email) | Konfigurasi Kata Sandi |
|---|---|---|
| **TeknoMart** | `seller1@example.com` | `SecretShop@2026` |
| **Siti Style House** | `seller2@example.com` | `SecretShop@2026` |

### 🛒 Akses Peran Pembeli (Buyer)
| Alamat Surel (Email) | Konfigurasi Kata Sandi |
|---|---|
| `buyer1@example.com` | `SecretShop@2026` |
| `buyer2@example.com` | `SecretShop@2026` |
| `buyer3@example.com` | `SecretShop@2026` |

---

## 📂 Struktur dan Hierarki Direktori Utama

Pemisahan tanggung jawab, peranan kontrol logika, hingga rute komunikasi aplikasi divisualisasikan melalui hierarki arsitektur esensial di bawah ini:

```text
app/
├── Filament/                      # Pembangunan Antarmuka Panel Administratif (Admin/Seller Dashboard)
│   └── Resources/                 # Modul Manajemen CRUD Terpusat (Products, Orders, Categories, Users, Disputes, Withdrawals)
├── Http/
│   ├── Controllers/
│   │   ├── Admin/                 # Pengendali Fungsionalitas Hak Akses Admin (terkait Panel non-Filament jika ada)
│   │   ├── Api/                   # Penyuplai Transmisi Data Interaktif (End-point AJAX)
│   │   ├── Auth/                  # Rangkaian Modul Validasi dan Autentikasi Pengguna
│   │   ├── Seller/                # Pengendali Operasional Khusus Entitas Penjual
│   │   ├── CartController.php     # Regulasi Penambahan dan Mutasi Keranjang Belanja
│   │   ├── CheckoutController.php # Modul Logika Evaluasi dan Penyelesaian Transaksi
│   │   ├── NotificationController.php # Pengelolaan Status Notifikasi Antarmuka
│   │   ├── OrderController.php    # Modul Penanganan Riwayat dan Manajemen Pesanan Pembeli
│   │   ├── ProfileController.php  # Fasilitasi Pembaruan Data Profil dan Avatar Pengguna
│   │   ├── ReviewController.php   # Fasilitasi Mekanisme Penilaian dan Ulasan Produk
│   │   └── ShopController.php     # Pengendali Presentasi Katalog dan Penelusuran Toko
│   └── Middleware/                # Restriksi Lalu-lintas Tautan dan Verifikasi Akses Peran
├── Jobs/                          # Penanganan Interupsi Skala Latar Belakang (Contoh: SendOrderConfirmation.php)
├── Models/                        # Representasi Skema Entitas Relasional Basis Data (User, Shop, Product, Category, Cart, Order, Review, Dispute, Withdrawal, PlatformSetting)
└── Services/                      # Repositori Evaluasi Eksekusi Logika Bisnis Kompleks
    ├── CartService.php            # Validasi aturan pembatasan entitas keranjang untuk penjual tunggal
    ├── DashboardService.php       # Komputasi kalkulatorik statistik finansial pada dasbor penjual
    ├── OrderService.php           # Logika finalisasi pencatatan validasi rincian pesanan dan pemotongan saldo
    └── StockService.php           # Pengelolaan presisi ketersediaan pasokan barang dengan kapabilitas penguncian data (Pessimistic Locking)
```

---

## 📊 Diagram Relasi Entitas (ERD)

Arsitektur basis data relasional (*Entity-Relationship Diagram*) yang mendasari ekosistem platform direpresentasikan melalui diagram *Mermaid* berikut:

```mermaid
erDiagram
    USER ||--o| SHOP : "memiliki (Seller)"
    USER ||--o{ ORDER : "melakukan (Buyer)"
    USER ||--o{ CART : "memiliki"
    USER ||--o{ REVIEW : "menulis"
    USER ||--o{ DISPUTE : "mengajukan"
    USER ||--o{ WITHDRAWAL : "mengajukan (Seller)"
    
    SHOP ||--o{ PRODUCT : "menjual"
    SHOP ||--o{ ORDER : "menerima"
    SHOP ||--o{ CART : "menyediakan"
    
    CATEGORY ||--o{ PRODUCT : "mengelompokkan"
    
    PRODUCT ||--o{ CART_ITEM : "termasuk dalam"
    PRODUCT ||--o{ ORDER_ITEM : "dibeli sebagai"
    PRODUCT ||--o{ REVIEW : "mendapatkan"
    
    CART ||--|{ CART_ITEM : "berisi"
    
    ORDER ||--|{ ORDER_ITEM : "terdiri dari"
    ORDER ||--o| REVIEW : "diulas melalui"
    ORDER ||--o| DISPUTE : "disengketakan"

    USER {
        bigint id PK
        string name
        string email
        string role
    }
    SHOP {
        bigint id PK
        bigint user_id FK
        string name
    }
    CATEGORY {
        bigint id PK
        string name
    }
    PRODUCT {
        bigint id PK
        bigint seller_id FK
        bigint category_id FK
        string name
        decimal price
        integer stock
    }
    CART {
        bigint id PK
        bigint user_id FK
        bigint shop_id FK
    }
    CART_ITEM {
        bigint id PK
        bigint cart_id FK
        bigint product_id FK
        integer quantity
    }
    ORDER {
        bigint id PK
        bigint user_id FK
        bigint shop_id FK
        string status
        decimal total_amount
    }
    ORDER_ITEM {
        bigint id PK
        bigint order_id FK
        bigint product_id FK
        integer quantity
        decimal price
    }
    REVIEW {
        bigint id PK
        bigint user_id FK
        bigint product_id FK
        bigint order_id FK
        integer rating
    }
    DISPUTE {
        bigint id PK
        bigint order_id FK
        bigint user_id FK
        string status
    }
    WITHDRAWAL {
        bigint id PK
        bigint user_id FK
        decimal amount
        string status
    }
```

---

## 🛠️ Spesifikasi Teknologi dan Pustaka Terapan

- **Kerangka Kerja Utilitas (*Core Framework*)**: [Laravel 13](https://laravel.com)
- **Konstruksi Antarmuka (*Frontend Stack*)**: [Blade Template](https://laravel.com/docs/blade), [Tailwind CSS 4](https://tailwindcss.com), [Alpine.js](https://alpinejs.dev)
- **Komponen Panel Dashboard Lanjutan**: [Filament PHP](https://filamentphp.com)
- **Instrumen Pemrosesan Aset**: Vite
- **Persistensi Basis Data Utama**: SQLite (Konfigurasi Mode Pengembangan) / MySQL (Konfigurasi Standar Produksi)
- **Kerangka Autentikasi**: Laravel Breeze
- **Pengontrol Regulasi Hak Akses**: Spatie Laravel Permission
- **Manajemen Modul Dompet Transaksional**: Laravel Wallet
- **Utilitas Ekstraksi Dokumen (*Export*)**: Laravel Excel

---

## 🧪 Validasi Kelayakan dan Integritas Sistem

Integritas spesifikasi operasional divalidasi secara mendalam menggunakan sekumpulan instrumen uji kelayakan otomatis (_Automated Feature Tests_) berbasis Pest/PHPUnit. Hal ini dilakukan guna memastikan presisi serta stabilitas pada fungsionalitas utama aplikasi sebelum diterapkan pada skala yang lebih besar.

Fokus skenario pengujian komprehensif mencakup namun tidak terbatas pada:
- **Autentikasi & Otorisasi Kredensial**: Verifikasi isolasi hak akses berlapis yang mencegah kebocoran informasi antara instrumen *Admin*, *Seller*, dan *Buyer*.
- **Restriksi Keranjang & Checkout**: Penegasan operasional atas implementasi aturan pembatasan penjual (*single-seller cart restriction*) pada satu waktu pesanan.
- **Konsistensi Transaksi (Database Rollback & Locking)**: Evaluasi terhadap mekanisme pertahanan keamanan operasional, termasuk *Pessimistic Locking*, dalam menangani serta menahan eskalasi antrean permintaan pemesanan masif yang berpotensi menyebabkan ketidakakuratan saldo maupun inventaris stok.

> [!TIP]
> Evaluasi dan simulasi validasi eksekusi sistem secara menyeluruh dapat diluncurkan secara lokal dengan mendayagunakan baris komando berikut di dalam terminal kerja:
> ```bash
> php artisan test
> ```

---

## 📧 Modul Penanganan dan Evaluasi Email Transaksional

Pengiriman notifikasi surel (*email*) pada platform ini diformulasikan untuk berjalan **secara asinkronus di latar belakang** (_background queue task_). Tujuannya adalah demi menghindari latensi maupun kelambatan waktu respons pada antarmuka bagi sisi pengguna akhir. Prosedur validasi layanan komunikasi secara lokal membutuhkan adaptasi konfigurasi sebagai berikut:

### 1. Inisiasi Pekerja Antrean (Queue Worker)
Semua bentuk instruksi pengiriman surel secara mendasar dialihkan menuju sistem antrean. Oleh sebab itu, ketersediaan instansi komando khusus sangat diwajibkan untuk tetap beroperasi secara mandiri di sisi terminal:

```bash
php artisan queue:work
```

> [!IMPORTANT]
> Pastikan instansi terminal yang meluncurkan penugasan antrean latar belakang di atas tetap terbuka selama proses uji coba transaksional terus berlangsung (seperti pada simulasi penyerahan maupun pembatalan pesanan yang men-trigger modul notifikasi surel).

### 2. Evaluasi Log Email Lokal (Mekanisme Bawaan)
Konfigurasi lingkungan standar sama sekali tidak mensyaratkan dependensi terhadap infrastruktur layanan jaringan luar (*external service*), melainkan sekadar mencetak muatan pesan ke dalam berkas perekam kejadian (*log file*) lokal.
1. Evaluasi parameter konfigurasi pada berkas `.env` hingga tertera format instruksi: `MAIL_MAILER=log`
2. Lakukan simulasi aktivitas pemicu surel transaksional pada platform aplikasi yang sedang beroperasi.
3. Rincian muatan pesan serta informasi tautan spesifik dapat dievaluasi secara teks secara langsung melalui peninjauan berkas pada jalur: `storage/logs/laravel.log`.

### 3. Simulasi Kotak Masuk Visual Menggunakan Mailtrap
Fasilitas infrastruktur pihak ketiga seperti layanan **[Mailtrap](https://mailtrap.io)** sangat direkomendasikan untuk keperluan evaluasi representasi visual struktur email secara murni (*HTML renderable*).
1. Akses fasilitas menu parameter SMTP pada panel dasbor pengguna Mailtrap.
2. Integrasikan penyesuaian parameter variabel SMTP terkait secara cermat pada konfigurasi variabel lingkungan `.env` aplikasi lokal:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=isikan_kredensial_nama_pengguna_secara_akurat
MAIL_PASSWORD=isikan_kredensial_kata_sandi_secara_akurat
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@simpleshop.test"
MAIL_FROM_NAME="SimpleShop_Automated_System"
```

> [!TIP]
> Setelah modifikasi konfigurasi paramater surel direalisasikan, eksekusi pemuatan ulang atau penghentian sesi sesaat (*restart*) mutlak diperlukan pada layanan pengerjaan latar belakang (`php artisan queue:work`) serta penyedia infrastruktur HTTP utama (`php artisan serve`). Hal ini dilakukan agar keseluruhan pembaruan variabel sistem dapat terinisiasi secara benar.

---

<div align="center">
  Diimplementasikan dan disusun sedemikian rupa untuk menunjang objektif pemahaman infrastruktur layanan teknologi e-commerce termutakhir berbasis kerangka pengembangan PHP Laravel.
</div>
