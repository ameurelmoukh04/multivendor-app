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
        $this->middleware(['auth', 'role:user']);
    }

    public function index(Request $request)
    {
        $query = Product::active()->with(['vendor', 'category']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('user.products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::active()->with(['vendor', 'category', 'reviews.client'])->findOrFail($id);
        return view('user.products.show', compact('product'));
    }
}
