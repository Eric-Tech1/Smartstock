<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            
            // 1. ALL-TIME TOTALS (Main Display Values)
            $allTimeRevenue = Sale::sum('total_price');
            $allTimeSalesCount = Sale::count();

            // 2. DAILY COMPARISONS (For Trend Indicators)
            $todayRevenue = Sale::whereDate('created_at', Carbon::today())->sum('total_price');
            $yesterdayRevenue = Sale::whereDate('created_at', Carbon::yesterday())->sum('total_price');

            $todaySalesCount = Sale::whereDate('created_at', Carbon::today())->count();
            $yesterdaySalesCount = Sale::whereDate('created_at', Carbon::yesterday())->count();

            // Calculate Revenue % Change
            if ($yesterdayRevenue <= 0) {
                $revenueChange = $todayRevenue > 0 ? 100 : 0;
            } else {
                $revenueChange = (($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100;
            }

            // Calculate Sales Volume % Change
            if ($yesterdaySalesCount <= 0) {
                $salesChange = $todaySalesCount > 0 ? 100 : 0;
            } else {
                $salesChange = (($todaySalesCount - $yesterdaySalesCount) / $yesterdaySalesCount) * 100;
            }

            // 3. BEST PRODUCT & LOW STOCK
            $bestProduct = Product::withSum('sales', 'quantity')
                ->orderByDesc('sales_sum_quantity')
                ->first();

            $lowStockProducts = Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')
                ->orderBy('stock_quantity')
                ->get();
            
            $lowStock = $lowStockProducts->count();

            // 4. CHART DATA (Last 7 Days)
            $salesData = Sale::selectRaw('DATE(created_at) as date, SUM(total_price) as total')
                ->where('created_at', '>=', now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $topProducts = Product::withSum('sales', 'quantity')
                ->orderByDesc('sales_sum_quantity')
                ->take(5)
                ->get();

            return Inertia::render('Admin/Dashboard', [
                'stats' => [
                    'totalSales' => $allTimeSalesCount,    // All-time system total
                    'totalRevenue' => $allTimeRevenue,    // All-time system total
                    'salesChange' => round($salesChange, 1),
                    'revenueChange' => round($revenueChange, 1),
                    'lowStock' => $lowStock,
                ],
                'bestProduct' => $bestProduct,
                'lowStockProducts' => $lowStockProducts,
                'salesData' => $salesData,
                'topProducts' => $topProducts,
            ]);
        }

        return Inertia::render('Dashboard');
    }
}