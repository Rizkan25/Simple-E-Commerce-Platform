<x-app-layout>
    @section('title', 'Pesanan Masuk')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Pesanan Masuk') }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($orders->count() > 0)
                <div class="space-y-4">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <span class="font-semibold text-gray-800">#{{ $order->order_number }}</span>
                                    <span class="text-sm text-gray-500 ml-2">{{ $order->created_at->format('d M Y H:i') }}</span>
                                    <span class="text-sm text-gray-500 ml-2">• Pembeli: {{ $order->user->name }}</span>
                                </div>
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'paid' => 'bg-blue-100 text-blue-800',
                                        'shipped' => 'bg-purple-100 text-purple-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>

                            <!-- Order Items -->
                            <div class="divide-y border rounded-lg mb-4">
                                @foreach($order->items as $item)
                                    <div class="flex items-center gap-3 p-3">
                                        <div class="w-10 h-10 rounded bg-gray-100 overflow-hidden shrink-0">
                                            @if($item->product && $item->product->image_url)
                                                <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-800 truncate">{{ $item->product->name ?? 'Produk dihapus' }}</p>
                                            <p class="text-xs text-gray-500">{{ $item->quantity }}x Rp {{ number_format($item->price_at_order, 0, ',', '.') }}</p>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">Rp {{ number_format($item->price_at_order * $item->quantity, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-500">
                                    Total: <span class="font-bold text-gray-900 text-base">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                </div>

                                <!-- Status Update -->
                                @if(!in_array($order->status, ['completed', 'cancelled']))
                                    <form method="POST" action="{{ route('seller.orders.updateStatus', $order) }}" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                            @if($order->status === 'pending')
                                                <option value="paid">Tandai Dibayar</option>
                                            @endif
                                            @if(in_array($order->status, ['pending', 'paid']))
                                                <option value="shipped">Tandai Dikirim</option>
                                            @endif
                                            @if($order->status === 'shipped')
                                                <option value="completed">Tandai Selesai</option>
                                            @endif
                                        </select>
                                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 transition">
                                            Update
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">{{ $orders->links() }}</div>
            @else
                <div class="text-center py-16 bg-white rounded-xl shadow-sm">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-600">Belum ada pesanan masuk</h3>
                    <p class="text-gray-500 mt-1 text-sm">Pesanan akan muncul di sini ketika buyer membeli produk Anda.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
