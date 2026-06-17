<?php
$file = 'resources/views/filament/pages/stitch-dashboard.blade.php';
$content = file_get_contents($file);

// 1. Replace Year Text
$content = preg_replace('/Visualisasi pendapatan kotor tahun 2023/', 'Visualisasi pendapatan kotor tahun {{ $currentYear }}', $content);

// 2. Replace the hardcoded bars
$pattern = '/<div class="relative w-full h-full flex items-end justify-between pt-10">.*?<\/div>\s*<\/div>/s';

$dynamicChart = '<div class="relative w-full h-full flex items-end justify-between pt-10">
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
        <div class="w-8 {{ $sales > 0 ? \'bg-primary/50 hover:bg-primary\' : \'bg-primary/10\' }} transition-all rounded-t-sm group relative" style="height: {{ $height }}%">
            @if($sales > 0)
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-amber-500 text-gray-900 text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">{{ $tooltip }}</div>
            @endif
        </div>
    @endforeach
</div>
</div>';

$content = preg_replace($pattern, $dynamicChart, $content);

file_put_contents($file, $content);
echo "Chart replaced!";
