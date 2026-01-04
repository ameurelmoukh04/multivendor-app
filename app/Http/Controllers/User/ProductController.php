<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth', 'role:user']);
    }

    public function index(Request $request)
    {
        // Get all active products for client-side filtering
        $products = Product::active()->with(['vendor', 'category', 'images'])->latest()->get();
        $categories = Category::all();

        return view('user.products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::active()->with(['vendor', 'category', 'reviews.client', 'images'])->findOrFail($id);
        return view('user.products.show', compact('product'));
    }
}
