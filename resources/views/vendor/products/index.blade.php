@extends('layouts.app')

@section('title', 'My Products')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1>My Products</h1>
    <a href="{{ route('vendor.products.create') }}" class="btn btn-primary">Add New Product</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>SKU</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>
                        <span class="badge badge-{{ $product->status === 'active' ? 'success' : 'danger' }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('vendor.products.show', $product->id) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem;">View</a>
                        <a href="{{ route('vendor.products.edit', $product->id) }}" class="btn btn-primary" style="padding: 0.5rem 1rem;">Edit</a>
                        <form action="{{ route('vendor.products.destroy', $product->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem;">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem;">
                        No products yet. <a href="{{ route('vendor.products.create') }}">Create your first product</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 2rem;">
    {{ $products->links() }}
</div>
@endsection

