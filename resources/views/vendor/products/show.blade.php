@extends('layouts.app')

@section('title', $product->name)

@section('content')
<h1 style="margin-bottom: 2rem;">{{ $product->name }}</h1>

<div class="card">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('vendor.products.edit', $product->id) }}" class="btn btn-primary">Edit Product</a>
        <a href="{{ route('vendor.products.index') }}" class="btn btn-secondary">Back to Products</a>
    </div>

    <table class="table">
        <tr>
            <th style="width: 200px;">Name</th>
            <td>{{ $product->name }}</td>
        </tr>
        <tr>
            <th>Category</th>
            <td>{{ $product->category->name }}</td>
        </tr>
        <tr>
            <th>SKU</th>
            <td>{{ $product->sku }}</td>
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
            <th>Status</th>
            <td>
                <span class="badge badge-{{ $product->status === 'active' ? 'success' : 'danger' }}">
                    {{ ucfirst($product->status) }}
                </span>
            </td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{{ $product->description ?? 'No description' }}</td>
        </tr>
    </table>

    <h2 style="margin-top: 2rem; margin-bottom: 1rem;">Reviews</h2>
    @forelse($product->reviews as $review)
        <div style="padding: 1rem; border-bottom: 1px solid #eee; margin-bottom: 1rem;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                <strong>{{ $review->client->name }}</strong>
                <span class="badge badge-info">{{ $review->rating }} / 5</span>
            </div>
            <p style="color: #555;">{{ $review->comment }}</p>
            <small style="color: #7f8c8d;">{{ $review->created_at->format('M d, Y') }}</small>
        </div>
    @empty
        <p style="color: #7f8c8d; padding: 2rem; text-align: center;">No reviews yet.</p>
    @endforelse
</div>
@endsection

