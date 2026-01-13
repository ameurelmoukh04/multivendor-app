<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth', 'role:vendor']);
    }

    public function index(Request $request)
    {
        $vendor = Auth::user()->vendor;

        if (!$vendor) {
            return redirect()->route('login')->with('error', 'Vendor profile not found');
        }

        // Get date filters from request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Build base queries for products
        $productQuery = Product::where('vendor_id', $vendor->id);
        $activeProductQuery = Product::where('vendor_id', $vendor->id)->where('status', 'active');

        // Apply date filters to products if provided
        if ($startDate) {
            $productQuery->whereDate('created_at', '>=', $startDate);
            $activeProductQuery->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $productQuery->whereDate('created_at', '<=', $endDate);
            $activeProductQuery->whereDate('created_at', '<=', $endDate);
        }

        // Get order IDs for this vendor
        $orderIdsQuery = OrderItem::where('vendor_id', $vendor->id);
        $orderIds = $orderIdsQuery->pluck('order_id')->unique();

        // Build order queries
        $orderQuery = Order::whereIn('id', $orderIds);
        $pendingOrderQuery = Order::whereIn('id', $orderIds)->where('status', 'pending');

        // Apply date filters to orders if provided
        if ($startDate) {
            $orderQuery->whereDate('created_at', '>=', $startDate);
            $pendingOrderQuery->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $orderQuery->whereDate('created_at', '<=', $endDate);
            $pendingOrderQuery->whereDate('created_at', '<=', $endDate);
        }
        
        $stats = [
            'products' => $productQuery->count(),
            'active_products' => $activeProductQuery->count(),
            'total_orders' => $orderQuery->count(),
            'pending_orders' => $pendingOrderQuery->count(),
        ];

        // Apply date filter to recent products
        $recentProductsQuery = Product::where('vendor_id', $vendor->id);
        if ($startDate) {
            $recentProductsQuery->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $recentProductsQuery->whereDate('created_at', '<=', $endDate);
        }
        $recentProducts = $recentProductsQuery->latest()->take(5)->get();

        return view('vendor.dashboard', compact('stats', 'recentProducts', 'vendor', 'startDate', 'endDate'));
    }
}
