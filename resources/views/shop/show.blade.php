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
                            <p class="text-sm text-gray-500 mb-4">
                                Dijual oleh <span class="font-medium text-gray-700">{{ $product->seller->store_name ?? $product->seller->name }}</span>
                            </p>

                            <div class="text-3xl font-bold text-gray-900 mb-4">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
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
                                    <p class="text-sm font-bold text-gray-900 mt-1 whitespace-nowrap">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
