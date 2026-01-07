<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $totalSales = Order::sum('amount');
        $totalOrders = Order::count();
        $activeSubscriptions = Subscription::where('status', 'active')->count();
        $monthlySales = Order::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(amount) as total'))
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();
        return [
            'total_sales' => $totalSales,
            'total_orders' => $totalOrders,
            'active_subscriptions' => $activeSubscriptions,
            'monthly_sales' => $monthlySales,
        ];
    }
}
