<x-app-layout>
    @section('title', $product->name)

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="text-sm mb-6">
                <ol class="flex items-center gap-2 text-gray-500">
                    <li><a href="{{ route('products.index') }}" class="hover:text-indigo-600 transition">Katalog</a></li>
                    <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg></li>
                    <li><a href="{{ route('products.index', ['category' => $product->category_id]) }}" class="hover:text-indigo-600 transition">{{ $product->category->name }}</a></li>
                    <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg></li>
                    <li class="text-gray-800 font-medium truncate">{{ $product->name }}</li>
                </ol>
            </nav>

            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
                    <!-- Product Image -->
                    <div class="aspect-square bg-gray-100">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                             class="w-full h-full object-cover">
                    </div>

                    <!-- Product Details -->
                    <div class="p-6 md:p-8 flex flex-col">
                        <div class="flex-1">
                            <span class="inline-block text-xs font-medium text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full mb-3">{{ $product->category->name }}</span>
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                            
                            @if($product->reviews_count > 0)
                                <div class="flex items-center gap-1 mb-2">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <span class="text-sm font-medium text-gray-700">{{ number_format($product->average_rating, 1) }}</span>
                                    <span class="text-sm text-gray-500">({{ $product->reviews_count }} Penilaian)</span>
                                </div>
                            @endif

                            <p class="text-sm text-gray-500 mb-4">
                                Dijual oleh <span class="font-medium text-gray-700">{{ $product->seller->store_name ?? $product->seller->name }}</span>
                                @if($product->seller->store_reviews_count > 0)
                                    <span class="text-yellow-500 ml-1">★ {{ number_format($product->seller->store_rating, 1) }}</span>
                                @endif
                            </p>

                            <div class="flex items-end gap-3 mb-4">
                                @if($product->is_discounted)
                                    <div>
                                        <span class="text-sm text-gray-400 line-through block">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span class="text-3xl font-bold text-red-600">Rp {{ number_format($product->effective_price, 0, ',', '.') }}</span>
                                    </div>
                                @else
                                    <div class="text-3xl font-bold text-gray-900">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </div>
                                @endif

                                @if($product->is_cod_enabled)
                                    <span class="mb-1.5 px-2.5 py-1 bg-green-100 text-green-700 text-xs font-bold rounded">Bisa COD</span>
                                @endif
                            </div>

                            <div class="flex items-center gap-2 mb-6">
                                <span class="text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $product->stock > 0 ? "Stok: {$product->stock}" : 'Stok Habis' }}
                                </span>
                            </div>

                            @if($product->description)
                                <div class="border-t pt-4">
                                    <h3 class="font-medium text-gray-800 mb-2">Deskripsi Produk</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
                                </div>
                            @endif
                            
                            <!-- Product Reviews Section -->
                            <div class="border-t mt-6 pt-4">
                                <h3 class="font-medium text-gray-800 mb-4">Ulasan Pembeli</h3>
                                @if($product->reviews->isEmpty())
                                    <p class="text-sm text-gray-500 italic">Belum ada ulasan untuk produk ini.</p>
                                @else
                                    <div class="space-y-4 max-h-80 overflow-y-auto pr-2">
                                        @foreach($product->reviews as $review)
                                            <div class="bg-gray-50 p-4 rounded-lg">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="font-medium text-sm text-gray-900">{{ $review->user->name }}</span>
                                                    <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                                </div>
                                                <div class="flex items-center gap-1 mb-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    @endfor
                                                </div>
                                                @if($review->comment)
                                                    <p class="text-sm text-gray-700">{{ $review->comment }}</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Add to Cart -->
                        <div class="mt-6 pt-4 border-t" x-data="{ quantity: 1, loading: false, message: '', success: false }">
                            @auth
                                @if(auth()->user()->isBuyer() && $product->stock > 0)
                                    <div class="flex items-center gap-3 mb-4">
                                        <label class="text-sm font-medium text-gray-700">Jumlah:</label>
                                        <div class="flex items-center border rounded-lg">
                                            <button @click="quantity = Math.max(1, quantity - 1)" class="px-3 py-2 text-gray-600 hover:bg-gray-50 transition">−</button>
                                            <input type="number" x-model.number="quantity" min="1" max="{{ $product->stock }}"
                                                class="w-16 text-center border-0 focus:ring-0 text-sm">
                                            <button @click="quantity = Math.min({{ $product->stock }}, quantity + 1)" class="px-3 py-2 text-gray-600 hover:bg-gray-50 transition">+</button>
                                        </div>
                                    </div>
                                    <button @click="
                                        loading = true;
                                        fetch('{{ route('cart.add') }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                                'Accept': 'application/json'
                                            },
                                            body: JSON.stringify({ product_id: {{ $product->id }}, quantity: quantity })
                                        })
                                        .then(r => r.json())
                                        .then(d => { message = d.message; success = d.success; loading = false; })
                                        .catch(() => { message = 'Terjadi kesalahan.'; success = false; loading = false; });
                                    " :disabled="loading"
                                    class="w-full py-3 px-6 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition flex items-center justify-center gap-2 disabled:opacity-50">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                                        </svg>
                                        <span x-text="loading ? 'Menambahkan...' : 'Tambah ke Keranjang'"></span>
                                    </button>
                                    <div x-show="message" x-transition class="mt-3 p-3 rounded-lg text-sm" :class="success ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700'" x-text="message"></div>
                                @elseif($product->stock <= 0)
                                    <button disabled class="w-full py-3 px-6 bg-gray-300 text-gray-500 font-medium rounded-lg cursor-not-allowed">Stok Habis</button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="w-full py-3 px-6 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition flex items-center justify-center gap-2">
                                    Masuk untuk membeli
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="mt-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Produk Terkait</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($relatedProducts as $related)
                            <a href="{{ route('products.show', $related) }}" class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow group">
                                <div class="aspect-square bg-gray-100 overflow-hidden">
                                    <img src="{{ $related->image_url }}" alt="{{ $related->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                                <div class="p-3">
                                    <h3 class="text-sm font-medium text-gray-800 truncate">{{ $related->name }}</h3>
                                    @if($related->is_discounted)
                                        <div class="mt-1 flex items-center gap-2">
                                            <p class="text-xs text-gray-400 line-through whitespace-nowrap">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                                            <p class="text-sm font-bold text-red-600 whitespace-nowrap">Rp {{ number_format($related->effective_price, 0, ',', '.') }}</p>
                                        </div>
                                    @else
                                        <p class="text-sm font-bold text-gray-900 mt-1 whitespace-nowrap">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
