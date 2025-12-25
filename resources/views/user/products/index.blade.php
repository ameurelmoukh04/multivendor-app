@extends('layouts.app')

@section('title', 'Products')

@section('content')
<h1 style="margin-bottom: 2rem;">Browse Products</h1>

<div class="card" style="margin-bottom: 2rem;">
    <form method="GET" action="{{ route('user.products.index') }}" style="display: flex; gap: 1rem; align-items: end;">
        <div class="form-group" style="flex: 1; margin-bottom: 0;">
            <label for="search">Search</label>
            <input type="text" id="search" name="search" class="form-control" value="{{ request('search') }}" placeholder="Search products...">
        </div>
        <div class="form-group" style="flex: 1; margin-bottom: 0;">
            <label for="category">Category</label>
            <select id="category" name="category" class="form-control">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('user.products.index') }}" class="btn btn-secondary">Clear</a>
        </div>
    </form>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem;">
    @forelse($products as $product)
        <div class="card" style="padding: 1rem; cursor: pointer;" onclick="window.location='{{ route('user.products.show', $product->id) }}'">
            <h3 style="margin-bottom: 0.5rem; font-size: 1.2rem;">{{ $product->name }}</h3>
            <p style="color: #7f8c8d; font-size: 0.9rem; margin-bottom: 0.5rem;">{{ $product->vendor->store_name }}</p>
            <p style="color: #7f8c8d; font-size: 0.85rem; margin-bottom: 1rem;">{{ $product->description ? (strlen($product->description) > 80 ? substr($product->description, 0, 80) . '...' : $product->description) : 'No description' }}</p>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 1.5rem; font-weight: bold; color: #27ae60;">${{ number_format($product->price, 2) }}</span>
                <span class="badge badge-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                    {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                </span>
            </div>
        </div>
    @empty
        <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
            <p style="font-size: 1.2rem; color: #7f8c8d;">No products found.</p>
        </div>
    @endforelse
</div>

<div style="margin-top: 2rem;">
    {{ $products->links() }}
</div>
@endsection

