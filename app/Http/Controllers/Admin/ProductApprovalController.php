<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductApprovalController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'pending')
            ->with(['vendor', 'category'])
            ->latest()
            ->get();

        return view('admin.products.pending', compact('products'));
    }

    public function approve($id)
    {
        Product::where('id', $id)->update([
            'status' => 'active'
        ]);

        return redirect()->back()->with('success', 'Product approved successfully');
    }
}
