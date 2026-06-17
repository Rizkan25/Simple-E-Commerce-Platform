# PROMPT: Refactoring Arsitektur Super Admin E-Commerce (Enterprise Standard)

## 🎯 Konteks & Objektif

Bertindaklah sebagai **Senior System Architect** dan **Lead Laravel Developer**.
Saat ini, sistem panel admin masih sangat rawan, belum memiliki pemisahan hak akses yang ketat, dan belum memiliki sistem _escrow_ untuk keuangan.

**Tugas Anda:** Buatkan panduan teknis, langkah-langkah implementasi, dan kode (Migrations, Models, & Filament Resources) untuk merombak total modul Super Admin agar memenuhi standar _Enterprise_.

## 🛠️ Tech Stack & Ekosistem

- **Framework Inti:** Laravel (Versi terbaru)
- **Admin Panel:** Filament PHP v3 (TALL Stack)
- **Package Wajib:**
    - `spatie/laravel-permission` (Untuk RBAC)
    - `spatie/laravel-activitylog` (Untuk Audit Trail/Log Aktivitas)
    - `bavix/laravel-wallet` (Untuk Sistem Saldo & Escrow ACID Compliant)

## 📋 Spesifikasi Kebutuhan Sistem (System Requirements)

### 1. Keamanan & Arsitektur Database Dasar

- **Soft Deletes:** Jangan ada _hard delete_. Terapkan trait `SoftDeletes` pada model `User`, `Shop`, `Product`, dan `Order`.
- **RBAC (Role-Based Access Control):** Konfigurasikan Spatie Permission. Buat seeder untuk role: `Super Admin`, `Finance`, `Moderator`, dan `Support`.
- **Audit Trail:** Konfigurasikan Spatie Activitylog pada model-model vital (Product, Order, Wallet/Transaction). Pastikan mencatat `causer_id` (siapa yang mengubah) dan `properties` (data _before-after_).

### 2. Alur Finansial & Escrow (Ledger System)

- Integrasikan Bavix Laravel Wallet pada entitas `User` (untuk saldo Seller) dan entitas khusus/sistem (untuk Escrow & Platform Fee/Komisi).
- **Alur Logika:**
    1. Status order `PAID`: Uang masuk ke _Escrow_.
    2. Status order `COMPLETED` (Diterima Pembeli): Uang di _Escrow_ dipecah -> X% ke _Platform Fee Wallet_, sisanya ke _Seller Wallet_.
- Buatkan skema/tabel untuk _Withdrawal Request_ (Penarikan Dana) dari Seller ke Admin.

### 3. Moderasi & Resolusi (Dispute)

- **Kill Switch:** Tambahkan status moderasi (misal: enum `ACTIVE`, `SUSPENDED`, `BANNED`) pada model `Shop` dan `Product`.
- Terapkan _Global Scope_ di Laravel agar toko/produk yang berstatus `SUSPENDED/BANNED` tidak muncul di _frontend_ pembeli.
- **Dispute Center:** Buatkan skema tabel `Disputes` yang berelasi dengan `Order`, di mana pembeli bisa mengajukan komplain, dan Admin bisa mengambil keputusan (`Force Refund` atau `Release to Seller`).

## 🚀 Output yang Diharapkan dari Anda

Tolong berikan respons secara bertahap (step-by-step) agar kode mudah dipahami. Untuk tahap pertama ini, berikan:

1.  **Command Instalasi Package:** Perintah composer untuk menginstal Filament dan package Spatie/Bavix yang disebutkan di atas.
2.  **Struktur Migrasi (Schema):** Kode migrasi Laravel untuk modifikasi tabel bawaan (menambahkan SoftDeletes, Status Moderasi) dan membuat tabel baru (Withdrawals, Disputes).
3.  **Setup Model:** Tuliskan kode untuk Model `User`, `Shop`, `Product`, dan `Order` yang sudah di- _inject_ dengan trait Spatie Permission, ActivityLog, Bavix Wallet, dan SoftDeletes.

Tuliskan kode dengan rapi, menggunakan _type-hinting_ PHP modern, dan ikuti standar PSR-12 serta _best practices_ Laravel.
