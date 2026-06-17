# Prompt: Menambahkan Role Admin pada Simple E-Commerce Platform

Saat ini, sistem autentikasi dan otorisasi sudah berjalan dengan dua peran pengguna (role) yaitu `buyer` dan `seller`. Saya ingin Anda membuatkan kode lengkap untuk menambahkan role khusus `admin` beserta halaman dasbor (dashboard) dasar untuk admin tersebut.

Tolong berikan langkah-langkah implementasi dan kode untuk hal-hal berikut:

**1. Modifikasi Database (Migration):**
Buatkan file _migration_ baru untuk mengubah definisi kolom `role` pada tabel `users`. Kolom saat ini bertipe `enum('buyer', 'seller')`. Tolong ubah menjadi `enum('buyer', 'seller', 'admin')` dengan default tetap `buyer`.

**2. Modifikasi Model User (`app/Models/User.php`):**
Tambahkan satu _method_ helper baru bernama `isAdmin(): bool` yang me-return `true` jika peran pengguna saat ini adalah `admin`. Hal ini untuk menyelaraskan dengan _method_ `isBuyer()` dan `isSeller()` yang sudah ada.

**3. Penambahan Data Seeder (`database/seeders/DatabaseSeeder.php`):**
Berikan kode untuk menambahkan satu akun Admin default di dalam _seeder_ (misalnya: nama 'Super Admin', email 'admin@example.com', dan _password_ yang di-hash).

**4. Modifikasi Routing (`routes/web.php`):**

- Tambahkan grup _route_ baru yang diproteksi menggunakan _middleware_ `['auth', 'role:admin']`.
- Gunakan _prefix_ `/admin` dan _name prefix_ `admin.`.
- Buat satu _route_ GET `/dashboard` di dalam grup tersebut yang mengarah ke `Admin\DashboardController@index`.
- Modifikasi _route_ GET `/dashboard` utama (yang bertindak sebagai _redirector_ saat ini) agar bisa mengecek `if (auth()->user()->isAdmin()) { return redirect()->route('admin.dashboard'); }`.

**5. Pembuatan Controller:**
Buatkan kode untuk `App\Http\Controllers\Admin\DashboardController` dengan satu _method_ `index()` yang akan me-return _view_ dasbor admin.

**6. Pembuatan View (Blade):**
Buatkan struktur dasar untuk file `resources/views/admin/dashboard.blade.php`. Gunakan komponen layout standar yang ada di Breeze/proyek ini (seperti `<x-app-layout>`) dan berikan sedikit pesan sambutan 'Selamat Datang, Admin' beserta contoh struktur _sidebar_ menu admin menggunakan Tailwind CSS.

Pastikan semua kode mengikuti standar konvensi penulisan Laravel terbaru dan aman.
