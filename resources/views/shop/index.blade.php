<x-app-layout>
    @section('title', 'Katalog Produk')

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-heading font-bold text-2xl text-gray-900 leading-tight">
                {{ __('Katalog Produk') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search & Filter -->
            <div class="relative z-40 mb-10 bg-white/80 backdrop-blur-md rounded-2xl shadow-sm border border-gray-100 p-5 transition-all hover:shadow-md">
                <form method="GET" action="{{ route('products.index') }}" class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1" x-data="{
                        query: '{{ request('search') }}',
                        suggestions: [],
                        showSuggestions: false,
                        fetchSuggestions() {
                            if (this.query.length < 2) {
                                this.suggestions = [];
                                this.showSuggestions = false;
                                return;
                            }
                            fetch(`/api/products/search?query=${encodeURIComponent(this.query)}`)
                                .then(res => res.json())
                                .then(data => {
                                    this.suggestions = data;
                                    this.showSuggestions = data.length > 0;
                                });
                        }
                    }" @click.away="showSuggestions = false">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" x-model="query" @input.debounce.300ms="fetchSuggestions" @focus="if(suggestions.length > 0) showSuggestions = true" placeholder="Cari produk impianmu..." autocomplete="off"
                                class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm bg-gray-50/50 transition-colors hover:bg-white">
                            
                            <!-- Search Suggestions Dropdown -->
                            <div x-show="showSuggestions" x-transition.opacity style="display: none;"
                                 class="absolute z-50 w-full mt-2 bg-white/90 backdrop-blur-md rounded-xl shadow-xl border border-gray-100 overflow-y-auto max-h-[60vh]">
                                <ul>
                                    <template x-for="product in suggestions" :key="product.id">
                                        <li>
                                            <a :href="`/products/${product.slug}`" class="block px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0">
                                                <div class="flex justify-between items-center">
                                                    <span class="text-sm font-medium text-gray-900" x-text="product.name"></span>
                                                    <span class="text-sm text-primary-600 font-semibold" x-text="new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(product.price)"></span>
                                                </div>
                                            </a>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="sm:w-64">
                        <select name="category" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm bg-gray-50/50 hover:bg-white cursor-pointer transition-colors">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-primary-600 to-secondary-500 text-white rounded-xl hover:opacity-90 transition-opacity font-semibold text-sm shadow-md shadow-primary-500/20">
                            Cari
                        </button>
                        @if(request('search') || request('category'))
                            <a href="{{ route('products.index') }}" class="px-6 py-3 border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-50 transition-colors text-sm text-center font-medium flex items-center justify-center bg-white">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @foreach($products as $product)
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group flex flex-col">
                            <a href="{{ route('products.show', $product) }}" class="block relative overflow-hidden aspect-square">
                                <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors z-10"></div>
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://picsum.photos/seed/product' . $product->id . '/400/400' }}" alt="{{ $product->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @if($product->stock <= 0)
                                    <div class="absolute inset-0 bg-white/60 backdrop-blur-sm z-20 flex items-center justify-center">
                                        <span class="px-4 py-2 bg-gray-900 text-white font-bold rounded-full text-sm shadow-lg">Habis Terjual</span>
                                    </div>
                                @endif
                            </a>
                            <div class="p-5 flex flex-col flex-grow">
                                <div class="text-xs font-bold text-secondary-600 uppercase tracking-wider mb-2">{{ $product->category->name }}</div>
                                <a href="{{ route('products.show', $product) }}" class="block mb-1">
                                    <h3 class="font-heading font-bold text-gray-900 text-base leading-snug hover:text-primary-600 transition-colors line-clamp-2">{{ $product->name }}</h3>
                                </a>
                                <p class="text-sm text-gray-500 mb-4 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    {{ $product->seller->store_name ?? $product->seller->name }}
                                </p>
                                
                                <div class="mt-auto">
                                    <div class="flex items-end justify-between mb-4">
                                        <div class="flex flex-col">
                                            <span class="text-xs text-gray-500 mb-0.5">Harga</span>
                                            <span class="font-heading text-xl font-extrabold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>

                                    @auth
                                        @if(auth()->user()->isBuyer() && $product->stock > 0)
                                            <button onclick="addToCart({{ $product->id }})" class="w-full py-3 px-4 bg-primary-50 text-primary-700 font-semibold rounded-xl hover:bg-primary-600 hover:text-white transition-colors duration-300 flex items-center justify-center gap-2 group/btn">
                                                <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                                                </svg>
                                                Tambah
                                            </button>
                                        @endif
                                    @else
                                        @if($product->stock > 0)
                                            <a href="{{ route('login') }}" class="w-full py-3 px-4 bg-gray-50 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-100 transition-colors flex items-center justify-center gap-2 border border-gray-200">
                                                Masuk untuk membeli
                                            </a>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination removed for single page display -->
            @else
                <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-gray-100">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <h3 class="font-heading text-xl font-bold text-gray-900 mb-2">Tidak ada produk ditemukan</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Kami tidak menemukan produk yang cocok dengan pencarian Anda. Coba kata kunci yang berbeda atau hapus filter kategori.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-6 right-6 z-50 hidden transition-all duration-300 transform translate-y-4 opacity-0">
        <div class="px-5 py-4 rounded-xl shadow-xl text-sm font-semibold flex items-center gap-3"></div>
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
                showToast('Terjadi kesalahan koneksi.', false);
            });
        }

        function showToast(message, success = true) {
            const toast = document.getElementById('toast');
            const inner = toast.querySelector('div');
            
            // Icon SVG based on success
            const iconSvg = success 
                ? `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`
                : `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>`;

            inner.innerHTML = `${iconSvg} <span>${message}</span>`;
            
            if(success) {
                inner.className = 'px-5 py-4 rounded-xl shadow-xl text-sm font-semibold flex items-center gap-3 bg-gray-900 text-white border border-gray-800';
            } else {
                inner.className = 'px-5 py-4 rounded-xl shadow-xl text-sm font-semibold flex items-center gap-3 bg-red-50 text-red-700 border border-red-200';
            }

            toast.classList.remove('hidden');
            // Trigger animation
            setTimeout(() => {
                toast.classList.remove('translate-y-4', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
            }, 10);

            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-4', 'opacity-0');
                setTimeout(() => toast.classList.add('hidden'), 300);
            }, 3000);
        }
    </script>
    @endpush
</x-app-layout>
