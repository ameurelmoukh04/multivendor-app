<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $vendor = auth()->user();

        if (!$vendor) {
            abort(403);
        }

        $days = request('period', 7);
        $fromDate = now()->subDays($days);

        $stats = [
            'products' => DB::table('products')
                ->where('vendor_id', $vendor->id)
                ->where('created_at', '>=', $fromDate)
                ->count(),

            'active_products' => DB::table('products')
                ->where('vendor_id', $vendor->id)
                ->where('status', 'active')
                ->where('created_at', '>=', $fromDate)
                ->count(),

            'total_orders' => DB::table('orders')
                ->where('created_at', '>=', $fromDate)
                ->count(),

            'pending_orders' => DB::table('orders')
                ->where('status', 'pending')
                ->where('created_at', '>=', $fromDate)
                ->count(),
        ];

        $recentProducts = DB::table('products')
            ->where('vendor_id', $vendor->id)
            ->latest()
            ->limit(5)
            ->get();

        $totalRevenue = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('products.vendor_id', $vendor->id)
            ->where('orders.status', 'completed')
            ->where('orders.created_at', '>=', $fromDate)
            ->selectRaw('SUM(order_items.price * order_items.quantity) as total')
            ->value('total');

        return view('vendor.dashboard', compact(
            'stats',
            'recentProducts',
            'totalRevenue'
        ));
    }
}
