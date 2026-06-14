<x-app-layout>
    @section('title', 'Pesanan Saya')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Pesanan Saya') }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($orders->count() > 0)
                <div class="space-y-4">
                    @foreach($orders as $order)
                        <a href="{{ route('orders.show', $order) }}" class="block bg-white rounded-xl shadow-sm p-4 sm:p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <span class="font-semibold text-gray-800">#{{ $order->order_number }}</span>
                                    <span class="text-sm text-gray-500 ml-2">{{ $order->created_at->format('d M Y H:i') }}</span>
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
                            <div class="flex items-center gap-3 text-sm text-gray-500">
                                <span>{{ $order->items->count() }} produk</span>
                                <span>•</span>
                                <span>{{ $order->payment_method === 'cod' ? 'COD' : 'Transfer Bank' }}</span>
                            </div>
                            <div class="mt-2 text-right">
                                <span class="text-lg font-bold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-6">{{ $orders->links() }}</div>
            @else
                <div class="text-center py-16 bg-white rounded-xl shadow-sm">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-600">Belum ada pesanan</h3>
                    <p class="text-gray-500 mt-1 text-sm">Mulai belanja dan buat pesanan pertama Anda.</p>
                    <a href="{{ route('products.index') }}" class="inline-block mt-4 px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Belanja Sekarang</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
