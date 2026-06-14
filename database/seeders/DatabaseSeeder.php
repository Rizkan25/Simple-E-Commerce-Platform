<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed categories
        $this->call(CategorySeeder::class);

        // Create 2 sellers
        $seller1 = User::firstOrCreate(
            ['email' => 'seller1@example.com'],
            [
                'name' => 'Anda Toko',
                'email' => 'seller1@example.com',
                'password' => Hash::make('password'),
                'role' => 'seller',
                'store_name' => 'TeknoMart',
                'store_description' => 'Toko elektronik dan gadget terlengkap dengan harga terjangkau.',
            ]
        );

        $seller2 = User::firstOrCreate(
            ['email' => 'seller2@example.com'],
            [
                'name' => 'Kamu Fashion',
                'email' => 'seller2@example.com',
                'password' => Hash::make('password'),
                'role' => 'seller',
                'store_name' => 'Siti Style House',
                'store_description' => 'Fashion trendy dan berkualitas untuk semua kalangan.',
            ]
        );

        // Create 3 buyers
        User::firstOrCreate(
            ['email' => 'buyer1@example.com'],
            [
                'name' => 'Naruto',
                'email' => 'buyer1@example.com',
                'password' => Hash::make('password'),
                'role' => 'buyer',
                'shipping_address' => 'Jl. Merdeka No. 45, Jakarta Pusat 10110',
            ]
        );

        User::firstOrCreate(
            ['email' => 'buyer2@example.com'],
            [
                'name' => 'Sasuke',
                'email' => 'buyer2@example.com',
                'password' => Hash::make('password'),
                'role' => 'buyer',
                'shipping_address' => 'Jl. Sudirman No. 78, Bandung 40112',
            ]
        );

        User::firstOrCreate(
            ['email' => 'buyer3@example.com'],
            [
                'name' => 'Rudi Hermawan',
                'email' => 'buyer3@example.com',
                'password' => Hash::make('password'),
                'role' => 'buyer',
                'shipping_address' => 'Jl. Diponegoro No. 12, Surabaya 60241',
            ]
        );

        // Get categories
        $categories = Category::all();

        // Seller 1 Products (TeknoMart - Elektronik & Buku focus)
        $seller1Products = [
            ['name' => 'Laptop Gaming Pro X1', 'category' => 'Elektronik', 'price' => 15500000, 'stock' => 10, 'description' => 'Laptop gaming dengan prosesor terbaru, RAM 16GB, SSD 512GB, dan GPU dedicated untuk performa gaming maksimal.'],
            ['name' => 'Smartphone Ultra S24', 'category' => 'Elektronik', 'price' => 8750000, 'stock' => 25, 'description' => 'Smartphone flagship dengan kamera 108MP, layar AMOLED 6.7 inci, dan baterai 5000mAh untuk penggunaan seharian.'],
            ['name' => 'Wireless Earbuds ANC Pro', 'category' => 'Elektronik', 'price' => 450000, 'stock' => 50, 'description' => 'Earbuds nirkabel dengan Active Noise Cancelling, bass yang dalam, dan daya tahan baterai hingga 8 jam.'],
            ['name' => 'Smartwatch Fit Band', 'category' => 'Elektronik', 'price' => 650000, 'stock' => 35, 'description' => 'Smartwatch dengan monitor detak jantung, GPS terintegrasi, dan fitur pelacakan olahraga lengkap.'],
            ['name' => 'Mechanical Keyboard RGB', 'category' => 'Elektronik', 'price' => 375000, 'stock' => 40, 'description' => 'Keyboard mekanikal dengan switch Cherry MX Blue, lampu RGB per-key, dan build quality premium.'],
            ['name' => 'Buku Laravel Mastery', 'category' => 'Buku', 'price' => 120000, 'stock' => 15, 'description' => 'Panduan lengkap menguasai framework Laravel dari dasar hingga mahir. Cocok untuk pemula dan intermediate developer.'],
            ['name' => 'Buku JavaScript Modern', 'category' => 'Buku', 'price' => 95000, 'stock' => 20, 'description' => 'Belajar JavaScript ES6+ dengan pendekatan praktis dan project-based. Termasuk Node.js dan React dasar.'],
        ];

        // Seller 2 Products (Siti Style House - Pakaian & Makanan focus)
        $seller2Products = [
            ['name' => 'Kaos Polos Premium Cotton', 'category' => 'Pakaian', 'price' => 89000, 'stock' => 100, 'description' => 'Kaos polos bahan cotton combed 30s yang lembut dan nyaman. Tersedia dalam 12 pilihan warna.'],
            ['name' => 'Jaket Hoodie Classic Fleece', 'category' => 'Pakaian', 'price' => 275000, 'stock' => 30, 'description' => 'Hoodie tebal dengan bahan fleece premium, sangat hangat untuk musim hujan. Unisex, cocok untuk pria dan wanita.'],
            ['name' => 'Celana Chino Slim Fit', 'category' => 'Pakaian', 'price' => 185000, 'stock' => 40, 'description' => 'Celana chino slim fit dengan bahan stretch yang nyaman. Cocok untuk gaya casual hingga semi-formal.'],
            ['name' => 'Kemeja Batik Modern', 'category' => 'Pakaian', 'price' => 225000, 'stock' => 25, 'description' => 'Kemeja batik dengan motif modern dan kontemporer. Bahan katun premium yang adem dan menyerap keringat.'],
            ['name' => 'Dress Casual Wanita', 'category' => 'Pakaian', 'price' => 195000, 'stock' => 20, 'description' => 'Dress casual dengan desain minimalis dan elegan. Cocok untuk acara santai hingga semi-formal.'],
            ['name' => 'Kopi Arabica Gayo Premium', 'category' => 'Makanan', 'price' => 95000, 'stock' => 60, 'description' => 'Biji kopi arabica Gayo pilihan, roasting medium yang menghasilkan citarasa fruity dan chocolate notes.'],
            ['name' => 'Cokelat Artisan Gift Box', 'category' => 'Makanan', 'price' => 165000, 'stock' => 35, 'description' => 'Cokelat artisan handmade dalam box eksklusif berisi 12 pieces. Cocok untuk hadiah spesial.'],
            ['name' => 'Madu Hutan Kalimantan', 'category' => 'Makanan', 'price' => 110000, 'stock' => 45, 'description' => 'Madu hutan murni dari lebah liar Kalimantan. 100% alami tanpa campuran, kaya enzim dan nutrisi.'],
        ];

        // Seed Seller 1 Products
        foreach ($seller1Products as $productData) {
            $category = $categories->firstWhere('name', $productData['category']);
            if ($category) {
                Product::firstOrCreate(
                    ['name' => $productData['name']],
                    [
                        'seller_id' => $seller1->id,
                        'category_id' => $category->id,
                        'name' => $productData['name'],
                        'description' => $productData['description'],
                        'price' => $productData['price'],
                        'stock' => $productData['stock'],
                    ]
                );
            }
        }

        // Seed Seller 2 Products
        foreach ($seller2Products as $productData) {
            $category = $categories->firstWhere('name', $productData['category']);
            if ($category) {
                Product::firstOrCreate(
                    ['name' => $productData['name']],
                    [
                        'seller_id' => $seller2->id,
                        'category_id' => $category->id,
                        'name' => $productData['name'],
                        'description' => $productData['description'],
                        'price' => $productData['price'],
                        'stock' => $productData['stock'],
                    ]
                );
            }
        }
    }
}
