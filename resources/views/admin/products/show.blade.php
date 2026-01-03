@extends('layouts.app')

@section('title', $product->name)

@section('content')
<h1 style="margin-bottom: 2rem;">{{ $product->name }}</h1>

<div class="card">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back to Products</a>
    </div>

    <table class="table">
        <tr>
            <th style="width: 200px;">Product Name</th>
            <td>{{ $product->name }}</td>
        </tr>
        <tr>
            <th>Vendor</th>
            <td>{{ $product->vendor->store_name }}</td>
        </tr>
        <tr>
            <th>Category</th>
            <td>{{ $product->category->name }}</td>
        </tr>
        <tr>
            <th>Price</th>
            <td>${{ number_format($product->price, 2) }}</td>
        </tr>
        <tr>
            <th>Stock</th>
            <td>{{ $product->stock }}</td>
        </tr>
        <tr>
            <th>SKU</th>
            <td>{{ $product->sku }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                @php
                    $badgeClass = match($product->status) {
                        'active' => 'success',
                        'pending' => 'warning',
                        'inactive' => 'danger',
                        default => 'secondary'
                    };
                @endphp
                <span class="badge badge-{{ $badgeClass }}">
                    {{ ucfirst($product->status) }}
                </span>
            </td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{{ $product->description ?? 'No description' }}</td>
        </tr>
    </table>

    @if($product->images->count() > 0)
        <div style="margin-top: 2rem;">
            <h3>Product Images</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; margin-top: 1rem;">
                @foreach($product->images as $image)
                    <div style="border: 1px solid #ddd; padding: 0.5rem; border-radius: 4px;">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image" style="width: 100%; height: 200px; object-fit: cover; border-radius: 4px;">
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($product->status === 'pending')
        <div style="margin-top: 2rem; padding: 1.5rem; background-color: #f8f9fa; border-radius: 4px;">
            <h3 style="margin-bottom: 1rem;">Product Actions</h3>
            <div style="display: flex; gap: 1rem;">
                <form action="{{ route('admin.products.approve', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Approve Product</button>
                </form>
                <form action="{{ route('admin.products.reject', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Reject Product</button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection


