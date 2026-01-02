<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth', 'role:admin']);
    }

    public function index(Request $request)
    {
        $query = Product::with(['vendor', 'category', 'images']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'pending');
        }

        $products = $query->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with(['vendor', 'category', 'images', 'reviews'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function approve($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['status' => 'active']);

        return redirect()->route('admin.products.index')->with('success', 'Product approved successfully');
    }

    public function reject($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['status' => 'inactive']);

        return redirect()->route('admin.products.index')->with('success', 'Product rejected successfully');
    }
}
