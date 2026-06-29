<div align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
  
  # 🛒 SimpleShop — E-Commerce Platform

**Platform E-Commerce Multi-Seller yang Ringan & Modern** dibangun dengan arsitektur TALL stack (Tailwind CSS, Alpine.js, Laravel) dan terintegrasi secara penuh dengan ekosistem Filament PHP untuk kemudahan manajemen administratif.

### **🌐 Live Demo:** [https://simple-shop-web.onrender.com](https://simple-shop-web.onrender.com/)

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

Platform ini telah berevolusi dengan serangkaian pembaruan fungsionalitas tingkat lanjut. Di antaranya adalah sistem manajemen produk yang mendetail (termasuk penerapan diskon khusus dan regulasi _Cash on Delivery_), keranjang belanja asinkronus berbasis integrasi AJAX, mekanisme penyelesaian transaksi (checkout) yang divalidasi oleh sistem keamanan _Pessimistic Locking_ guna mencegah duplikasi pengurang stok pada waktu bersamaan, hingga integrasi dompet digital internal (_wallet_) untuk simplifikasi perputaran dana di dalam ekosistem.

---

## 🥞 Arsitektur TALL Stack

Aplikasi ini dikembangkan di atas fondasi **TALL Stack**, sebuah ekosistem pengembangan web modern yang menawarkan keseimbangan sempurna antara produktivitas _developer_, performa sistem, dan pengalaman antarmuka (_User Experience_) yang sangat interaktif. TALL adalah akronim dari:

- **[T]ailwind CSS**: Kerangka kerja (_framework_) _utility-first CSS_ yang digunakan untuk merancang tata letak dan desain antarmuka secara kustom, responsif, elegan, dan konsisten secara langsung tanpa penulisan berkas CSS terpisah yang membengkak.
- **[A]lpine.js**: Pustaka JavaScript ringan dan tangguh yang menyuntikkan interaktivitas (_reactivity_) pada sisi klien (_client-side_). Alpine dipercaya mengatur komponen antarmuka _front-end_ dinamis seperti _dropdown modal_, penutupan notifikasi mandiri, hingga manipulasi antarmuka keranjang belanja asinkronus (_AJAX integration_) tanpa _overhead_ dari pustaka JavaScript berukuran besar.
- **[L]aravel**: Bertindak sebagai mesin tulang punggung infrastruktur (_Backend_). Kerangka kerja PHP kelas _enterprise_ ini menangani orkestrasi seluruh logika bisnis, relasi _database_ yang rumit, proteksi keamanan tingkat tinggi (_Pessimistic Locking_ & otentikasi lapis ganda), hingga manajemen rutinitas asinkronus latar belakang (_Queue Workers_).
- **[L]ivewire**: _Framework full-stack_ inovatif di ekosistem Laravel. Pada aplikasi ini, kekuatan super **Livewire** dimanfaatkan secara masif melalui integrasi [Filament PHP](https://filamentphp.com). Teknologi inilah yang memungkinkan keseluruhan interaksi di dalam Dasbor Administratif (_Seller/Admin Console_) berjalan reaktif, cepat, dan mulus layaknya _Single Page Application_ (SPA) tanpa perlu penulisan API sisi _client_ yang rumit.

Sinergi teknologi arsitektural ini memastikan pengalaman pengguna di ujung layar (_end-user_) berjalan begitu cepat dan mulus, sembari mempertahankan integritas keamanan serta stabilitas kode tingkat lanjut di belakang layar.

---

## ✨ Rincian Fungsionalitas Utama

### 🛍️ Modul Evaluasi dan Transaksi Pembeli (Buyer)

- **Katalog Terbuka & Pencarian Dinamis (Live Search):** Fasilitas pencarian produk yang terintegrasi dengan metode penyaringan berbasis kategori. Proses pencarian beroperasi secara _real-time_ memanfaatkan antarmuka API (berbasis AJAX), yang memungkinkan pembaruan hasil pencarian secara seketika tanpa memerlukan pemuatan ulang (_reload_) pada halaman utama.
- **Manajemen Profil & Personalisasi Avatar:** Dukungan teknis bagi entitas pengguna untuk memperbarui informasi personal serta mengunggah atau mengganti foto profil (avatar) yang disimpan menggunakan sistem penamaan berkas berbasis _timestamp_ secara aman.
- **Analitik Popularitas Produk (View Tracking):** Mekanisme penghitungan otomatis yang mencatat setiap kunjungan (tayangan) pada halaman detail produk. Kalkulasi metrik ini diimplementasikan untuk mendongkrak visibilitas produk yang masuk ke dalam kategori tren utama (_Trending Products_).
- **Keranjang Belanja Pintar & Multi-Penjual (Smart Cart via AJAX):** Antarmuka asinkronus untuk operasi penambahan, pengurangan kuantitas, maupun penghapusan entitas produk dari keranjang belanja. Sistem ini kini mendayagunakan kapabilitas **Multi-Seller Cart**, memungkinkan pembeli untuk mencampur ragam produk dari berbagai penjual yang berbeda dalam satu kali sesi keranjang secara bersamaan tanpa batasan.
- **Algoritma Checkout & Pemisahan Pesanan Otomatis:** Memfasilitasi fleksibilitas pembayaran (Transfer Bank, Saldo Wallet, hingga COD). Algoritma checkout secara otomatis akan **memecah (_split order_)** satu keranjang multi-penjual menjadi beberapa catatan pesanan terpisah berdasarkan identitas masing-masing penjual. Di samping itu, khusus untuk metode pembayaran _Cash on Delivery_ (COD), algoritma akan secara selektif memfilter dan hanya memproses produk-produk yang mengizinkan dukungan COD.
- **Pelacakan dan Manajemen Pesanan Terpusat:** Dasbor antarmuka pembeli yang menyajikan histori transaksi lengkap, pemantauan status proses pesanan secara waktu nyata, hingga kemampuan pembatalan proaktif yang diizinkan selama pesanan tersebut masih berstatus _Pending_.
- **Fasilitas Ulasan dan Penilaian (Product Reviews):** Modul interaktif pasca-transaksi yang memungkinkan pembeli untuk memberikan penilaian kuantitatif (skor bintang) serta ulasan kualitatif pada produk, setelah pesanan dinyatakan selesai secara sistem.
- **Notifikasi Terintegrasi Dalam Aplikasi (In-App Notifications):** Sistem pemberitahuan _push_ pada antarmuka pengguna yang segera menyajikan informasi kritis seperti transisi status pesanan, tanpa mengharuskan pengguna untuk memeriksa kotak masuk surel.
- **Resolusi Sengketa (Dispute Mechanism):** Fasilitas formal bagi pihak pembeli untuk mengajukan eskalasi keluhan apabila terdapat indikasi ketidaksesuaian barang, kerusakan, atau kegagalan pengiriman pada pesanan yang sudah tercatat.

### 🏬 Modul Operasional Penjual (Seller) & Administratif

- **Konsol Administratif & Analitik Terpusat (Stitch Dashboard):** Implementasi dasbor administratif tingkat lanjut (_Admin Console_) yang ditenagai oleh Filament. Fasilitas ini menyediakan analitik komprehensif yang mencakup pelacakan metrik _Gross Merchandise Value_ (GMV), tren peningkatan penjual aktif dan pelanggan baru, serta kalkulasi akumulasi biaya platform (_Platform Fee_). Dilengkapi dengan visualisasi data melalui grafik _Donut Chart_ untuk status pesanan dan grafik garis (_Line Chart_) untuk riwayat tren penjualan (mingguan, bulanan, tahunan).
- **Manajemen Inventaris Lanjutan (CRUD Produk):** Formulasi pengelolaan katalog produk yang mendalam. Penjual diizinkan untuk mengonfigurasi visibilitas produk, mengunggah dokumentasi visual (gambar), menetapkan nominal harga beserta persentase **Diskon** spesifik, hingga menonaktifkan atau mengaktifkan ketersediaan metode pengiriman **COD** pada masing-masing item produk.
- **Tahapan Pemrosesan & Pencairan Dana Otomatis (Escrow-like Order Flow):** Kemudahan operasional bagi penjual untuk melakukan transisi status pesanan dari pihak pembeli melalui empat fase validasi: `Pending` (Menunggu Pembayaran) ➔ `Paid` (Pembayaran Terverifikasi) ➔ `Shipped` (Barang dalam Pengiriman) ➔ `Completed` (Pesanan Selesai). Pada sistem ini, pembayaran dari pembeli akan ditampung terlebih dahulu oleh Platform. Saat pesanan beralih ke status `Completed`, sistem secara otomatis akan mencairkan dan meneruskan dana penjualan ke saldo dompet (wallet) penjual terkait.
- **Sistem Pemotongan Komisi Berbasis Transaksi (Commission System):** Mekanisme algoritmik yang bekerja selaras dengan proses penyelesaian pesanan di atas. Sistem secara otomatis melakukan ekstraksi persentase komisi bagi pihak platform secara _real-time_ tepat sebelum dana diteruskan ke dompet penjual, memastikan keberlanjutan operasional aplikasi.
- **Antarmuka Tabel Dinamis & Pengurutan Cerdas (Smart Data Sorting):** Menyajikan data operasional melalui tabel interaktif yang mendukung pengurutan (_sorting_) multi-kolom secara presisi (berdasarkan tanggal, harga, maupun stok). Pengalaman antarmuka (UI/UX) telah diselaraskan pada seluruh panel Seller dan Admin guna menampilkan indikator pengurutan yang sangat bersih dan rapi.
- **Pengaturan Modul Platform Dinamis (Platform Settings):** Sebuah ruang kontrol eksklusif bagi pemegang hak administratif untuk menyesuaikan konfigurasi global platform (seperti modifikasi besaran persentase komisi hingga pembaruan informasi rekening bank operasional utama platform) secara dinamis tanpa intervensi langsung pada kode sumber (_source code_). Fitur ini telah dilengkapi validasi cerdas untuk memverifikasi kesesuaian panjang karakter nomor rekening terhadap bank yang dipilih dan desain _form_ yang dioptimalkan secara visual.
- **Mekanisme Pencairan Dana (Withdrawal):** Sistem penarikan saldo terstruktur bagi entitas penjual untuk mencairkan saldo dompet internal yang terakumulasi dari hasil penjualan produk ke rekening perbankan eksternal. Dasbor juga memungkinkan admin untuk memantau pengajuan penarikan dana terkini.
- **Distribusi Notifikasi Otomatis (Email Automation):** Pengiriman pesan elektronik (email) yang dikendalikan oleh sistem latar belakang (berbasis antrean atau _queue worker_) guna memberi informasi terkait pembaruan transisi status pesanan secara instan kepada pihak terkait.
- **Ekstraksi Data Transaksional Multi-Format (Export to Excel/CSV/HTML):** Fungsi khusus untuk mendukung rekapitulasi pembukuan dan audit finansial yang memungkinkan laporan data metrik dasbor serta riwayat penjualan diunduh secara komprehensif ke dalam berbagai format _spreadsheet_ yang dirender sempurna melalui pustaka `Maatwebsite/Excel`.

### ⚙️ Infrastruktur Sistem & Protokol Keamanan

- **Role-Based Access Control (RBAC):** Modul otorisasi berlapis dan pengelolaan kontrol akses yang ditenagai oleh paket _spatie/laravel-permission_. Protokol ini memberikan kepastian bahwa batas akses data dan fungsionalitas antara peran _Buyer_, _Seller_, serta _Admin_ terisolasi secara aman.
- **Validasi Mutasi Data via Pessimistic Locking:** Pendekatan sistem basis data (tingkat relasional) yang secara aktif mengunci (_lock_) baris data produk pada saat terjadi pembacaan pada proses _checkout_. Protokol keamanan ini dihadirkan untuk mengeleminasi insiden _race-condition_ (misal: dua transaksi melakukan finalisasi pemesanan pada barang dengan sisa stok 1 secara tepat bersamaan).
- **Proses Komputasi Asinkronus (Asynchronous Queues):** Pendelegasian rutinitas berintensitas tinggi, seperti inisiasi pengiriman email transaksional serta proses komputasi notifikasi massal, menuju instrumen latar belakang (_background job_). Hal ini memastikan halaman tidak mengalami proses _loading_ yang berkepanjangan pada sisi pengguna.
- **Arsitektur Dompet Terdistribusi (Wallet System):** Modul pendataan fluktuasi keuangan (_ledger_) yang sangat akurat, menggunakan teknologi implementasi _bavix/laravel-wallet_. Seluruh mutasi dana atas pembayaran pesanan, pemotongan komisi, hingga permohonan pencairan terjamin validitasnya.
- **Perlindungan Sesi dan Rute Sensitif (Method Protection):** Penegakan aturan keamanan mutlak (termasuk perlindungan CSRF) pada _endpoint_ krusial seperti proses Autentikasi Keluar (_Logout_), yang secara ketat hanya dapat dieksekusi melalui metode HTTP POST guna memitigasi kerentanan eksekusi rute yang tidak disengaja oleh _prefetch_ peramban.

---

## 🚀 Panduan Instalasi dan Konfigurasi Lokal

Ikuti serangkaian instruksi instalasi di bawah ini untuk mengonfigurasi dan mereplikasi lingkungan operasional aplikasi pada infrastruktur lokal spesifikasi pengembangan (_development environment_).

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
> Infrastruktur _TALL Stack_ pada proyek ini merekomendasikan layanan berganda yang direpresentasikan melalui inisiasi terminal secara jamak. Bukalah tiga jendela terminal pada lingkungan kerja yang digunakan:
>
> - Terminal 1: `php artisan serve` (Inisiasi server HTTP utama PHP)
> - Terminal 2: `npm run dev` (Inisiasi _Hot Module Replacement_ oleh Vite)
> - Terminal 3: `php artisan queue:work` (Inisiasi penanganan antrean pekerja asinkronus latar belakang)
>
> Atau, sebagai alternatif praktis (dengan dukungan _concurrently_), pengeksekusian satu perintah eksklusif dapat dimungkinkan: `npm run dev` atau `composer dev`.
>
> Setelah seluruh proses menyala, akses rute utama dengan menavigasikan peramban ke: **http://localhost:8000**

---

## 🔐 Kredensial Otentikasi Pengujian (Data Demo)

Instansi basis data awal mencakup rekam data pengujian operasional buatan (_Database Seeder_). Kredensial tersebut dapat segera digunakan pada antarmuka autentikasi (_login_) dengan spesifikasi di bawah ini:

> [!NOTE]  
> **Penggunaan di Lingkungan Produksi (Live/Render):** Seluruh akun demo di bawah ini tetap dapat digunakan sepenuhnya pada website _Live_ di tautan **[https://simple-shop-web.onrender.com](https://simple-shop-web.onrender.com/)** (karena data telah disinkronkan ke PostgreSQL Render). Di sisi lain, karena aplikasi ini tidak mewajibkan aktivasi verifikasi email, penguji atau pengunjung juga diizinkan untuk menekan tombol **Register** dan mendaftarkan akun baru secara instan menggunakan sembarang alamat surel (misal: `aku@ngasal.com`) untuk langsung berbelanja tanpa hambatan.

### 💡 Mengapa Menggunakan Akun Demo / Tanpa Verifikasi Email Asli?
Untuk keperluan pameran, presentasi, atau Gelar Karya, platform ini sengaja disesuaikan agar **tidak memerlukan verifikasi email sungguhan (SMTP)**. Keputusan arsitektural ini diambil dengan pertimbangan berikut:
1. **Kecepatan & Kemudahan Demonstrasi:** Penguji atau dosen dapat langsung terjun menguji alur sistem utama (seperti *checkout*, integrasi dompet digital, hingga panel admin) dalam hitungan detik tanpa harus repot membuka kotak masuk surel mereka untuk mencari *link* aktivasi.
2. **Keterbatasan Server Cloud (Anti-Spam):** Layanan *hosting* PaaS masa kini seringkali secara ketat memblokir lalu lintas pengiriman email tak terverifikasi pada tingkatan infrastruktur untuk mencegah penyalahgunaan server sebagai *botnet/spam*. Memaksakan penggunaan *real email* tanpa domain berbayar sangat berisiko menyebabkan *Error 500* di tengah-tengah presentasi. Oleh karena itu, pendekatan akun demo menjadi solusi presentasi yang 100% aman dan stabil.

### 🛡️ Akses Peran Admin

| Identitas       | Alamat Surel (Email) | Konfigurasi Kata Sandi |
| --------------- | -------------------- | ---------------------- |
| **Super Admin** | `admin@example.com`  | `SecretShop@2026`      |

### 🏪 Akses Peran Penjual (Seller)

| Identitas Entitas Toko | Alamat Surel (Email)  | Konfigurasi Kata Sandi |
| ---------------------- | --------------------- | ---------------------- |
| **TeknoMart**          | `seller1@example.com` | `SecretShop@2026`      |
| **Siti Style House**   | `seller2@example.com` | `SecretShop@2026`      |

### 🛒 Akses Peran Pembeli (Buyer)

| Alamat Surel (Email) | Konfigurasi Kata Sandi |
| -------------------- | ---------------------- |
| `buyer1@example.com` | `SecretShop@2026`      |
| `buyer2@example.com` | `SecretShop@2026`      |
| `buyer3@example.com` | `SecretShop@2026`      |

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

Arsitektur basis data relasional (_Entity-Relationship Diagram_) yang mendasari ekosistem platform direpresentasikan melalui diagram _Mermaid_ berikut:

```mermaid
erDiagram
    USER ||--o{ PRODUCT : "menjual (Seller)"
    USER ||--o{ ORDER : "melakukan (Buyer)"
    USER ||--o{ ORDER_ITEM : "menerima pesanan (Seller)"
    USER ||--o{ CART : "memiliki"
    USER ||--o{ REVIEW : "menulis"
    USER ||--o{ DISPUTE : "mengajukan"
    USER ||--o{ WITHDRAWAL : "mengajukan (Seller)"

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
        string status
        decimal total_amount
    }
    ORDER_ITEM {
        bigint id PK
        bigint order_id FK
        bigint product_id FK
        bigint seller_id FK
        integer quantity
        decimal price_at_order
        decimal platform_fee
        decimal seller_earnings
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

- **Kerangka Kerja Utilitas (_Core Framework_)**: [Laravel 13](https://laravel.com)
- **Konstruksi Antarmuka (_Frontend Stack_)**: [Blade Template](https://laravel.com/docs/blade), [Tailwind CSS 4](https://tailwindcss.com), [Alpine.js](https://alpinejs.dev)
- **Komponen Panel Dashboard Lanjutan**: [Filament PHP](https://filamentphp.com)
- **Instrumen Pemrosesan Aset**: Vite
- **Persistensi Basis Data Utama**: SQLite (Konfigurasi Mode Pengembangan) / PostgreSQL (Konfigurasi Standar Produksi)
- **Infrastruktur Deployment & Cloud**: Render.com
- **Penyimpanan Media Eksternal**: Cloudinary
- **Kerangka Autentikasi**: Laravel Breeze
- **Pengontrol Regulasi Hak Akses**: Spatie Laravel Permission
- **Manajemen Modul Dompet Transaksional**: Laravel Wallet
- **Utilitas Ekstraksi Dokumen (_Export_)**: Laravel Excel

---

## ☁️ Arsitektur Deployment & Integrasi Cloud (Produksi)

Sistem ini dirancang tidak hanya untuk lingkungan lokal, tetapi juga telah dioptimalkan secara penuh untuk beroperasi pada lingkungan awan (_cloud production environment_). Berbagai penyesuaian infrastruktur telah dilakukan:

- **Hosting & Database (Render.com):** Aplikasi dideploy ke layanan _Platform-as-a-Service_ (PaaS) Render, beriringan dengan instansi basis data **PostgreSQL**. Konfigurasi penyebaran dikontrol secara sistematis melalui berkas `render.yaml` (Infrastructure as Code) guna memastikan konsistensi variabel lingkungan seperti `APP_KEY`.
- **Penyimpanan Media Permanen (Cloudinary):** Menyadari keterbatasan sistem penyimpanan efemeral (_ephemeral storage_) pada instansi server kontainer awan, seluruh modul pengunggahan gambar (seperti Avatar Pengguna dan Foto Produk) telah diintegrasikan langsung dengan penyimpanan awan pihak ketiga **Cloudinary**. Hal ini menjamin persistensi aset visual secara permanen.
- **Proteksi Protokol Jaringan (Trust Proxies & HTTPS):** Mengingat server Render beroperasi di balik proksi dan _Load Balancer_, lapisan perlindungan `TrustProxies` Laravel telah diaktifkan untuk meneruskan IP pengguna yang valid. Lebih jauh lagi, fungsionalitas pembuatan tautan (_URL generation_) telah dipaksa secara algoritmik untuk selalu mengembalikan tautan protokol enkripsi `https://`, mengeliminasi potensi galat _Mixed Content_ (pemblokiran CSS/JS oleh peramban klien).
- **Preservasi Ketersediaan (Uptime Monitoring):** Instansi server pada mode gratis (_Free Tier_) diawasi secara berkelanjutan setiap 5 menit memanfaatkan _cron job_ **UptimeRobot**. Strategi injeksi lalu lintas buatan ini terbukti mencegah hibernasi pada layanan server utama, menjamin waktu muat halaman (_loading time_) tetap instan bagi pembeli.

---

## 🧪 Validasi Kelayakan dan Integritas Sistem

Integritas spesifikasi operasional divalidasi secara mendalam menggunakan sekumpulan instrumen uji kelayakan otomatis (_Automated Feature Tests_) berbasis Pest/PHPUnit. Hal ini dilakukan guna memastikan presisi serta stabilitas pada fungsionalitas utama aplikasi sebelum diterapkan pada skala yang lebih besar.

Fokus skenario pengujian komprehensif mencakup namun tidak terbatas pada:

- **Autentikasi & Otorisasi Kredensial**: Verifikasi isolasi hak akses berlapis yang mencegah kebocoran informasi antara instrumen _Admin_, _Seller_, dan _Buyer_.
- **Algoritma Multi-Seller Checkout & Validasi COD**: Penegasan operasional atas implementasi pemisahan pesanan otomatis (_split-order_) untuk keranjang berisikan produk dari penjual yang berbeda, serta keakuratan filtrasi algoritma pada saat pengguna menginisiasi metode pembayaran COD.
- **Konsistensi Transaksi (Database Rollback & Locking)**: Evaluasi terhadap mekanisme pertahanan keamanan operasional, termasuk _Pessimistic Locking_, dalam menangani serta menahan eskalasi antrean permintaan pemesanan masif yang berpotensi menyebabkan ketidakakuratan saldo maupun inventaris stok.

> [!TIP]
> Evaluasi dan simulasi validasi eksekusi sistem secara menyeluruh dapat diluncurkan secara lokal dengan mendayagunakan baris komando berikut di dalam terminal kerja:
>
> ```bash
> php artisan test
> ```

---

## 📧 Modul Penanganan dan Evaluasi Email Transaksional

Pengiriman notifikasi surel (_email_) pada platform ini diformulasikan untuk berjalan **secara asinkronus di latar belakang** (_background queue task_). Tujuannya adalah demi menghindari latensi maupun kelambatan waktu respons pada antarmuka bagi sisi pengguna akhir. Prosedur validasi layanan komunikasi secara lokal membutuhkan adaptasi konfigurasi sebagai berikut:

### 1. Inisiasi Pekerja Antrean (Queue Worker)

Semua bentuk instruksi pengiriman surel secara mendasar dialihkan menuju sistem antrean. Oleh sebab itu, ketersediaan instansi komando khusus sangat diwajibkan untuk tetap beroperasi secara mandiri di sisi terminal:

```bash
php artisan queue:work
```

> [!IMPORTANT]
> Pastikan instansi terminal yang meluncurkan penugasan antrean latar belakang di atas tetap terbuka selama proses uji coba transaksional terus berlangsung (seperti pada simulasi penyerahan maupun pembatalan pesanan yang men-trigger modul notifikasi surel).

### 2. Evaluasi Log Email Lokal (Mekanisme Bawaan)

Konfigurasi lingkungan standar sama sekali tidak mensyaratkan dependensi terhadap infrastruktur layanan jaringan luar (_external service_), melainkan sekadar mencetak muatan pesan ke dalam berkas perekam kejadian (_log file_) lokal.

1. Evaluasi parameter konfigurasi pada berkas `.env` hingga tertera format instruksi: `MAIL_MAILER=log`
2. Lakukan simulasi aktivitas pemicu surel transaksional pada platform aplikasi yang sedang beroperasi.
3. Rincian muatan pesan serta informasi tautan spesifik dapat dievaluasi secara teks secara langsung melalui peninjauan berkas pada jalur: `storage/logs/laravel.log`.

### 3. Simulasi Kotak Masuk Visual Menggunakan Mailtrap

Fasilitas infrastruktur pihak ketiga seperti layanan **[Mailtrap](https://mailtrap.io)** sangat direkomendasikan untuk keperluan evaluasi representasi visual struktur email secara murni (_HTML renderable_).

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
> Setelah modifikasi konfigurasi paramater surel direalisasikan, eksekusi pemuatan ulang atau penghentian sesi sesaat (_restart_) mutlak diperlukan pada layanan pengerjaan latar belakang (`php artisan queue:work`) serta penyedia infrastruktur HTTP utama (`php artisan serve`). Hal ini dilakukan agar keseluruhan pembaruan variabel sistem dapat terinisiasi secara benar.

---

<div align="center">
  Diimplementasikan dan disusun sedemikian rupa untuk menunjang objektif pemahaman infrastruktur layanan teknologi e-commerce termutakhir berbasis kerangka pengembangan PHP Laravel. 
</div>
<!--code-->
