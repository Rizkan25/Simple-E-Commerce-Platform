<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use BackedEnum;
use App\Models\Order;
use App\Models\Shop;
use App\Models\User;

class StitchDashboard extends BaseDashboard
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home';
    protected string $view = 'filament.pages.stitch-dashboard';
    protected static ?string $title = 'Admin Console';

    protected function getViewData(): array
    {
        $now = now();
        $lastMonth = now()->subMonth();

        // This Month Metrics
        $totalGmv = Order::whereNotIn('status', ['cancelled'])
            ->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->sum('total_amount');
        $totalOrders = Order::whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->count();
        $activeMerchants = Shop::withoutGlobalScopes()->where('status', 'ACTIVE')
            ->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->count();
        $newCustomers = User::where('role', 'buyer')
            ->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->count();

        // Last Month Metrics
        $lastMonthGmv = Order::whereNotIn('status', ['cancelled'])
            ->whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year)->sum('total_amount');
        $lastMonthOrders = Order::whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year)->count();
        $lastMonthMerchants = Shop::withoutGlobalScopes()->where('status', 'ACTIVE')
            ->whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year)->count();
        $lastMonthCustomers = User::where('role', 'buyer')
            ->whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year)->count();

        // Trend Calculation
        $gmvTrend = $lastMonthGmv > 0 ? round((($totalGmv - $lastMonthGmv) / $lastMonthGmv) * 100, 1) : ($totalGmv > 0 ? 100 : 0);
        $ordersTrend = $lastMonthOrders > 0 ? round((($totalOrders - $lastMonthOrders) / $lastMonthOrders) * 100, 1) : ($totalOrders > 0 ? 100 : 0);
        $merchantsTrend = $lastMonthMerchants > 0 ? round((($activeMerchants - $lastMonthMerchants) / $lastMonthMerchants) * 100, 1) : ($activeMerchants > 0 ? 100 : 0);
        $customersTrend = $lastMonthCustomers > 0 ? round((($newCustomers - $lastMonthCustomers) / $lastMonthCustomers) * 100, 1) : ($newCustomers > 0 ? 100 : 0);

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

        $topShops = Shop::withoutGlobalScopes()
            ->where('status', 'ACTIVE')
            ->get()
            ->map(function ($shop) {
                $totalSales = \App\Models\OrderItem::where('seller_id', $shop->user_id)
                    ->whereHas('order', function ($query) {
                        $query->whereNotIn('status', ['cancelled']);
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
            
        $recentOrders = Order::with('user')->latest()->take(4)->get();

        $currentYear = now()->year;
        $monthlySales = [];
        $maxMonthlySales = 0;
        
        for ($month = 1; $month <= 12; $month++) {
            $sum = (float) Order::whereNotIn('status', ['cancelled'])
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->sum('total_amount');
                
            $monthlySales[$month] = $sum;
            if ($sum > $maxMonthlySales) {
                $maxMonthlySales = $sum;
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
            'gmvTrend' => $gmvTrend,
            'ordersTrend' => $ordersTrend,
            'merchantsTrend' => $merchantsTrend,
            'customersTrend' => $customersTrend,
            'totalActiveOrders' => $totalActiveOrders,
            'processingPct' => $processingPct,
            'shippedPct' => $shippedPct,
            'deliveredPct' => $deliveredPct,
            'cancelledPct' => $cancelledPct,
            'topShops' => $topShops,
            'recentOrders' => $recentOrders,
            'currentYear' => $currentYear,
            'monthlySales' => $monthlySales,
            'maxMonthlySales' => $maxMonthlySales,
        ];
    }
}
