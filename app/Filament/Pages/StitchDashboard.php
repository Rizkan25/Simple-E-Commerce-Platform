<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use BackedEnum;
use App\Models\Order;
use App\Models\User;
use App\Models\Withdrawal;
use Filament\Notifications\Notification;

class StitchDashboard extends BaseDashboard
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home';
    protected string $view = 'filament.pages.stitch-dashboard';
    protected static ?string $title = 'Admin Console';
    public string $salesFilter = 'month';
    public string $searchQuery = '';

    public function getWidgets(): array
    {
        return [];
    }

    protected function getViewData(): array
    {
        $now = now();
        $lastMonth = now()->subMonth();

        // This Month Metrics
        $totalGmv = Order::whereNotIn('status', ['cancelled'])
            ->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->sum('total_amount');
        $totalOrders = Order::whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->count();
        $activeMerchants = User::where('role', 'seller')
            ->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->count();
        $newCustomers = User::where('role', 'buyer')
            ->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->count();
        $totalPlatformFee = \App\Models\OrderItem::whereHas('order', function ($query) use ($now) {
            $query->whereNotIn('status', ['cancelled'])
                ->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year);
        })->sum('platform_fee');

        // Last Month Metrics
        $lastMonthGmv = Order::whereNotIn('status', ['cancelled'])
            ->whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year)->sum('total_amount');
        $lastMonthOrders = Order::whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year)->count();
        $lastMonthMerchants = User::where('role', 'seller')
            ->whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year)->count();
        $lastMonthCustomers = User::where('role', 'buyer')
            ->whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year)->count();
        $lastMonthPlatformFee = \App\Models\OrderItem::whereHas('order', function ($query) use ($lastMonth) {
            $query->whereNotIn('status', ['cancelled'])
                ->whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year);
        })->sum('platform_fee');

        // Trend Calculation
        $gmvTrend = $lastMonthGmv > 0 ? round((($totalGmv - $lastMonthGmv) / $lastMonthGmv) * 100, 1) : ($totalGmv > 0 ? 100 : 0);
        $ordersTrend = $lastMonthOrders > 0 ? round((($totalOrders - $lastMonthOrders) / $lastMonthOrders) * 100, 1) : ($totalOrders > 0 ? 100 : 0);
        $merchantsTrend = $lastMonthMerchants > 0 ? round((($activeMerchants - $lastMonthMerchants) / $lastMonthMerchants) * 100, 1) : ($activeMerchants > 0 ? 100 : 0);
        $customersTrend = $lastMonthCustomers > 0 ? round((($newCustomers - $lastMonthCustomers) / $lastMonthCustomers) * 100, 1) : ($newCustomers > 0 ? 100 : 0);
        $platformFeeTrend = $lastMonthPlatformFee > 0 ? round((($totalPlatformFee - $lastMonthPlatformFee) / $lastMonthPlatformFee) * 100, 1) : ($totalPlatformFee > 0 ? 100 : 0);

        // Donut Chart - All Time (or keep as is)
        $ordersByStatus = Order::selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status')->toArray();
        $processingCount = $ordersByStatus['pending'] ?? 0;
        $shippedCount = $ordersByStatus['paid'] ?? 0;
        $deliveredCount = $ordersByStatus['completed'] ?? 0;
        $cancelledCount = $ordersByStatus['cancelled'] ?? 0;

        $totalOrdersCount = array_sum([$processingCount, $shippedCount, $deliveredCount, $cancelledCount]) ?: 1;
        $totalActiveOrders = array_sum([$processingCount, $shippedCount, $deliveredCount]);

        $processingPct = round(($processingCount / $totalOrdersCount) * 100);
        $shippedPct = round(($shippedCount / $totalOrdersCount) * 100);
        $deliveredPct = round(($deliveredCount / $totalOrdersCount) * 100);
        $cancelledPct = round(($cancelledCount / $totalOrdersCount) * 100);

        $topShopsQuery = User::where('role', 'seller');
        
        if (!empty($this->searchQuery)) {
            $topShopsQuery->where(function($q) {
                $q->where('store_name', 'like', '%' . $this->searchQuery . '%')
                  ->orWhere('name', 'like', '%' . $this->searchQuery . '%');
            });
        }

        $topShops = $topShopsQuery
            ->get()
            ->map(function ($shop) {
                $totalSales = \App\Models\OrderItem::where('seller_id', $shop->id)
                    ->whereHas('order', function ($query) {
                        $query->whereNotIn('status', ['cancelled', 'pending']);
                    })
                    ->get()
                    ->sum(function ($item) {
                        return $item->price_at_order * $item->quantity;
                    });
                
                $shop->total_sales = $totalSales;
                return $shop;
            })
            ->sortByDesc('total_sales')
            ->take(4);
            
        $recentWithdrawalsQuery = Withdrawal::with('user')->latest();
        
        if (!empty($this->searchQuery)) {
            $recentWithdrawalsQuery->whereHas('user', function ($uq) {
                $uq->where('store_name', 'like', '%' . $this->searchQuery . '%')
                   ->orWhere('name', 'like', '%' . $this->searchQuery . '%');
            });
        }
            
        $recentWithdrawals = $recentWithdrawalsQuery->take(4)->get();

        $currentYear = now()->year;
        $monthlySales = [];
        $maxMonthlySales = 0;
        $chartLabels = [];
        
        if ($this->salesFilter === 'week') {
            $chartLabels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
            for ($i = 0; $i < 7; $i++) {
                $date = now()->startOfWeek()->addDays($i);
                $sum = (float) Order::whereNotIn('status', ['cancelled'])
                    ->whereDate('created_at', $date)
                    ->sum('total_amount');
                $monthlySales[] = $sum;
                if ($sum > $maxMonthlySales) $maxMonthlySales = $sum;
            }
        } elseif ($this->salesFilter === 'year') {
            for ($i = 4; $i >= 0; $i--) {
                $year = $currentYear - $i;
                $chartLabels[] = (string) $year;
                $sum = (float) Order::whereNotIn('status', ['cancelled'])
                    ->whereYear('created_at', $year)
                    ->sum('total_amount');
                $monthlySales[] = $sum;
                if ($sum > $maxMonthlySales) $maxMonthlySales = $sum;
            }
        } else {
            $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            for ($month = 1; $month <= 12; $month++) {
                $sum = (float) Order::whereNotIn('status', ['cancelled'])
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $month)
                    ->sum('total_amount');
                $monthlySales[] = $sum;
                if ($sum > $maxMonthlySales) $maxMonthlySales = $sum;
            }
        }

        return [
            'totalGmv' => $totalGmv,
            'totalOrders' => $totalOrders,
            'activeMerchants' => $activeMerchants,
            'newCustomers' => $newCustomers,
            'lastMonthGmv' => $lastMonthGmv,
            'lastMonthOrders' => $lastMonthOrders,
            'lastMonthMerchants' => $lastMonthMerchants,
            'lastMonthCustomers' => $lastMonthCustomers,
            'totalPlatformFee' => $totalPlatformFee,
            'lastMonthPlatformFee' => $lastMonthPlatformFee,
            'gmvTrend' => $gmvTrend,
            'ordersTrend' => $ordersTrend,
            'merchantsTrend' => $merchantsTrend,
            'customersTrend' => $customersTrend,
            'platformFeeTrend' => $platformFeeTrend,
            'totalActiveOrders' => $totalActiveOrders,
            'processingPct' => $processingPct,
            'shippedPct' => $shippedPct,
            'deliveredPct' => $deliveredPct,
            'cancelledPct' => $cancelledPct,
            'topShops' => $topShops,
            'recentWithdrawals' => $recentWithdrawals,
            'currentYear' => $currentYear,
            'monthlySales' => $monthlySales,
            'maxMonthlySales' => $maxMonthlySales,
            'chartLabels' => $chartLabels,
        ];
    }

    public function exportData($format = 'xls')
    {
        // Ambil data untuk laporan
        $totalGmv = \App\Models\Order::whereNotIn('status', ['cancelled'])->sum('total_amount');
        $totalOrders = \App\Models\Order::whereNotIn('status', ['cancelled'])->count();
        $activeMerchants = \App\Models\User::where('role', 'seller')->count();
        $newCustomers = \App\Models\User::where('role', 'buyer')->whereMonth('created_at', now()->month)->count();
        $recentOrders = \App\Models\Order::with('user')->latest()->limit(50)->get();

        $data = compact('totalGmv', 'totalOrders', 'activeMerchants', 'newCustomers', 'recentOrders');
        $filename = 'Laporan-Performa-Dasbor-' . date('d-m-Y');

        if ($format === 'csv') {
            return \Maatwebsite\Excel\Facades\Excel::download(
                new \App\Exports\DashboardExport($data), 
                $filename . '.csv',
                \Maatwebsite\Excel\Excel::CSV
            );
        } elseif ($format === 'html') {
            $html = view('exports.dashboard', $data)->render();
            return response()->streamDownload(function() use ($html) {
                echo $html;
            }, $filename . '.html', [
                "Content-type" => "text/html; charset=utf-8"
            ]);
        }

        // Default to XLS (HTML Injection for perfect styling)
        $html = view('exports.dashboard', $data)->render();
        return response()->streamDownload(function() use ($html) {
            echo $html;
        }, $filename . '.xls', [
            "Content-type"        => "application/vnd.ms-excel",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ]);
    }
}
