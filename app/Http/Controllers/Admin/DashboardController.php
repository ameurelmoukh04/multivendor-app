<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth', 'role:admin']);
    }

    public function index(Request $request)
    {
        // Get date filters from request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Build base queries
        $userQuery = User::where('role', 'user');
        $vendorQuery = Vendor::query();
        $productQuery = Product::query();
        $orderQuery = Order::query();
        $pendingOrderQuery = Order::where('status', 'pending');

        // Apply date filters if provided
        if ($startDate) {
            $userQuery->whereDate('created_at', '>=', $startDate);
            $vendorQuery->whereDate('created_at', '>=', $startDate);
            $productQuery->whereDate('created_at', '>=', $startDate);
            $orderQuery->whereDate('created_at', '>=', $startDate);
            $pendingOrderQuery->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $userQuery->whereDate('created_at', '<=', $endDate);
            $vendorQuery->whereDate('created_at', '<=', $endDate);
            $productQuery->whereDate('created_at', '<=', $endDate);
            $orderQuery->whereDate('created_at', '<=', $endDate);
            $pendingOrderQuery->whereDate('created_at', '<=', $endDate);
        }

        $stats = [
            'users' => $userQuery->count(),
            'vendors' => $vendorQuery->count(),
            'products' => $productQuery->count(),
            'orders' => $orderQuery->count(),
            'pending_orders' => $pendingOrderQuery->count(),
        ];

        // Apply date filter to recent orders
        $recentOrdersQuery = Order::with('client');
        if ($startDate) {
            $recentOrdersQuery->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $recentOrdersQuery->whereDate('created_at', '<=', $endDate);
        }
        $recentOrders = $recentOrdersQuery->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'startDate', 'endDate'));
    }
}
