@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
    <div class="card">
        <h1 style="margin-bottom: 1rem;">{{ $product->name }}</h1>
        <p style="color: #7f8c8d; margin-bottom: 1rem;">Sold by: <strong>{{ $product->vendor->store_name }}</strong></p>
        <p style="color: #7f8c8d; margin-bottom: 2rem;">Category: <strong>{{ $product->category->name }}</strong></p>
        
        <div style="margin-bottom: 2rem;">
            <h2 style="color: #27ae60; font-size: 2rem; margin-bottom: 0.5rem;">${{ number_format($product->price, 2) }}</h2>
            <span class="badge badge-{{ $product->stock > 0 ? 'success' : 'danger' }}" style="font-size: 1rem; padding: 0.5rem 1rem;">
                {{ $product->stock > 0 ? 'In Stock (' . $product->stock . ' available)' : 'Out of Stock' }}
            </span>
        </div>

        <div style="margin-bottom: 2rem;">
            <h3>Description</h3>
            <p style="margin-top: 0.5rem; line-height: 1.6;">{{ $product->description ?? 'No description available.' }}</p>
        </div>

        @if($product->stock > 0)
            <div style="margin-top: 2rem; padding: 1.5rem; background-color: #f8f9fa; border-radius: 4px;">
                <p style="margin-bottom: 1rem; color: #7f8c8d;">Note: Order functionality is simplified for this school project. In a real application, you would add items to a cart and checkout.</p>
                <p style="font-weight: 500;">Available Stock: {{ $product->stock }} units</p>
            </div>
        @else
            <button disabled class="btn btn-secondary" style="width: 100%; padding: 1rem; font-size: 1.1rem; margin-top: 2rem;">Out of Stock</button>
        @endif
    </div>

    <div class="card">
        <h2 style="margin-bottom: 1rem;">Reviews</h2>
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
            <p style="color: #7f8c8d; text-align: center; padding: 2rem;">No reviews yet.</p>
        @endforelse
    </div>
</div>

<a href="{{ route('user.products.index') }}" class="btn btn-secondary">Back to Products</a>
@endsection

