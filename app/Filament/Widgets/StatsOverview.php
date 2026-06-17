<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Order;
use App\Models\Shop;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalSales = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        return [
            Stat::make('Total Pengguna', User::count())
                ->description('Jumlah seluruh pengguna terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
                
            Stat::make('Total Penjualan', 'Rp ' . number_format($totalSales, 0, ',', '.'))
                ->description('Dari seluruh pesanan sukses')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
                
            Stat::make('Toko Aktif', Shop::withoutGlobalScopes()->where('status', 'ACTIVE')->count())
                ->description('Seller dengan status aktif')
                ->descriptionIcon('heroicon-m-building-storefront')
                ->color('info'),
        ];
    }
}
