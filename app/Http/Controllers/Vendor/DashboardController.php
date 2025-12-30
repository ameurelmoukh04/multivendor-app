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

    public function index()
    {
        $vendor = Auth::user()->vendor;

        if (!$vendor) {
            return redirect()->route('login')->with('error', 'Vendor profile not found');
        }

        $orderIds = OrderItem::where('vendor_id', $vendor->id)->pluck('order_id')->unique();
        
        $stats = [
            'products' => Product::where('vendor_id', $vendor->id)->count(),
            'active_products' => Product::where('vendor_id', $vendor->id)->where('status', 'active')->count(),
            'total_orders' => $orderIds->count(),
            'pending_orders' => Order::whereIn('id', $orderIds)->where('status', 'pending')->count(),
        ];

        $recentProducts = Product::where('vendor_id', $vendor->id)->latest()->take(5)->get();

        return view('vendor.dashboard', compact('stats', 'recentProducts', 'vendor'));
    }
}
