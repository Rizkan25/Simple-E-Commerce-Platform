# Prompt: Simple E-Commerce Platform dengan Laravel 13 + Breeze + Alpine.js + Tailwind

Anda adalah fullstack developer senior. Bangun aplikasi **Simple E-Commerce Platform** sesuai spesifikasi di bawah ini dengan **kode siap pakai, bersih, dan mengikuti best practices Laravel**.

## 🧱 Stack Teknologi (wajib)

- **Laravel 13**
- **Laravel Breeze** (untuk autentikasi, dengan Blade stack)
- **Database**: MySQL 8+ atau PostgreSQL 15+
- **Frontend**: Blade templates, **Alpine.js 3.x** (interaktivitas ringan), **Tailwind CSS 3.x**
- **Queue**: Database driver (untuk email konfirmasi)
- **Mail**: Mailtrap (development) atau log
- **Storage**: Local `public` disk untuk gambar produk

## 📌 Ringkasan Aplikasi

Aplikasi e-commerce dengan dua peran: **Buyer** dan **Seller**. Satu tabel `users` dengan kolom `role` (enum: buyer, seller).

- Seller: memiliki toko, bisa CRUD produk, melihat dashboard penjualan.
- Buyer: melihat produk, menambah ke keranjang (database cart), checkout (hanya satu seller per cart), melihat pesanan.
- Setiap order menyimpan snapshot harga (di `order_items.price_at_order`). Stok divalidasi dan dikurangi saat checkout menggunakan **database transaction** dan **pessimistic locking**.
- Logika bisnis di-encapsulate dalam **Service classes** (CartService, OrderService, StockService).

## ✅ Fitur Wajib (lengkap)

### 1. Autentikasi & Role (Laravel Breeze + modifikasi)

- Registrasi: form dengan pilihan role (radio: buyer / seller). Jika seller, tampilkan field `store_name` (required) dan `store_description` (optional).
- Login standar Breeze.
- Setelah login, redirect:
    - Buyer → `/products` (katalog)
    - Seller → `/seller/dashboard`
- Middleware `role:buyer` dan `role:seller`. Buat di `app/Http/Middleware/RoleMiddleware.php` dan daftarkan di kernel.
- Di `App\Models\User`: tambahkan `protected $casts = ['role' => 'string']`; method `isBuyer()`, `isSeller()`.

### 2. Manajemen Kategori (seeder + CRUD sederhana untuk admin? Cukup seeder saja, tapi biar admin bisa manage? Untuk sederhana, cukup seeder dan tidak perlu CRUD kategori di UI, namun buyer bisa filter berdasarkan kategori yang sudah ada. Tapi lebih baik buat seeder dan opsional CRUD di dashboard seller? Tidak. Biarkan admin fiktif. Untuk keperluan demo, buat seeder 4 kategori: Elektronik, Pakaian, Buku, Makanan. Tidak perlu controller kategori.

### 3. Manajemen Produk (hanya untuk seller)

- **Route**: `seller/products` (resource) dengan middleware `role:seller`.
- **Model `Product`**: fillable: seller_id, category_id, name, slug, description, price, stock, image.
- **Slug**: otomatis dari nama menggunakan `Str::slug` unique.
- **Image upload**: simpan di `storage/app/public/products/{filename}`. Gunakan `$request->file('image')->store('products', 'public')`. Tampilkan gambar via `asset('storage/products/...')`.
- **Form request**: `ProductStoreRequest` dan `ProductUpdateRequest` dengan validasi: name required, unique (kecuali diri sendiri), price numeric min 0, stock integer min 0, category_id exists, image mimes:jpg,png maks 2048kb.
- **Views**: index (daftar produk seller dengan tabel), create, edit. Gunakan Tailwind CSS untuk styling form.
- **Policy**: `ProductPolicy` – method `update` dan `delete` hanya jika `user->id === product->seller_id`.

### 4. Katalog Produk untuk Buyer (halaman publik)

- **Route**: `/products` (method index di `ProductController` untuk buyer – sebenarnya bisa satu controller dengan pengecekan role, atau buat `ShopController`).
- Fitur:
    - Daftar semua produk (paginate 12) dengan card: gambar, nama, harga, stok (tampilkan "Tersedia" jika >0).
    - Pencarian berdasarkan nama produk (gunakan `where('name', 'like', '%...%')`).
    - Filter berdasarkan kategori (dropdown, ketika dipilih reload halaman dengan query parameter `category`).
    - Tombol "Add to Cart" jika user login dan role buyer. Jika belum login, arahkan ke halaman login. Jika seller login, tombol tidak muncul atau nonaktif.
- **Penting**: Saat menambah ke keranjang, cek apakah cart sudah memiliki produk dari seller berbeda. Jika iya, tolak dengan pesan error "Keranjang hanya boleh berisi produk dari satu penjual". Implementasi logika ini di `CartService::addItem()`.

### 5. Shopping Cart (database, hanya buyer login)

- **Tabel**: `carts` (one-to-one dengan buyer) dan `cart_items`.
- **Model `Cart`**: belongsTo `User` (buyer), hasMany `CartItem`.
- **Model `CartItem`**: belongsTo `Cart`, belongsTo `Product`; memiliki `price_snapshot` (diisi dengan harga produk saat ditambahkan).
- **Fitur**:
    - Halaman `/cart` menampilkan semua item, dengan input quantity (number), tombol update dan hapus.
    - Gunakan **Alpine.js** untuk interaksi: ketika quantity diubah, kirim request PATCH ke `/cart/items/{id}` via fetch, dan update subtotal/total tanpa reload. Saat hapus, kirim DELETE request.
    - Tampilkan total harga, dan pesan error jika gagal update (misal stok tidak mencukupi atau seller berbeda).
- **Controller** `CartController` (resource atau custom):
    - `add(Request $request)`: menerima product_id, quantity default 1. Panggil `CartService::addItem($userId, $productId, $quantity)`. Return response JSON.
    - `updateQuantity(Request $request, $itemId)`: update quantity.
    - `remove($itemId)`: hapus item.
    - `index()`: tampilkan halaman cart.

### 6. Checkout & Order Placement (dengan transaction & lock)

- **Halaman checkout**: `/checkout` (hanya bisa diakses jika cart tidak kosong).
- Tampilkan ringkasan pesanan (item, harga, total). Form alamat pengiriman (textarea, bisa prepopulate dari `user->shipping_address` jika ada). Pilihan metode pembayaran: `dummy_bank` atau `cod`.
- **Proses**:
    1. Validasi input (alamat required).
    2. Panggil `OrderService::createOrderFromCart($userId, $shippingAddress, $paymentMethod)`.
    3. Di dalam service:
        - Ambil cart beserta items dan relasi product.
        - Hitung total dari `price_snapshot * quantity` (atau ambil harga produk terbaru? Sebaiknya gunakan `price_snapshot` yang sudah disimpan di cart item, karena itu harga saat ditambahkan. Atau alternatif: ambil harga produk live dan validasi stok. Agar konsisten, saya sarankan: gunakan harga produk live saat checkout (dari database) dan validasi bahwa harga tidak berubah drastis? Atau gunakan snapshot. Pada e-commerce sederhana, gunakan harga dari product saat checkout, karena snapshot di cart hanya untuk keperluan tampilan, bukan untuk final. Tapi spesifikasi sebelumnya minta `price_snapshot` di cart_items. Untuk menghindari manipulasi, lebih baik hitung ulang dari harga produk live saat checkout. Saya pilih: validasi stok dan gunakan harga produk live (dari model `Product`). Jadi `price_snapshot` di cart_items hanya untuk tampilan, tidak dipakai final. Final price diambil dari `product->price`. Jadi di `OrderService`, looping item, ambil product dengan lock, hitung subtotal = product->price \* quantity.
        - Validasi stok setiap produk.
        - Gunakan `DB::transaction` dan `Product::whereIn('id', ids)->lockForUpdate()->get()`.
        - Buat order dengan `order_number` unik (timestamp + random).
        - Buat order_items (simpan `price_at_order` dari product->price, dan `seller_id` dari product->seller_id).
        - Kurangi stok produk.
        - Hapus semua cart items dan cart (atau kosongkan).
        - Dispatch job `SendOrderConfirmation` (queue).
    4. Redirect ke halaman `/orders` dengan pesan sukses.
- **Error handling**: Jika stok tidak cukup, rollback dan kembalikan error ke user.

### 7. Order Management

- **Buyer**: `/orders` menampilkan daftar pesanan buyer, dengan status. Klik detail order menampilkan informasi lengkap.
- **Seller**: `/seller/orders` menampilkan daftar `order_items` yang seller_id-nya milik seller yang login (grup berdasarkan order_id). Seller dapat mengubah status order (dari `pending` ke `paid` atau `shipped`) hanya untuk item miliknya? Lebih sederhana: satu order hanya berisi produk dari satu seller (karena kita batasi cart hanya satu seller). Jadi seller bisa mengubah status seluruh order. Tapi karena bisa saja order hanya berisi produk seller tsb, kita update status order di tabel `orders` jika seller yang login adalah pemilik semua item dalam order tersebut. Untuk memudahkan, kita cukup update status order tanpa pengecekan item (asumsikan order hanya berasal dari satu seller). Tapi jika ada kemungkinan order multi-seller? Tidak, karena kita batasi di cart. Jadi aman.
    - Di `SellerOrderController`: method index, updateStatus($orderId, $status). Gunakan policy atau gate: cek apakah order memiliki setidaknya satu item dengan seller_id = user_id. Karena hanya satu seller, cek saja `Order::where('id', $orderId)->whereHas('items', fn($q) => $q->where('seller_id', $userId))->exists()`.
    - Update status order, dan kirim notifikasi email ke buyer (opsional).
- **Status order**: pending, paid, shipped, completed, cancelled. Seller hanya bisa ubah ke paid, shipped, completed. Buyer bisa membatalkan hanya jika status pending.

### 8. Seller Dashboard

- **Route**: `/seller/dashboard`.
- **Konten**:
    - Kartu total pendapatan (sum dari `order_items.price_at_order * quantity` untuk order dengan status 'paid' atau 'shipped' atau 'completed', dan item milik seller).
    - Kartu jumlah order (unique order_id yang memiliki item seller tersebut).
    - Grafik penjualan 7 hari terakhir (gunakan `Chart.js`). Data diambil dari `order_items` yang seller_id = user_id, group by tanggal.
    - Daftar 5 produk terlaris (berdasarkan total quantity terjual dari order_items dengan status order 'paid' atau 'shipped' atau 'completed').
- **Implementasi**: Panggil service `DashboardService` yang mengembalikan data. Tampilkan di Blade dengan Alpine untuk interaksi minimal (misal refresh data via AJAX tidak perlu, cukup load awal).

### 9. Encapsulation Service Classes

Buat folder `app/Services` dengan kelas:

- **`CartService`**:
    - `addItem($userId, $productId, $quantity = 1)`: cek seller consistency, dapatkan atau buat cart, tambah atau update cart_item.
    - `updateQuantity($userId, $cartItemId, $quantity)`
    - `removeItem($userId, $cartItemId)`
    - `getCart($userId)`: return cart dengan relasi items.product.
    - `clearCart($userId)`
- **`StockService`**:
    - `validateStock($cartItems)`: cek stok cukup untuk setiap item (bandingkan dengan product->stock). Return boolean atau throw exception.
    - `deductStock($cartItems)`: kurangi stok produk (dipanggil di dalam transaction). Terima array item dengan product_id dan quantity.
- **`OrderService`**:
    - `createOrderFromCart($userId, $shippingAddress, $paymentMethod)`: return Order.
    - `getOrderDetails($orderId)`
    - `updateOrderStatus($orderId, $status, $sellerId = null)`: dengan otorisasi.
- **`DashboardService`**:
    - `getSellerStats($sellerId)`: return array totalRevenue, totalOrders, chartData, topProducts.

### 10. Database Migration (lengkap)

Buat migration dengan urutan:

```php
// 1. users (tambah role, store_name, store_description, shipping_address)
// 2. categories
// 3. products
// 4. carts
// 5. cart_items
// 6. orders
// 7. order_items
// 8. jobs & failed_jobs (bawaan, jalankan php artisan queue:table)
```
