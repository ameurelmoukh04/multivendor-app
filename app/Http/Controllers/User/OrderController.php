<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:user']);
    }

    public function index()
    {
        $orders = Order::where('client_id', Auth::id())
            ->with('orderItems.product')
            ->latest()
            ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('client_id', Auth::id())
            ->with(['orderItems.product', 'orderItems.vendor'])
            ->findOrFail($id);

        return view('user.orders.show', compact('order'));
    }
}
