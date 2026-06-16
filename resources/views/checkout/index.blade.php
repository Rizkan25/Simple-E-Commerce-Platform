<x-app-layout>
    @section('title', 'Checkout')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Checkout') }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('checkout.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Left: Shipping & Payment -->
                    <div class="md:col-span-2 space-y-6">
                        <!-- Shipping Address -->
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Alamat Pengiriman
                            </h3>
                            <textarea name="shipping_address" rows="4" required
                                class="w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm p-3"
                                placeholder="Masukkan alamat pengiriman lengkap...">{{ old('shipping_address', $user->shipping_address) }}</textarea>
                            <x-input-error :messages="$errors->get('shipping_address')" class="mt-2" />
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-white rounded-xl shadow-sm p-6" x-data="{ method: '{{ old('payment_method', 'dummy_bank') }}' }">
                            <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                Metode Pembayaran
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <label class="flex items-center gap-3 p-4 border rounded-lg cursor-pointer transition-all"
                                       :class="method === 'dummy_bank' ? 'border-indigo-500 bg-indigo-50 ring-2 ring-indigo-200' : 'border-gray-300 hover:border-gray-400'">
                                    <input type="radio" name="payment_method" value="dummy_bank" x-model="method" class="text-indigo-600 focus:ring-indigo-500">
                                    <div>
                                        <div class="font-medium text-sm text-gray-700">🏦 Transfer Bank</div>
                                        <div class="text-xs text-gray-500">Virtual Account</div>
                                    </div>
                                </label>
                                <label class="flex items-center gap-3 p-4 border rounded-lg cursor-pointer transition-all"
                                       :class="method === 'cod' ? 'border-indigo-500 bg-indigo-50 ring-2 ring-indigo-200' : 'border-gray-300 hover:border-gray-400'">
                                    <input type="radio" name="payment_method" value="cod" x-model="method" class="text-indigo-600 focus:ring-indigo-500">
                                    <div>
                                        <div class="font-medium text-sm text-gray-700">💵 Cash on Delivery</div>
                                        <div class="text-xs text-gray-500">Bayar saat terima</div>
                                    </div>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Right: Order Summary -->
                    <div>
                        <div class="bg-white rounded-xl shadow-sm p-6 sticky top-6">
                            <h3 class="font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h3>

                            <div class="space-y-3 divide-y max-h-64 overflow-y-auto">
                                @foreach($cart->items as $item)
                                    <div class="flex gap-3 {{ !$loop->first ? 'pt-3' : '' }}">
                                        <div class="w-12 h-12 rounded bg-gray-100 overflow-hidden shrink-0">
                                            <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-800 truncate">{{ $item->product->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $item->quantity }}x Rp {{ number_format($item->price_snapshot, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900 shrink-0">
                                            Rp {{ number_format($item->price_snapshot * $item->quantity, 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t mt-4 pt-4">
                                <div class="flex justify-between text-lg font-bold text-gray-900">
                                    <span>Total</span>
                                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full mt-4 py-3 px-6 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Buat Pesanan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
