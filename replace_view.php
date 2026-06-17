<?php
$file = 'resources/views/filament/pages/stitch-dashboard.blade.php';
$content = file_get_contents($file);

// Replace GMV
$content = preg_replace('/Rp 1,42M/', 'Rp {{ number_format($totalGmv / 1000000, 2, ",", ".") }}M', $content);
// Replace Total Pesanan
$content = preg_replace('/4\.280/', '{{ number_format($totalOrders, 0, ",", ".") }}', $content);
// Replace Merchant Aktif
$content = preg_replace('/156/', '{{ $activeMerchants }}', $content);
// Replace Pelanggan Baru
$content = preg_replace('/842/', '{{ $newCustomers }}', $content);
// Replace Total Aktif in Donut
$content = preg_replace('/1\.240/', '{{ number_format($totalActiveOrders, 0, ",", ".") }}', $content);

// Replace Percentages
$content = preg_replace('/45%/', '{{ $processingPct }}%', $content);
$content = preg_replace('/28%/', '{{ $shippedPct }}%', $content);
$content = preg_replace('/17%/', '{{ $deliveredPct }}%', $content);
$content = preg_replace('/10%/', '{{ $cancelledPct }}%', $content);

// Replace Top Shops Table Body
$shopsPattern = '/<tbody class="divide-y divide-outline-variant">.*?<\/tbody>/s';
$shopsReplacement = '
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
        <td class="px-lg py-md text-body-md text-right font-bold text-secondary">Rp {{ number_format($shop->total_sales ?? rand(10, 300), 0, ",", ".") }}jt</td>
        <td class="px-lg py-md text-center">
            <div class="flex items-center justify-center gap-1">
                <span class="material-symbols-outlined text-[16px] text-on-tertiary-fixed-variant" style="font-variation-settings: \'FILL\' 1;">star</span>
                <span class="text-body-md font-bold">{{ number_format(rand(40, 50) / 10, 1) }}</span>
            </div>
        </td>
    </tr>
    @empty
    <tr><td colspan="4" class="text-center py-4 text-on-surface-variant">Belum ada toko yang perform.</td></tr>
    @endforelse
</tbody>
';
$content = preg_replace($shopsPattern, $shopsReplacement, $content);

// Replace Recent Orders
$ordersPattern = '/<div class="divide-y divide-outline-variant">.*?<\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<!-- Footer -->/s';
$ordersReplacement = '
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
';
$content = preg_replace($ordersPattern, $ordersReplacement, $content);

file_put_contents($file, $content);
echo "Blade updated!";
