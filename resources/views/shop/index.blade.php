<x-app-layout>
    @section('title', 'Katalog Produk')

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Katalog Produk') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search & Filter -->
            <div class="mb-6 bg-white rounded-xl shadow-sm p-4">
                <form method="GET" action="{{ route('products.index') }}" class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        </div>
                    </div>
                    <select name="category" class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm bg-white">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium text-sm">
                        Cari
                    </button>
                    @if(request('search') || request('category'))
                        <a href="{{ route('products.index') }}" class="px-4 py-2.5 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm text-center">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow group">
                            <a href="{{ route('products.show', $product) }}" class="block">
                                <div class="aspect-square bg-gray-100 overflow-hidden">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://picsum.photos/seed/product' . $product->id . '/400/400' }}" alt="{{ $product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                            </a>
                            <div class="p-4">
                                <div class="text-xs text-indigo-600 font-medium mb-1">{{ $product->category->name }}</div>
                                <a href="{{ route('products.show', $product) }}" class="block">
                                    <h3 class="font-semibold text-gray-800 text-sm leading-tight hover:text-indigo-600 transition line-clamp-2">{{ $product->name }}</h3>
                                </a>
                                <p class="text-xs text-gray-500 mt-1">{{ $product->seller->store_name ?? $product->seller->name }}</p>
                                <div class="flex items-center justify-between mt-3">
                                    <span class="text-lg font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    <span class="text-xs {{ $product->stock > 0 ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }} px-2 py-1 rounded-full font-medium">
                                        {{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}
                                    </span>
                                </div>

                                @auth
                                    @if(auth()->user()->isBuyer() && $product->stock > 0)
                                        <button onclick="addToCart({{ $product->id }})" class="mt-3 w-full py-2 px-4 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                                            </svg>
                                            Tambah ke Keranjang
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="mt-3 w-full py-2 px-4 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition flex items-center justify-center gap-2">
                                        Masuk untuk membeli
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-xl shadow-sm">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-600">Tidak ada produk ditemukan</h3>
                    <p class="text-gray-500 mt-1 text-sm">Coba ubah kata kunci pencarian atau filter kategori.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-4 right-4 z-50 hidden">
        <div class="px-4 py-3 rounded-lg shadow-lg text-sm font-medium flex items-center gap-2"></div>
    </div>

    @push('scripts')
    <script>
        function addToCart(productId) {
            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ product_id: productId, quantity: 1 })
            })
            .then(res => res.json())
            .then(data => {
                showToast(data.message, data.success);
            })
            .catch(() => {
                showToast('Terjadi kesalahan.', false);
            });
        }

        function showToast(message, success = true) {
            const toast = document.getElementById('toast');
            const inner = toast.querySelector('div');
            inner.textContent = message;
            inner.className = `px-4 py-3 rounded-lg shadow-lg text-sm font-medium flex items-center gap-2 ${success ? 'bg-green-500 text-white' : 'bg-red-500 text-white'}`;
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 3000);
        }
    </script>
    @endpush
</x-app-layout>
