<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $days = request('period', 7);
        $fromDate = now()->subDays($days);

        $stats = [
            'users' => DB::table('users')->count(),
            'vendors' => DB::table('vendors')->count(),
            'products' => DB::table('products')
                ->where('created_at', '>=', $fromDate)
                ->count(),
            'orders' => DB::table('orders')
                ->where('created_at', '>=', $fromDate)
                ->count(),
            'pending_orders' => DB::table('orders')
                ->where('status', 'pending')
                ->where('created_at', '>=', $fromDate)
                ->count(),
        ];

        $totalRevenue = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->where('orders.created_at', '>=', $fromDate)
            ->selectRaw('SUM(order_items.price * order_items.quantity) as total')
            ->value('total');

        return view('admin.dashboard', compact('stats', 'totalRevenue'));
    }
}
