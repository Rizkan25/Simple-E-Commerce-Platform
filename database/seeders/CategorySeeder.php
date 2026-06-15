<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Elektronik', 
            'Pakaian', 
            'Buku', 
            'Makanan',
            'Kesehatan & Kecantikan',
            'Rumah & Dapur',
            'Olahraga & Outdoor',
            'Mainan & Hobi',
            'Otomotif',
            'Perawatan Bayi',
            'Hewan Peliharaan',
            'Alat Tulis & Kantor',
            'Komputer & Aksesoris'
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'slug' => Str::slug($name)]
            );
        }
    }
}
