<?php

namespace App\Services;

use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    /**
     * Get all seller statistics for the dashboard.
     */
    public function getSellerStats(int $sellerId): array
    {
        $validStatuses = ['paid', 'shipped', 'completed'];

        // Total revenue
        $totalRevenue = OrderItem::where('seller_id', $sellerId)
            ->whereHas('order', function ($q) use ($validStatuses) {
                $q->whereIn('status', $validStatuses);
            })
            ->sum(DB::raw('price_at_order * quantity'));

        // Total unique orders
        $totalOrders = OrderItem::where('seller_id', $sellerId)
            ->whereHas('order', function ($q) use ($validStatuses) {
                $q->whereIn('status', $validStatuses);
            })
            ->distinct('order_id')
            ->count('order_id');

        // Chart data - sales for last 7 days
        $chartData = $this->getChartData($sellerId, $validStatuses);

        // Top 5 products by quantity sold
        $topProducts = $this->getTopProducts($sellerId, $validStatuses);

        // Pending orders count
        $pendingOrders = OrderItem::where('seller_id', $sellerId)
            ->whereHas('order', function ($q) {
                $q->where('status', 'pending');
            })
            ->distinct('order_id')
            ->count('order_id');

        // Recent Orders
        $recentOrders = \App\Models\Order::whereHas('items', function ($q) use ($sellerId) {
            $q->where('seller_id', $sellerId);
        })
        ->with(['user', 'items' => function ($q) use ($sellerId) {
            $q->where('seller_id', $sellerId);
        }])
        ->latest()
        ->take(5)
        ->get()
        ->map(function ($order) {
            $order->seller_total = $order->items->sum(function ($item) {
                return $item->price_at_order * $item->quantity;
            });
            return $order;
        });

        return [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'chartData' => $chartData,
            'topProducts' => $topProducts,
            'recentOrders' => $recentOrders,
        ];
    }

    /**
     * Get sales chart data for last 7 days.
     */
    protected function getChartData(int $sellerId, array $validStatuses): array
    {
        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('d M');

            $dailyRevenue = OrderItem::where('seller_id', $sellerId)
                ->whereHas('order', function ($q) use ($validStatuses, $date) {
                    $q->whereIn('status', $validStatuses)
                        ->whereDate('created_at', $date->toDateString());
                })
                ->sum(DB::raw('price_at_order * quantity'));

            $data[] = (float) $dailyRevenue;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    /**
     * Get top 5 best-selling products.
     */
    protected function getTopProducts(int $sellerId, array $validStatuses): array
    {
        return OrderItem::where('seller_id', $sellerId)
            ->whereHas('order', function ($q) use ($validStatuses) {
                $q->whereIn('status', $validStatuses);
            })
            ->select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(price_at_order * quantity) as total_revenue'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->with('product:id,name,image')
            ->get()
            ->toArray();
    }
}
