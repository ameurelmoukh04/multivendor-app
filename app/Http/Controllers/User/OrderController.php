<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
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
            ->with(['orderItems.product', 'orderItems.vendor', 'orderItems.review'])
            ->findOrFail($id);

        return view('user.orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to place an order',
                'redirect' => route('login'),
            ], 401);
        }

        $validated = $request->validate([
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|in:card,paypal,cash_on_delivery',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            $orderItems = [];

            // Validate products and calculate total
            foreach ($validated['items'] as $item) {
                $product = Product::active()->findOrFail($item['product_id']);
                
                if ($product->stock < $item['quantity']) {
                    return response()->json([
                        'success' => false,
                        'message' => "Insufficient stock for {$product->name}",
                    ], 400);
                }

                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                $orderItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ];
            }

            // Create order
            $order = Order::create([
                'client_id' => Auth::id(),
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'shipping_address' => $validated['shipping_address'],
                'total_amount' => $totalAmount,
            ]);

            // Create order items and update stock
            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'vendor_id' => $item['product']->vendor_id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Update product stock
                $item['product']->decrement('stock', $item['quantity']);
            }

            DB::commit();

            // Clear cart from localStorage (handled by frontend)
            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'order_id' => $order->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function confirmReceipt($id)
    {
        $order = Order::where('client_id', Auth::id())
            ->whereIn('status', ['pending', 'paid', 'shipped', 'delivered'])
            ->findOrFail($id);

        $order->update([
            'status' => 'received',
            'received_at' => now(),
        ]);

        return redirect()->route('user.orders.show', $order->id)
            ->with('success', 'Order receipt confirmed! You can now add reviews for your products.');
    }
}
