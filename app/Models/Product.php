<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'seller_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'views',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = static::generateUniqueSlug($product->name);
            }
        });

        static::updating(function (Product $product) {
            if ($product->isDirty('name')) {
                $product->slug = static::generateUniqueSlug($product->name, $product->id);
            }
        });
    }

    protected static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        $query = static::where('slug', $slug);
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
            $query = static::where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
        }

        return $slug;
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        $exactMatches = [
            'Laptop Gaming Pro X1' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302',
            'Smartphone Ultra S24' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9',
            'Wireless Earbuds ANC Pro' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df',
            'Smartwatch Fit Band' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30',
            'Mechanical Keyboard RGB' => 'https://images.unsplash.com/photo-1595225476474-87563907a212',
            'Buku Laravel Mastery' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c',
            'Buku JavaScript Modern' => 'https://images.unsplash.com/photo-1532012197267-da84d127e765',
            'Kaos Polos Premium Cotton' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab',
            'Jaket Hoodie Classic Fleece' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7',
            'Celana Chino Slim Fit' => 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a',
            'Kemeja Batik Modern' => 'https://images.unsplash.com/photo-1603252109303-2751441dd157',
            'Dress Casual Wanita' => 'https://images.pexels.com/photos/1055691/pexels-photo-1055691.jpeg?auto=compress&cs=tinysrgb&w=600',
            'Kopi Arabica Gayo Premium' => 'https://images.unsplash.com/photo-1559525839-b184a4d698c7',
            'Cokelat Artisan Gift Box' => 'https://images.unsplash.com/photo-1548907040-4baa42d10919',
            'Madu Hutan Kalimantan' => 'https://images.pexels.com/photos/3334316/pexels-photo-3334316.jpeg?auto=compress&cs=tinysrgb&w=600',
        ];

        if (isset($exactMatches[$this->name])) {
            $url = $exactMatches[$this->name];
            if (str_contains($url, 'unsplash.com')) {
                return $url . '?auto=format&fit=crop&w=600&q=80';
            }
            return $url;
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random&size=400';
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
