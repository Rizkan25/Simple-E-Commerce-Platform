<x-app-layout>
    @section('title', 'Keranjang Belanja')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Keranjang Belanja') }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8" x-data="cartManager()">
            @if($cart && $cart->items->count() > 0)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <!-- Cart Items -->
                    <div class="divide-y">
                        @foreach($cart->items as $item)
                            <div class="p-4 sm:p-6 flex gap-4" x-data="{ quantity: {{ $item->quantity }} }" id="cart-item-{{ $item->id }}">
                                <!-- Image -->
                                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-lg bg-gray-100 overflow-hidden shrink-0">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Details -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-medium text-gray-800 text-sm sm:text-base truncate">{{ $item->product->name }}</h3>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $item->product->seller->store_name ?? $item->product->seller->name }}</p>
                                    <p class="text-sm font-semibold text-gray-900 mt-1">Rp {{ number_format($item->price_snapshot, 0, ',', '.') }}</p>

                                    <div class="flex items-center gap-3 mt-3">
                                        <!-- Quantity Controls -->
                                        <div class="flex items-center border rounded-lg">
                                            <button @click="quantity = Math.max(1, quantity - 1); updateQuantity({{ $item->id }}, quantity)"
                                                class="px-2.5 py-1.5 text-gray-600 hover:bg-gray-50 transition text-sm">−</button>
                                            <input type="number" x-model.number="quantity" min="1" max="{{ $item->product->stock }}"
                                                @change="updateQuantity({{ $item->id }}, quantity)"
                                                class="w-12 text-center border-0 focus:ring-0 text-sm py-1.5">
                                            <button @click="quantity = Math.min({{ $item->product->stock }}, quantity + 1); updateQuantity({{ $item->id }}, quantity)"
                                                class="px-2.5 py-1.5 text-gray-600 hover:bg-gray-50 transition text-sm">+</button>
                                        </div>

                                        <!-- Remove -->
                                        <button @click="removeItem({{ $item->id }})"
                                            class="text-red-500 hover:text-red-700 transition text-sm flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Hapus
                                        </button>
                                    </div>
                                </div>

                                <!-- Subtotal -->
                                <div class="text-right shrink-0">
                                    <p class="font-semibold text-gray-900 text-sm sm:text-base" id="subtotal-{{ $item->id }}">
                                        Rp <span x-text="(quantity * {{ $item->price_snapshot }}).toLocaleString('id-ID')">{{ number_format($item->price_snapshot * $item->quantity, 0, ',', '.') }}</span>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Cart Footer -->
                    <div class="border-t bg-gray-50 p-4 sm:p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-lg font-medium text-gray-700">Total</span>
                            <span class="text-2xl font-bold text-gray-900" id="cart-total">
                                Rp {{ number_format($cart->items->sum(fn($i) => $i->price_snapshot * $i->quantity), 0, ',', '.') }}
                            </span>
                        </div>
                        <a href="{{ route('checkout.index') }}"
                           class="block w-full py-3 px-6 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition text-center">
                            Checkout
                        </a>
                    </div>
                </div>

                <!-- Error message area -->
                <div x-show="errorMessage" x-transition class="mt-4 p-4 bg-red-50 text-red-700 rounded-lg text-sm" x-text="errorMessage"></div>
            @else
                <div class="text-center py-16 bg-white rounded-xl shadow-sm">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-600">Keranjang Kosong</h3>
                    <p class="text-gray-500 mt-1 text-sm">Mulai belanja dan tambahkan produk ke keranjang.</p>
                    <a href="{{ route('products.index') }}" class="inline-block mt-4 px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Belanja Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
    function cartManager() {
        return {
            errorMessage: '',

            updateQuantity(itemId, quantity) {
                this.errorMessage = '';
                fetch(`/cart/items/${itemId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ quantity })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('cart-total').textContent = 'Rp ' + Number(data.total).toLocaleString('id-ID');
                    } else {
                        this.errorMessage = data.message;
                    }
                })
                .catch(() => this.errorMessage = 'Terjadi kesalahan.');
            },

            removeItem(itemId) {
                this.errorMessage = '';
                fetch(`/cart/items/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        const el = document.getElementById(`cart-item-${itemId}`);
                        if (el) el.remove();
                        if (data.itemCount === 0) {
                            location.reload();
                        } else {
                            document.getElementById('cart-total').textContent = 'Rp ' + Number(data.total).toLocaleString('id-ID');
                        }
                    } else {
                        this.errorMessage = data.message;
                    }
                })
                .catch(() => this.errorMessage = 'Terjadi kesalahan.');
            }
        };
    }
    </script>
    @endpush
</x-app-layout>
