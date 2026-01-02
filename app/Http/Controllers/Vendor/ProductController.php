<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth', 'role:vendor']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendor = Auth::user()->vendor;
        $products = Product::where('vendor_id', $vendor->id)->with('category')->latest()->paginate(10);
        return view('vendor.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('vendor.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $vendor = Auth::user()->vendor;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['vendor_id'] = $vendor->id;
        $validated['slug'] = Str::slug($validated['name']) . '-' . time();
        $validated['status'] = 'pending'; // Set status to pending by default

        $product = Product::create($validated);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'display_order' => $index,
                ]);
            }
        }

        return redirect()->route('vendor.products.index')->with('success', 'Product created successfully and is pending approval');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vendor = Auth::user()->vendor;
        $product = Product::where('vendor_id', $vendor->id)->with(['category', 'reviews', 'images'])->findOrFail($id);
        return view('vendor.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vendor = Auth::user()->vendor;
        $product = Product::where('vendor_id', $vendor->id)->with('images')->findOrFail($id);
        $categories = Category::all();
        return view('vendor.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $vendor = Auth::user()->vendor;
        $product = Product::where('vendor_id', $vendor->id)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku,' . $id,
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'existing_images' => 'nullable|array',
            'existing_images.*' => 'exists:product_images,id',
        ]);

        if ($product->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . time();
        }

        // If product is being updated, set status back to pending for re-approval
        if ($product->status !== 'pending') {
            $validated['status'] = 'pending';
        }

        $product->update($validated);

        // Handle existing images deletion
        $existingImageIds = $request->input('existing_images', []);
        
        // Delete images that are not in the existing_images array
        $imagesToDelete = $product->images()->whereNotIn('id', $existingImageIds)->get();
        
        foreach ($imagesToDelete as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        // Reorder remaining existing images
        $remainingImages = $product->images()->whereIn('id', $existingImageIds)->orderBy('id')->get();
        foreach ($remainingImages as $index => $image) {
            $image->update(['display_order' => $index]);
        }
        $currentOrder = $remainingImages->count();

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'display_order' => $currentOrder++,
                ]);
            }
        }

        // Refresh product to get updated image count
        $product->refresh();
        
        // Ensure at least one image exists
        if ($product->images()->count() === 0) {
            return redirect()->back()->withErrors(['images' => 'Product must have at least one image.'])->withInput();
        }

        return redirect()->route('vendor.products.index')->with('success', 'Product updated successfully and is pending approval');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vendor = Auth::user()->vendor;
        $product = Product::where('vendor_id', $vendor->id)->findOrFail($id);
        
        // Delete associated images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
        
        $product->delete();

        return redirect()->route('vendor.products.index')->with('success', 'Product deleted successfully');
    }
}
