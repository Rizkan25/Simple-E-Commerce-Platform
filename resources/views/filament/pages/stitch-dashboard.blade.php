<div>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#f59e0b",
                        "on-primary": "#452000",
                        "primary-container": "#643300",
                        "on-primary-container": "#ffddb8",
                        "secondary": "#4edea3",
                        "on-secondary": "#003823",
                        "secondary-container": "#005236",
                        "on-secondary-container": "#6ffbbe",
                        "tertiary": "#ffb95f",
                        "on-tertiary": "#452b00",
                        "tertiary-container": "#653e00",
                        "on-tertiary-container": "#ffddb8",
                        "error": "#ffb4ab",
                        "on-error": "#690005",
                        "error-container": "#93000a",
                        "on-error-container": "#ffdad6",
                        "background": "transparent",
                        "on-background": "#f4f4f5",
                        "surface": "transparent",
                        "on-surface": "#dce4f0",
                        "surface-variant": "#14253d",
                        "on-surface-variant": "#8ba9cf",
                        "outline": "#2b4d77",
                        "outline-variant": "rgba(255,255,255,0.1)",
                        "surface-container-lowest": "#050a13",
                        "surface-container-low": "#091426",
                        "surface-container": "#091426",
                        "surface-container-high": "#14253d",
                        "surface-container-highest": "#213c5e",
                        "surface-dim": "#091426",
                        "surface-bright": "#213c5e"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "container-margin": "24px",
                        "xs": "4px",
                        "base": "4px",
                        "lg": "24px",
                        "md": "16px",
                        "sm": "8px",
                        "xl": "32px",
                        "gutter": "16px"
                    },
                    "fontFamily": {
                        "headline-sm": ["Inter"],
                        "data-mono": ["Inter"],
                        "body-sm": ["Inter"],
                        "body-md": ["Inter"],
                        "label-md": ["Inter"],
                        "display-sm": ["Inter"]
                    },
                    "fontSize": {
                        "headline-sm": ["18px", {"lineHeight": "28px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "data-mono": ["14px", {"lineHeight": "20px", "letterSpacing": "-0.01em", "fontWeight": "500"}],
                        "body-sm": ["13px", {"lineHeight": "18px", "letterSpacing": "0em", "fontWeight": "400"}],
                        "body-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0em", "fontWeight": "400"}],
                        "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.02em", "fontWeight": "600"}],
                        "display-sm": ["24px", {"lineHeight": "32px", "letterSpacing": "-0.02em", "fontWeight": "600"}]
                    }
                },
            },
        }
    </script>
<style>
        body { font-family: 'Inter', sans-serif; }
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
    </style>

<div>
<div class="p-container-margin space-y-gutter">
<!-- Page Title -->
<div class="flex justify-between items-end mb-sm">
<div>
<h2 class="text-display-sm font-display-sm text-primary">Ringkasan Dashboard</h2>
<p class="text-body-md text-on-surface-variant">Selamat datang kembali, berikut performa hari ini.</p>
</div>
<div class="flex gap-sm">
<button class="flex items-center gap-xs px-md py-2 border border-outline-variant rounded-lg text-body-md font-medium hover:bg-surface-container-low transition-colors">
<span class="material-symbols-outlined text-body-md" data-icon="download">download</span>
                        Ekspor Data
                    </button>
<button class="bg-amber-500 text-gray-900 px-md py-2 rounded-lg text-body-md font-medium hover:opacity-90 active:scale-95 transition-all">
                        Segarkan Data
                    </button>
</div>
</div>
<!-- Top Section: KPI Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
<!-- KPI 1 -->
<div class="bg-surface-container-lowest border border-outline-variant p-md rounded-xl">
<div class="flex justify-between items-start mb-sm">
<div class="p-2 bg-primary-fixed rounded-lg">
<span class="material-symbols-outlined text-primary" data-icon="payments">payments</span>
</div>
<span class="flex items-center gap-xs {{ $gmvTrend >= 0 ? 'text-secondary' : 'text-error' }} font-bold text-label-md">
    {{ $gmvTrend >= 0 ? '+' : '' }}{{ $gmvTrend }}%
    <span class="material-symbols-outlined text-[14px]" data-icon="{{ $gmvTrend >= 0 ? 'trending_up' : 'trending_down' }}">{{ $gmvTrend >= 0 ? 'trending_up' : 'trending_down' }}</span>
</span>
</div>
<p class="text-label-md text-on-surface-variant">Total GMV</p>
<p class="text-display-sm font-display-sm mt-xs">Rp {{ number_format($totalGmv / 1000000, 2, ",", ".") }}M</p>
<p class="text-[10px] text-on-surface-variant mt-sm">Vs bulan lalu: Rp {{ number_format($lastMonthGmv / 1000000, 2, ",", ".") }}M</p>
</div>
<!-- KPI 2 -->
<div class="bg-surface-container-lowest border border-outline-variant p-md rounded-xl">
<div class="flex justify-between items-start mb-sm">
<div class="p-2 bg-secondary-container rounded-lg text-on-secondary-container">
<span class="material-symbols-outlined" data-icon="shopping_bag">shopping_bag</span>
</div>
<span class="flex items-center gap-xs {{ $ordersTrend >= 0 ? 'text-secondary' : 'text-error' }} font-bold text-label-md">
    {{ $ordersTrend >= 0 ? '+' : '' }}{{ $ordersTrend }}%
    <span class="material-symbols-outlined text-[14px]" data-icon="{{ $ordersTrend >= 0 ? 'trending_up' : 'trending_down' }}">{{ $ordersTrend >= 0 ? 'trending_up' : 'trending_down' }}</span>
</span>
</div>
<p class="text-label-md text-on-surface-variant">Total Pesanan</p>
<p class="text-display-sm font-display-sm mt-xs">{{ number_format($totalOrders, 0, ",", ".") }}</p>
<p class="text-[10px] text-on-surface-variant mt-sm">Vs bulan lalu: {{ number_format($lastMonthOrders, 0, ",", ".") }}</p>
</div>
<!-- KPI 3 -->
<div class="bg-surface-container-lowest border border-outline-variant p-md rounded-xl">
<div class="flex justify-between items-start mb-sm">
<div class="p-2 bg-tertiary-fixed rounded-lg text-on-tertiary-fixed">
<span class="material-symbols-outlined" data-icon="store">store</span>
</div>
<span class="flex items-center gap-xs {{ $merchantsTrend >= 0 ? 'text-secondary' : 'text-error' }} font-bold text-label-md">
    {{ $merchantsTrend >= 0 ? '+' : '' }}{{ $merchantsTrend }}%
    <span class="material-symbols-outlined text-[14px]" data-icon="{{ $merchantsTrend >= 0 ? 'trending_up' : 'trending_down' }}">{{ $merchantsTrend >= 0 ? 'trending_up' : 'trending_down' }}</span>
</span>
</div>
<p class="text-label-md text-on-surface-variant">Merchant Aktif</p>
<p class="text-display-sm font-display-sm mt-xs">{{ $activeMerchants }}</p>
<p class="text-[10px] text-on-surface-variant mt-sm">Vs bulan lalu: {{ number_format($lastMonthMerchants, 0, ",", ".") }}</p>
</div>
<!-- KPI 4 -->
<div class="bg-surface-container-lowest border border-outline-variant p-md rounded-xl">
<div class="flex justify-between items-start mb-sm">
<div class="p-2 bg-error-container rounded-lg text-on-error-container">
<span class="material-symbols-outlined" data-icon="person_add">person_add</span>
</div>
<span class="flex items-center gap-xs {{ $customersTrend >= 0 ? 'text-secondary' : 'text-error' }} font-bold text-label-md">
    {{ $customersTrend >= 0 ? '+' : '' }}{{ $customersTrend }}%
    <span class="material-symbols-outlined text-[14px]" data-icon="{{ $customersTrend >= 0 ? 'trending_up' : 'trending_down' }}">{{ $customersTrend >= 0 ? 'trending_up' : 'trending_down' }}</span>
</span>
</div>
<p class="text-label-md text-on-surface-variant">Pelanggan Baru</p>
<p class="text-display-sm font-display-sm mt-xs">{{ $newCustomers }}</p>
<p class="text-[10px] text-on-surface-variant mt-sm">Vs bulan lalu: {{ number_format($lastMonthCustomers, 0, ",", ".") }}</p>
</div>
</div>
<!-- Middle Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
<!-- Sales Trend Chart -->
<div class="lg:col-span-2 bg-surface-container-lowest border border-outline-variant p-lg rounded-xl flex flex-col">
<div class="flex justify-between items-center mb-xl">
<div>
<h3 class="text-headline-sm font-headline-sm text-primary">Tren Penjualan Bulanan</h3>
<p class="text-body-sm text-on-surface-variant">Visualisasi pendapatan kotor tahun {{ $currentYear }}</p>
</div>
<div class="flex bg-surface-container rounded-lg p-1">
<button class="px-md py-1 text-label-md rounded hover:bg-surface-container-high transition-all">Minggu</button>
<button class="px-md py-1 text-label-md bg-[#213c5e] shadow-sm rounded text-white font-bold">Bulan</button>
<button class="px-md py-1 text-label-md rounded hover:bg-surface-container-high transition-all">Tahun</button>
</div>
</div>
<div class="relative flex-1 min-h-[300px] w-full flex items-end justify-between px-md">
<!-- Chart Mockup with CSS -->
<div class="absolute inset-0 flex items-center justify-center opacity-10 pointer-events-none">
<span class="material-symbols-outlined text-[200px]" data-icon="insights">insights</span>
</div>
<!-- Horizontal grid lines -->
<div class="absolute inset-x-0 top-0 bottom-8 flex flex-col justify-between border-b border-outline-variant/30">
<div class="border-b border-outline-variant/10 w-full"></div>
<div class="border-b border-outline-variant/10 w-full"></div>
<div class="border-b border-outline-variant/10 w-full"></div>
<div class="border-b border-outline-variant/10 w-full"></div>
</div>
<!-- Columns/Points placeholder -->
<div class="relative w-full h-full flex items-end justify-between pt-10">
    @foreach(range(1, 12) as $month)
        @php
            $sales = $monthlySales[$month] ?? 0;
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
<div class="w-8 bg-primary/20 hover:bg-primary transition-all rounded-t-sm group relative" style="height: {{ $processingPct }}%"></div>
<div class="w-8 bg-primary/20 hover:bg-primary transition-all rounded-t-sm group relative" style="height: 55%"></div>
<div class="w-8 bg-primary/20 hover:bg-primary transition-all rounded-t-sm group relative" style="height: 80%"></div>
<div class="w-8 bg-primary/20 hover:bg-primary transition-all rounded-t-sm group relative" style="height: 65%"></div>
<div class="w-8 bg-primary/20 hover:bg-primary transition-all rounded-t-sm group relative" style="height: 90%"></div>
<div class="w-8 bg-primary/20 hover:bg-primary transition-all rounded-t-sm group relative" style="height: 70%"></div>
<div class="w-8 bg-primary/20 hover:bg-primary transition-all rounded-t-sm group relative" style="height: 75%"></div>
<div class="w-8 bg-primary/20 hover:bg-primary transition-all rounded-t-sm group relative" style="height: 85%"></div>
<div class="w-8 bg-primary/20 hover:bg-primary transition-all rounded-t-sm group relative" style="height: 100%"></div>
<div class="w-8 bg-primary/20 hover:bg-primary transition-all rounded-t-sm group relative" style="height: 95%"></div>
<div class="w-8 bg-primary hover:bg-primary transition-all rounded-t-sm group relative" style="height: 100%">
<div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-amber-500 text-gray-900 text-[10px] px-2 py-1 rounded opacity-100">145jt</div>
</div>
</div>
</div>
<div class="flex justify-between mt-md px-md text-label-md text-on-surface-variant font-medium">
<span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>Mei</span><span>Jun</span><span>Jul</span><span>Agu</span><span>Sep</span><span>Okt</span><span>Nov</span><span>Des</span>
</div>
</div>
<!-- Order Status Donut -->
<div class="bg-surface-container-lowest border border-outline-variant p-lg rounded-xl flex flex-col">
<h3 class="text-headline-sm font-headline-sm text-primary mb-xl">Ringkasan Status Pesanan</h3>
<div class="flex-1 flex items-center justify-center relative py-xl">
<!-- Simulated Donut Chart -->
<div class="w-48 h-48 rounded-full border-[18px] border-surface-container relative flex items-center justify-center">
<div class="absolute inset-0 rounded-full border-[18px] border-t-primary border-r-secondary border-b-tertiary-fixed-dim border-l-error transform rotate-45"></div>
<div class="text-center">
<p class="text-display-sm font-display-sm">{{ number_format($totalActiveOrders, 0, ",", ".") }}</p>
<p class="text-label-md text-on-surface-variant">Total Aktif</p>
</div>
</div>
</div>
<div class="space-y-sm mt-md">
<div class="flex items-center justify-between">
<div class="flex items-center gap-sm">
<span class="w-3 h-3 rounded-full bg-primary"></span>
<span class="text-body-sm">Diproses</span>
</div>
<span class="text-body-sm font-bold">{{ $processingPct }}%</span>
</div>
<div class="flex items-center justify-between">
<div class="flex items-center gap-sm">
<span class="w-3 h-3 rounded-full bg-secondary"></span>
<span class="text-body-sm">Dikirim</span>
</div>
<span class="text-body-sm font-bold">{{ $shippedPct }}%</span>
</div>
<div class="flex items-center justify-between">
<div class="flex items-center gap-sm">
<span class="w-3 h-3 rounded-full bg-tertiary-fixed-dim"></span>
<span class="text-body-sm">Diterima</span>
</div>
<span class="text-body-sm font-bold">{{ $deliveredPct }}%</span>
</div>
<div class="flex items-center justify-between">
<div class="flex items-center gap-sm">
<span class="w-3 h-3 rounded-full bg-error"></span>
<span class="text-body-sm">Dibatalkan</span>
</div>
<span class="text-body-sm font-bold">{{ $cancelledPct }}%</span>
</div>
</div>
</div>
</div>
<!-- Bottom Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-gutter">
<!-- Top Performing Shops Table -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden">
<div class="p-lg border-b border-outline-variant flex justify-between items-center">
<h3 class="text-headline-sm font-headline-sm text-primary">Toko Performa Terbaik</h3>
<button class="text-primary text-label-md font-bold hover:underline">Lihat Semua</button>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low">
<th class="px-lg py-md text-label-md text-on-surface-variant">Nama Toko</th>
<th class="px-lg py-md text-label-md text-on-surface-variant">Kategori</th>
<th class="px-lg py-md text-label-md text-on-surface-variant text-right">Total Sales</th>
<th class="px-lg py-md text-label-md text-on-surface-variant text-center">Rating</th>
</tr>
</thead>

<tbody class="divide-y divide-outline-variant">
    @forelse($topShops as $shop)
    <tr class="hover:bg-surface-container-low/50 transition-colors">
        <td class="px-lg py-md">
            <div class="flex items-center gap-sm">
                <div class="w-8 h-8 bg-primary rounded flex items-center justify-center text-white text-[10px] font-bold">{{ substr($shop->name, 0, 1) }}</div>
                <span class="text-body-md font-medium">{{ $shop->name }}</span>
            </div>
        </td>
        <td class="px-lg py-md text-body-md">{{ $shop->category ?? "Umum" }}</td>
        <td class="px-lg py-md text-body-md text-right font-bold text-secondary">Rp {{ number_format($shop->total_sales, 0, ",", ".") }}</td>
        <td class="px-lg py-md text-center">
            <div class="flex items-center justify-center gap-1">
                <span class="material-symbols-outlined text-[16px] text-on-tertiary-fixed-variant" style="font-variation-settings: 'FILL' 1;">star</span>
                <span class="text-body-md font-bold">N/A</span>
            </div>
        </td>
    </tr>
    @empty
    <tr><td colspan="4" class="text-center py-4 text-on-surface-variant">Belum ada toko yang perform.</td></tr>
    @endforelse
</tbody>

</table>
</div>
</div>
<!-- Recent Order Activity -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden flex flex-col">
<div class="p-lg border-b border-outline-variant flex justify-between items-center">
<h3 class="text-headline-sm font-headline-sm text-primary">Aktivitas Pesanan Terbaru</h3>
<div class="flex gap-xs">
<button class="p-1 hover:bg-surface-container rounded transition-colors"><span class="material-symbols-outlined text-body-md" data-icon="filter_list">filter_list</span></button>
<button class="p-1 hover:bg-surface-container rounded transition-colors"><span class="material-symbols-outlined text-body-md" data-icon="more_vert">more_vert</span></button>
</div>
</div>
<div class="flex-1 overflow-y-auto custom-scrollbar">

<div class="divide-y divide-outline-variant">
    @forelse($recentOrders as $order)
    <div class="p-lg hover:bg-surface-container-low/50 transition-colors flex items-center justify-between">
        <div class="flex items-center gap-md">
            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                <span class="material-symbols-outlined" data-icon="shopping_cart">shopping_cart</span>
            </div>
            <div>
                <p class="text-body-md font-bold">{{ optional($order->user)->name ?? "Guest" }}</p>
                <p class="text-[11px] text-on-surface-variant">{{ $order->created_at->diffForHumans() }} • {{ $order->order_number }}</p>
            </div>
        </div>
        <div class="text-right">
            <p class="text-body-md font-bold">Rp {{ number_format($order->total_amount, 0, ",", ".") }}</p>
            @php
                $statusColor = match($order->status) {
                    "pending" => "bg-primary-container text-white",
                    "paid" => "bg-secondary-container text-on-secondary-container",
                    "completed" => "bg-surface-container-highest text-on-surface-variant",
                    "cancelled" => "bg-error-container text-on-error-container",
                    default => "bg-primary-container text-white"
                };
            @endphp
            <span class="inline-block px-2 py-0.5 rounded-full {{ $statusColor }} text-[10px] font-bold uppercase tracking-wider">{{ $order->status }}</span>
        </div>
    </div>
    @empty
    <div class="p-lg text-center text-on-surface-variant">Belum ada pesanan terbaru.</div>
    @endforelse
</div>
</div>
</div>
</div>
<!-- Footer -->

<footer class="mt-xl py-lg px-container-margin border-t border-outline-variant flex justify-between items-center bg-surface-container-lowest">
<p class="text-label-md text-on-surface-variant">&copy; {{ $currentYear }} Marketplace OS. Hak Cipta Dilindungi.</p>
<div class="flex gap-lg">
<a class="text-label-md text-on-surface-variant hover:text-primary transition-colors" href="#">Kebijakan Privasi</a>
<a class="text-label-md text-on-surface-variant hover:text-primary transition-colors" href="#">Syarat &amp; Ketentuan</a>
<a class="text-label-md text-on-surface-variant hover:text-primary transition-colors" href="#">Bantuan</a>
</div>
</footer>
</div>

<script>
        // Micro-interactions for KPI cards
        const kpiCards = document.querySelectorAll('.grid > div');
        kpiCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-2px)';
                card.style.boxShadow = '0px 4px 6px -1px rgba(0, 0, 0, 0.05), 0px 2px 4px -2px rgba(0, 0, 0, 0.05)';
                card.style.borderColor = '#94a3b8';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
                card.style.boxShadow = 'none';
                card.style.borderColor = '#e2e8f0';
            });
        });

        // Simulating search focus
        const searchInput = document.querySelector('input[type="text"]');
        searchInput.addEventListener('focus', () => {
            searchInput.parentElement.style.borderColor = '#091426';
        });
        searchInput.addEventListener('blur', () => {
            searchInput.parentElement.style.borderColor = '#c5c6cd';
        });
    </script>
</div>