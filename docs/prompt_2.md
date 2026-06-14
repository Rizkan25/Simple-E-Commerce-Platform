Skema detail (sesuai dengan sebelumnya, gunakan foreign key constraints, cascade yang sesuai).

11. Seeders & Factories
    CategorySeeder: 4 kategori.

UserSeeder: buat 2 seller (dengan store_name), 3 buyer.

ProductSeeder: masing-masing seller buat minimal 5 produk dengan gambar dummy (gunakan placeholder images via https://picsum.photos/200/150 di view untuk sementara, atau jika ingin upload file, gunakan seeder dengan file dummy).

CartSeeder & OrderSeeder opsional untuk testing.

12. Frontend Detail dengan Blade + Alpine.js + Tailwind
    Layout utama resources/views/layouts/app.blade.php: menggunakan Tailwind CDN atau via Vite. Sertakan meta viewport, font inter.

Navbar: tautan sesuai role (jika buyer: Products, Cart, My Orders; jika seller: Dashboard, Products, Orders; jika guest: Register, Login).

Notifikasi: gunakan session flash message (with('success', '...')) dan tampilkan di atas layout dengan komponen Blade, serta Alpine untuk auto-hide.

Halaman cart: setiap baris item memiliki input number dengan binding x-model ke quantity lokal, tapi untuk update kirim request via fetch. Gunakan x-data untuk menyimpan itemId, quantity, dan fungsi update. Contoh:

html

<div x-data="{ quantity: {{ $item->quantity }}, loading: false }">
  <input type="number" x-model="quantity" @change="updateQuantity({{ $item->id }}, quantity)" />
</div>
Fungsi updateQuantity menggunakan fetch dengan method PATCH.

Tampilkan loading state, error message.

Untuk menghapus, konfirmasi dengan confirm lalu fetch DELETE.

13. Keamanan & Best Practices
    Semua form memiliki @csrf.

Gunakan php artisan make:policy ProductPolicy dan daftarkan di AuthServiceProvider.

Gunakan $request->validate() atau Form Request.

Jangan pernah percaya input user untuk harga; hitung ulang di server.

Untuk upload gambar, simpan dengan nama unik (timestamp + random).

Middleware role menggunakan handle($request, $next, $role).

Guard default adalah web.

Gunakan env untuk database, mail, app url.

14. Queue & Mail
    Buat job SendOrderConfirmation dengan implements ShouldQueue.

Di job, kirim email ke buyer menggunakan Mailable OrderConfirmed.

Konfigurasi .env untuk mailtrap. Jalankan php artisan queue:work untuk development (dokumentasikan di README).

15. Testing (Feature Test) – minimal 3 test case
    RegistrationTest: cek role seller dan buyer.

ProductManagementTest: seller bisa create product, buyer tidak bisa akses route create.

CheckoutTest: checkout dengan stok cukup vs kurang, pastikan transaction rollback.

16. Instruksi Setup & Dokumentasi
    Dalam file README.md setelah kode selesai, tuliskan langkah:

bash
composer install
npm install
cp .env.example .env
php artisan key:generate

# set database di .env

php artisan migrate --seed
php artisan storage:link
npm run build
php artisan queue:work (untuk development, jalankan di terminal terpisah)
php artisan serve
Jelaskan fitur utama dan akun demo (seller: seller1@example.com / password, buyer: buyer1@example.com / password).

🎯 Tujuan Akhir
Hasilkan kode lengkap dalam satu respons (bisa dibagi per bagian jika terlalu panjang, tetapi usahakan terstruktur). Saya akan menjalankan aplikasi ini di environment lokal dan harus bekerja tanpa error.
