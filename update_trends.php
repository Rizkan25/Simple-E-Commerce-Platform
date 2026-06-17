<?php
$file = 'resources/views/filament/pages/stitch-dashboard.blade.php';
$content = file_get_contents($file);

// 1. Replace Trends
// GMV Trend
$content = preg_replace('/<span class="flex items-center gap-xs text-secondary font-bold text-label-md">\s*\+12\.5%\s*<span class="material-symbols-outlined text-\[14px\]" data-icon="trending_up">trending_up<\/span>\s*<\/span>/m', 
'<span class="flex items-center gap-xs {{ $gmvTrend >= 0 ? \'text-secondary\' : \'text-error\' }} font-bold text-label-md">
    {{ $gmvTrend >= 0 ? \'+\' : \'\' }}{{ $gmvTrend }}%
    <span class="material-symbols-outlined text-[14px]" data-icon="{{ $gmvTrend >= 0 ? \'trending_up\' : \'trending_down\' }}">{{ $gmvTrend >= 0 ? \'trending_up\' : \'trending_down\' }}</span>
</span>', $content);

// Orders Trend
$content = preg_replace('/<span class="flex items-center gap-xs text-secondary font-bold text-label-md">\s*\+8\.2%\s*<span class="material-symbols-outlined text-\[14px\]" data-icon="trending_up">trending_up<\/span>\s*<\/span>/m', 
'<span class="flex items-center gap-xs {{ $ordersTrend >= 0 ? \'text-secondary\' : \'text-error\' }} font-bold text-label-md">
    {{ $ordersTrend >= 0 ? \'+\' : \'\' }}{{ $ordersTrend }}%
    <span class="material-symbols-outlined text-[14px]" data-icon="{{ $ordersTrend >= 0 ? \'trending_up\' : \'trending_down\' }}">{{ $ordersTrend >= 0 ? \'trending_up\' : \'trending_down\' }}</span>
</span>', $content);

// Merchants Trend
$content = preg_replace('/<span class="flex items-center gap-xs text-on-tertiary-fixed-variant font-bold text-label-md">\s*\+3\.1%\s*<span class="material-symbols-outlined text-\[14px\]" data-icon="trending_up">trending_up<\/span>\s*<\/span>/m', 
'<span class="flex items-center gap-xs {{ $merchantsTrend >= 0 ? \'text-secondary\' : \'text-error\' }} font-bold text-label-md">
    {{ $merchantsTrend >= 0 ? \'+\' : \'\' }}{{ $merchantsTrend }}%
    <span class="material-symbols-outlined text-[14px]" data-icon="{{ $merchantsTrend >= 0 ? \'trending_up\' : \'trending_down\' }}">{{ $merchantsTrend >= 0 ? \'trending_up\' : \'trending_down\' }}</span>
</span>', $content);

// Customers Trend
$content = preg_replace('/<span class="flex items-center gap-xs text-error font-bold text-label-md">\s*-1\.4%\s*<span class="material-symbols-outlined text-\[14px\]" data-icon="trending_down">trending_down<\/span>\s*<\/span>/m', 
'<span class="flex items-center gap-xs {{ $customersTrend >= 0 ? \'text-secondary\' : \'text-error\' }} font-bold text-label-md">
    {{ $customersTrend >= 0 ? \'+\' : \'\' }}{{ $customersTrend }}%
    <span class="material-symbols-outlined text-[14px]" data-icon="{{ $customersTrend >= 0 ? \'trending_up\' : \'trending_down\' }}">{{ $customersTrend >= 0 ? \'trending_up\' : \'trending_down\' }}</span>
</span>', $content);

// 2. Replace Last Month Texts
$content = preg_replace('/Vs bulan lalu: Rp 1,28M/', 'Vs bulan lalu: Rp {{ number_format($lastMonthGmv / 1000000, 2, ",", ".") }}M', $content);
$content = preg_replace('/Vs bulan lalu: 3\.955/', 'Vs bulan lalu: {{ number_format($lastMonthOrders, 0, ",", ".") }}', $content);
$content = preg_replace('/Vs bulan lalu: 151/', 'Vs bulan lalu: {{ number_format($lastMonthMerchants, 0, ",", ".") }}', $content);
$content = preg_replace('/Vs bulan lalu: 854/', 'Vs bulan lalu: {{ number_format($lastMonthCustomers, 0, ",", ".") }}', $content);

file_put_contents($file, $content);
echo "Trends updated!";
