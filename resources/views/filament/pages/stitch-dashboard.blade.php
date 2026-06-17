<div>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .chart-gradient-purple {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0) 100%);
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .grid > div.bg-gray-950 {
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        }
        .grid > div.bg-gray-950:hover {
            transform: translateY(-2px);
            box-shadow: 0px 4px 6px -1px rgba(0, 0, 0, 0.2);
            border-color: rgba(255, 255, 255, 0.3) !important;
        }
    </style>

<div>
<div class="p-6 space-y-4">
<!-- Search Bar -->
<div class="relative w-full lg:w-1/2 mb-6">
    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
        <span class="material-symbols-outlined text-gray-400 text-[20px]" data-icon="search">search</span>
    </div>
    <input wire:model.live.debounce.500ms="searchQuery" type="text" class="w-full pl-12 pr-4 py-3 bg-gray-950 border border-white/10 rounded-lg text-sm text-gray-100 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors placeholder:text-gray-400/50" placeholder="Cari pesanan, toko, atau pelanggan...">
</div>
<!-- Page Title -->
<div class="flex justify-between items-end mb-2">
<div>
<h2 class="text-2xl font-semibold tracking-tight text-amber-500">Ringkasan Dashboard</h2>
<p class="text-sm text-gray-400">Selamat datang kembali, berikut performa hari ini.</p>
</div>
<div class="flex gap-2">
<button class="flex items-center gap-1 px-4 py-2 border border-white/10 rounded-lg text-sm font-medium hover:bg-gray-900 transition-colors">
<span class="material-symbols-outlined text-sm" data-icon="download">download</span>
                        Ekspor Data
                    </button>
<button class="bg-amber-500 text-gray-900 px-4 py-2 rounded-lg text-sm font-medium hover:opacity-90 active:scale-95 transition-all">
                        Segarkan Data
                    </button>
</div>
</div>
<!-- Top Section: KPI Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
<!-- KPI 1 -->
<div class="bg-gray-950 border border-white/10 p-4 rounded-xl">
<div class="flex justify-between items-start mb-2">
<div class="p-2 bg-amber-500 rounded-lg">
<span class="material-symbols-outlined text-amber-500" data-icon="payments">payments</span>
</div>
<span class="flex items-center gap-1 {{ $gmvTrend >= 0 ? 'text-emerald-400' : 'text-red-400' }} font-bold text-xs font-semibold">
    {{ $gmvTrend >= 0 ? '+' : '' }}{{ $gmvTrend }}%
    <span class="material-symbols-outlined text-[14px]" data-icon="{{ $gmvTrend >= 0 ? 'trending_up' : 'trending_down' }}">{{ $gmvTrend >= 0 ? 'trending_up' : 'trending_down' }}</span>
</span>
</div>
<p class="text-xs font-semibold text-gray-400">Total GMV</p>
<p class="text-2xl font-semibold tracking-tight mt-1">Rp {{ number_format($totalGmv / 1000000, 2, ",", ".") }}M</p>
<p class="text-[10px] text-gray-400 mt-2">Vs bulan lalu: Rp {{ number_format($lastMonthGmv / 1000000, 2, ",", ".") }}M</p>
</div>
<!-- KPI 2 -->
<div class="bg-gray-950 border border-white/10 p-4 rounded-xl">
<div class="flex justify-between items-start mb-2">
<div class="p-2 bg-emerald-900/50 rounded-lg text-emerald-300">
<span class="material-symbols-outlined" data-icon="shopping_bag">shopping_bag</span>
</div>
<span class="flex items-center gap-1 {{ $ordersTrend >= 0 ? 'text-emerald-400' : 'text-red-400' }} font-bold text-xs font-semibold">
    {{ $ordersTrend >= 0 ? '+' : '' }}{{ $ordersTrend }}%
    <span class="material-symbols-outlined text-[14px]" data-icon="{{ $ordersTrend >= 0 ? 'trending_up' : 'trending_down' }}">{{ $ordersTrend >= 0 ? 'trending_up' : 'trending_down' }}</span>
</span>
</div>
<p class="text-xs font-semibold text-gray-400">Total Pesanan</p>
<p class="text-2xl font-semibold tracking-tight mt-1">{{ number_format($totalOrders, 0, ",", ".") }}</p>
<p class="text-[10px] text-gray-400 mt-2">Vs bulan lalu: {{ number_format($lastMonthOrders, 0, ",", ".") }}</p>
</div>
<!-- KPI 3 -->
<div class="bg-gray-950 border border-white/10 p-4 rounded-xl">
<div class="flex justify-between items-start mb-2">
<div class="p-2 bg-orange-200 rounded-lg text-orange-900">
<span class="material-symbols-outlined" data-icon="store">store</span>
</div>
<span class="flex items-center gap-1 {{ $merchantsTrend >= 0 ? 'text-emerald-400' : 'text-red-400' }} font-bold text-xs font-semibold">
    {{ $merchantsTrend >= 0 ? '+' : '' }}{{ $merchantsTrend }}%
    <span class="material-symbols-outlined text-[14px]" data-icon="{{ $merchantsTrend >= 0 ? 'trending_up' : 'trending_down' }}">{{ $merchantsTrend >= 0 ? 'trending_up' : 'trending_down' }}</span>
</span>
</div>
<p class="text-xs font-semibold text-gray-400">Merchant Aktif</p>
<p class="text-2xl font-semibold tracking-tight mt-1">{{ $activeMerchants }}</p>
<p class="text-[10px] text-gray-400 mt-2">Vs bulan lalu: {{ number_format($lastMonthMerchants, 0, ",", ".") }}</p>
</div>
<!-- KPI 4 -->
<div class="bg-gray-950 border border-white/10 p-4 rounded-xl">
<div class="flex justify-between items-start mb-2">
<div class="p-2 bg-red-900/50 rounded-lg text-red-300">
<span class="material-symbols-outlined" data-icon="person_add">person_add</span>
</div>
<span class="flex items-center gap-1 {{ $customersTrend >= 0 ? 'text-emerald-400' : 'text-red-400' }} font-bold text-xs font-semibold">
    {{ $customersTrend >= 0 ? '+' : '' }}{{ $customersTrend }}%
    <span class="material-symbols-outlined text-[14px]" data-icon="{{ $customersTrend >= 0 ? 'trending_up' : 'trending_down' }}">{{ $customersTrend >= 0 ? 'trending_up' : 'trending_down' }}</span>
</span>
</div>
<p class="text-xs font-semibold text-gray-400">Pelanggan Baru</p>
<p class="text-2xl font-semibold tracking-tight mt-1">{{ $newCustomers }}</p>
<p class="text-[10px] text-gray-400 mt-2">Vs bulan lalu: {{ number_format($lastMonthCustomers, 0, ",", ".") }}</p>
</div>
</div>
<!-- Middle Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
<!-- Sales Trend Chart -->
<div class="lg:col-span-2 bg-gray-950 border border-white/10 p-6 rounded-xl flex flex-col">
<div class="flex justify-between items-center mb-8">
<div>
                        <h3 class="text-lg font-semibold tracking-tight text-amber-500">Tren Penjualan Bulanan</h3>
                        <p class="text-xs text-gray-400">Visualisasi pendapatan kotor tahun {{ $currentYear }}</p>
                    </div>
                    <div class="flex bg-surface-container rounded-lg p-1">
                        <button wire:click="$set('salesFilter', 'week')" class="px-4 py-1 text-xs font-semibold rounded transition-all {{ $salesFilter === 'week' ? 'bg-[#213c5e] shadow-sm text-white font-bold' : 'hover:bg-surface-container-high' }}">Minggu</button>
                        <button wire:click="$set('salesFilter', 'month')" class="px-4 py-1 text-xs font-semibold rounded transition-all {{ $salesFilter === 'month' ? 'bg-[#213c5e] shadow-sm text-white font-bold' : 'hover:bg-surface-container-high' }}">Bulan</button>
                        <button wire:click="$set('salesFilter', 'year')" class="px-4 py-1 text-xs font-semibold rounded transition-all {{ $salesFilter === 'year' ? 'bg-[#213c5e] shadow-sm text-white font-bold' : 'hover:bg-surface-container-high' }}">Tahun</button>
                    </div>
                </div>
<div class="relative flex-1 min-h-[300px] w-full flex items-end justify-between px-4">
<!-- Chart Mockup with CSS -->
<div class="absolute inset-0 flex items-center justify-center opacity-10 pointer-events-none">
<span class="material-symbols-outlined text-[200px]" data-icon="insights">insights</span>
</div>
<!-- Horizontal grid lines -->
<div class="absolute inset-x-0 top-0 bottom-8 flex flex-col justify-between border-b border-white/10/30">
<div class="border-b border-white/10/10 w-full"></div>
<div class="border-b border-white/10/10 w-full"></div>
<div class="border-b border-white/10/10 w-full"></div>
<div class="border-b border-white/10/10 w-full"></div>
</div>
<!-- Columns/Points placeholder -->
<div class="relative w-full h-full flex items-end justify-between pt-10">
    @foreach($chartLabels as $index => $label)
        @php
            $sales = $monthlySales[$index] ?? 0;
            $height = $maxMonthlySales > 0 ? max(5, round(($sales / $maxMonthlySales) * 100)) : 5;
            if ($sales >= 1000000) {
                $tooltip = number_format($sales / 1000000, 1, ",", ".") . "jt";
            } elseif ($sales >= 1000) {
                $tooltip = number_format($sales / 1000, 1, ",", ".") . "rb";
            } else {
                $tooltip = "Rp " . number_format($sales, 0, ",", ".");
            }
        @endphp
        <div class="w-8 {{ $sales > 0 ? 'bg-primary/50 hover:bg-primary' : 'bg-primary/10' }} transition-all rounded-t-sm group relative" style="height: {{ $height }}%">
            @if($sales > 0)
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-amber-500 text-gray-900 text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">{{ $tooltip }}</div>
            @endif
        </div>
    @endforeach
</div>
</div>
<div class="flex justify-between mt-4 px-4 text-xs font-semibold text-gray-400 font-medium">
    @foreach($chartLabels as $label)
        <span>{{ $label }}</span>
    @endforeach
</div>
</div>
<!-- Order Status Donut -->
<div class="bg-gray-950 border border-white/10 p-6 rounded-xl flex flex-col">
<h3 class="text-lg font-semibold tracking-tight text-amber-500 mb-8">Ringkasan Status Pesanan</h3>
<div class="flex-1 flex items-center justify-center relative py-xl">
<!-- Simulated Donut Chart -->
<div class="w-48 h-48 rounded-full border-[18px] border-surface-container relative flex items-center justify-center">
<div class="absolute inset-0 rounded-full border-[18px] border-t-primary border-r-secondary border-b-tertiary-fixed-dim border-l-error transform rotate-45"></div>
<div class="text-center">
<p class="text-2xl font-semibold tracking-tight">{{ number_format($totalActiveOrders, 0, ",", ".") }}</p>
<p class="text-xs font-semibold text-gray-400">Total Aktif</p>
</div>
</div>
</div>
<div class="space-y-sm mt-4">
<div class="flex items-center justify-between">
<div class="flex items-center gap-2">
<span class="w-3 h-3 rounded-full bg-primary"></span>
<span class="text-xs">Diproses</span>
</div>
<span class="text-xs font-bold">{{ $processingPct }}%</span>
</div>
<div class="flex items-center justify-between">
<div class="flex items-center gap-2">
<span class="w-3 h-3 rounded-full bg-secondary"></span>
<span class="text-xs">Dikirim</span>
</div>
<span class="text-xs font-bold">{{ $shippedPct }}%</span>
</div>
<div class="flex items-center justify-between">
<div class="flex items-center gap-2">
<span class="w-3 h-3 rounded-full bg-orange-200-dim"></span>
<span class="text-xs">Diterima</span>
</div>
<span class="text-xs font-bold">{{ $deliveredPct }}%</span>
</div>
<div class="flex items-center justify-between">
<div class="flex items-center gap-2">
<span class="w-3 h-3 rounded-full bg-error"></span>
<span class="text-xs">Dibatalkan</span>
</div>
<span class="text-xs font-bold">{{ $cancelledPct }}%</span>
</div>
</div>
</div>
</div>
<!-- Bottom Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
<!-- Top Performing Shops Table -->
<div class="bg-gray-950 border border-white/10 rounded-xl overflow-hidden">
<div class="p-6 border-b border-white/10 flex justify-between items-center">
<h3 class="text-lg font-semibold tracking-tight text-amber-500">Toko Performa Terbaik</h3>
<button class="text-amber-500 text-xs font-semibold font-bold hover:underline">Lihat Semua</button>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-gray-900">
<th class="px-6 py-4 text-xs font-semibold text-gray-400">Nama Toko</th>
<th class="px-6 py-4 text-xs font-semibold text-gray-400">Kategori</th>
<th class="px-6 py-4 text-xs font-semibold text-gray-400 text-right">Total Sales</th>
<th class="px-6 py-4 text-xs font-semibold text-gray-400 text-center">Rating</th>
</tr>
</thead>

<tbody class="divide-y divide-outline-variant">
    @forelse($topShops as $shop)
    <tr class="hover:bg-gray-900/50 transition-colors">
        <td class="px-6 py-4">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-primary rounded flex items-center justify-center text-white text-[10px] font-bold">{{ substr($shop->name, 0, 1) }}</div>
                <span class="text-sm font-medium">{{ $shop->name }}</span>
            </div>
        </td>
        <td class="px-6 py-4 text-sm">{{ $shop->category ?? "Umum" }}</td>
        <td class="px-6 py-4 text-sm text-right font-bold text-emerald-400">Rp {{ number_format($shop->total_sales, 0, ",", ".") }}</td>
        <td class="px-6 py-4 text-center">
            <div class="flex items-center justify-center gap-1">
                <span class="material-symbols-outlined text-[16px] text-orange-900-variant" style="font-variation-settings: 'FILL' 1;">star</span>
                <span class="text-sm font-bold">N/A</span>
            </div>
        </td>
    </tr>
    @empty
    <tr><td colspan="4" class="text-center py-4 text-gray-400">Belum ada toko yang perform.</td></tr>
    @endforelse
</tbody>

</table>
</div>
</div>
<!-- Recent Order Activity -->
<div class="bg-gray-950 border border-white/10 rounded-xl overflow-hidden flex flex-col">
<div class="p-6 border-b border-white/10 flex justify-between items-center">
<h3 class="text-lg font-semibold tracking-tight text-amber-500">Aktivitas Pesanan Terbaru</h3>
<div class="flex gap-1">
<button class="p-1 hover:bg-surface-container rounded transition-colors"><span class="material-symbols-outlined text-sm" data-icon="filter_list">filter_list</span></button>
<button class="p-1 hover:bg-surface-container rounded transition-colors"><span class="material-symbols-outlined text-sm" data-icon="more_vert">more_vert</span></button>
</div>
</div>
<div class="flex-1 overflow-y-auto custom-scrollbar">

<div class="divide-y divide-outline-variant">
    @forelse($recentOrders as $order)
    <div class="p-6 hover:bg-gray-900/50 transition-colors flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-amber-500">
                <span class="material-symbols-outlined" data-icon="shopping_cart">shopping_cart</span>
            </div>
            <div>
                <p class="text-sm font-bold">{{ optional($order->user)->name ?? "Guest" }}</p>
                <p class="text-[11px] text-gray-400">{{ $order->created_at->diffForHumans() }} • {{ $order->order_number }}</p>
            </div>
        </div>
        <div class="text-right">
            <p class="text-sm font-bold">Rp {{ number_format($order->total_amount, 0, ",", ".") }}</p>
            @php
                $statusColor = match($order->status) {
                    "pending" => "bg-primary-900/50 text-white",
                    "paid" => "bg-emerald-900/50 text-emerald-300",
                    "completed" => "bg-gray-800 text-gray-400",
                    "cancelled" => "bg-red-900/50 text-red-300",
                    default => "bg-primary-900/50 text-white"
                };
            @endphp
            <span class="inline-block px-2 py-0.5 rounded-full {{ $statusColor }} text-[10px] font-bold uppercase tracking-wider">{{ $order->status }}</span>
        </div>
    </div>
    @empty
    <div class="p-6 text-center text-gray-400">Belum ada pesanan terbaru.</div>
    @endforelse
</div>
</div>
</div>
</div>
<!-- Footer -->

<footer class="mt-8 py-6 px-6 border-t border-white/10 flex justify-between items-center bg-gray-950">
<p class="text-xs font-semibold text-gray-400">&copy; {{ $currentYear }} Marketplace OS. Hak Cipta Dilindungi.</p>
<div class="flex gap-6">
<a class="text-xs font-semibold text-gray-400 hover:text-amber-500 transition-colors" href="#">Kebijakan Privasi</a>
<a class="text-xs font-semibold text-gray-400 hover:text-amber-500 transition-colors" href="#">Syarat &amp; Ketentuan</a>
<a class="text-xs font-semibold text-gray-400 hover:text-amber-500 transition-colors" href="#">Bantuan</a>
</div>
</footer>
</div>

</div>