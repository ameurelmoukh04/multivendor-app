<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    public function store(Request $request, $orderItemId)
    {
        $orderItem = OrderItem::with(['order', 'product'])
            ->whereHas('order', function($query) {
                $query->where('client_id', Auth::id())
                      ->where('status', 'received');
            })
            ->findOrFail($orderItemId);

        // Check if review already exists
        if ($orderItem->review) {
            return redirect()->back()->withErrors(['review' => 'You have already reviewed this product.']);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'product_id' => $orderItem->product_id,
            'client_id' => Auth::id(),
            'order_item_id' => $orderItem->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Review added successfully!');
    }
}
