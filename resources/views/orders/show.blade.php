<x-app-layout>
    @section('title', 'Detail Pesanan')

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pesanan #{{ $order->order_number }}</h2>
            <a href="{{ route('orders.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 transition">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Order Details -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="font-semibold text-gray-800 mb-4">Item Pesanan</h3>
                        <div class="divide-y">
                            @foreach($order->items as $item)
                                <div class="flex gap-4 py-3 {{ $loop->first ? 'pt-0' : '' }}">
                                    <div class="w-16 h-16 rounded bg-gray-100 overflow-hidden shrink-0">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-800 text-sm">{{ $item->product->name ?? 'Produk dihapus' }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">Penjual: {{ $item->seller->store_name ?? $item->seller->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->quantity }}x Rp {{ number_format($item->price_at_order, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <p class="font-semibold text-gray-900 text-sm">Rp {{ number_format($item->price_at_order * $item->quantity, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t mt-4 pt-4 flex justify-between items-center">
                            <span class="text-lg font-medium text-gray-700">Total</span>
                            <span class="text-xl font-bold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Order Info -->
                <div class="space-y-4">
                    <!-- Status -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="font-semibold text-gray-800 mb-3">Status Pesanan</h3>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'paid' => 'bg-blue-100 text-blue-800',
                                'shipped' => 'bg-purple-100 text-purple-800',
                                'completed' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                            ];
                        @endphp
                        <span class="px-3 py-1.5 rounded-full text-sm font-semibold {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($order->status) }}
                        </span>

                        @if($order->status === 'pending')
                            <form method="POST" action="{{ route('orders.cancel', $order) }}" class="mt-4"
                                  onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full py-2 px-4 bg-red-50 text-red-600 border border-red-200 rounded-lg hover:bg-red-100 transition text-sm font-medium">
                                    Batalkan Pesanan
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="font-semibold text-gray-800 mb-3">Informasi</h3>
                        <div class="space-y-2 text-sm">
                            <div><span class="text-gray-500">Tanggal:</span> <span class="text-gray-800">{{ $order->created_at->format('d M Y H:i') }}</span></div>
                            <div><span class="text-gray-500">Pembayaran:</span> <span class="text-gray-800">{{ $order->payment_method === 'cod' ? 'COD' : 'Transfer Bank' }}</span></div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="font-semibold text-gray-800 mb-3">Alamat Pengiriman</h3>
                        <p class="text-sm text-gray-600">{{ $order->shipping_address }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
