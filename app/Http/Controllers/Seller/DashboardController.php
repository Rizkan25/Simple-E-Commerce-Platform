<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    /**
     * Display seller dashboard with statistics.
     */
    public function index(): View
    {
        $stats = $this->dashboardService->getSellerStats(auth()->id());
        $seller = auth()->user();

        return view('seller.dashboard', compact('stats', 'seller'));
    }
}
