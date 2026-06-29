<x-app-layout>
    @section('title', 'Dashboard Seller')

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 sm:gap-0">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
                <p class="text-sm text-gray-500 mt-1">Selamat datang, {{ $seller->store_name ?? $seller->name }}!</p>
            </div>
            <a href="{{ route('seller.products.create') }}" class="w-full sm:w-auto justify-center inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-primary-600 to-secondary-500 rounded-xl font-bold text-sm text-white tracking-wide hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all shadow-lg shadow-primary-500/25 hover:shadow-xl hover:-translate-y-0.5 duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Pendapatan</p>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['totalRevenue'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Pesanan</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['totalOrders'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Pesanan Pending</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['pendingOrders'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Sales Chart -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Penjualan 7 Hari Terakhir</h3>
                    <canvas id="salesChart" height="120"></canvas>
                </div>

                <!-- Top Products -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Produk Terlaris</h3>
                    @if(count($stats['topProducts']) > 0)
                        <div class="space-y-3">
                            @foreach($stats['topProducts'] as $index => $tp)
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold flex items-center justify-center shrink-0">{{ $index + 1 }}</span>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-800 truncate">{{ $tp['product']['name'] ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500">{{ $tp['total_sold'] }} terjual</p>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900 shrink-0">Rp {{ number_format($tp['total_revenue'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500">Belum ada penjualan.</p>
                    @endif
                </div>
                <!-- Recent Orders -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="font-semibold text-gray-800">Aktivitas Pesanan Terbaru</h3>
                    </div>
                    
                    <!-- Header Baris (Desktop) -->
                    <div class="hidden sm:flex px-6 py-3 border-b border-gray-100 bg-gray-50/30 text-[11px] font-semibold text-gray-500 uppercase tracking-wider">
                        <div class="w-1/3">Pelanggan & Pesanan</div>
                        <div class="w-1/3 text-left">Pendapatan (Toko Anda)</div>
                        <div class="w-1/3 text-right">Status</div>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @forelse($stats['recentOrders'] as $order)
                        <div class="p-6 hover:bg-gray-50 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <!-- Kolom Kiri: Info Pelanggan -->
                            <div class="flex items-center gap-4 sm:w-1/3">
                                <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ optional($order->user)->name ?? 'Guest' }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $order->created_at->diffForHumans() }} • {{ $order->order_number }}</p>
                                </div>
                            </div>
                            
                            <!-- Kolom Tengah: Pendapatan -->
                            <div class="flex sm:justify-start sm:w-1/3">
                                <p class="text-sm font-bold text-green-600">Rp {{ number_format($order->seller_total, 0, ',', '.') }}</p>
                            </div>

                            <!-- Kolom Kanan: Status Badge -->
                            <div class="flex sm:justify-end sm:w-1/3">
                                @if($order->status === 'pending')
                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                @elseif($order->status === 'paid')
                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Dibayar</span>
                                @elseif($order->status === 'shipped')
                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Dikirim</span>
                                @elseif($order->status === 'completed')
                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">Dibatalkan</span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center text-gray-500 text-sm">Belum ada pesanan terbaru.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($stats['chartData']['labels']),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($stats['chartData']['data']),
                    backgroundColor: 'rgba(79, 70, 229, 0.15)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => 'Rp ' + ctx.raw.toLocaleString('id-ID')
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: val => 'Rp ' + val.toLocaleString('id-ID')
                        },
                        grid: { color: '#f3f4f6' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
