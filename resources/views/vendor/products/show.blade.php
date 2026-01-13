@extends('layouts.app')

@section('title', $product->name)

@push('styles')
<style>
    /* Container padding */
    main {
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Card styles */
    .card {
        background: white;
        padding: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        margin-bottom: 2rem;
    }
    .dark .card {
        background: #1f2937;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3), 0 1px 2px 0 rgba(0, 0, 0, 0.2);
    }

    /* Table styles */
    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th {
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
        border-bottom: 2px solid #e5e7eb;
    }
    .dark .table th {
        color: #e5e7eb;
        border-bottom-color: #4b5563;
    }

    .table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e5e7eb;
        color: #1f2937;
    }
    .dark .table td {
        border-bottom-color: #4b5563;
        color: #f9fafb;
    }

    .table tr:last-child td {
        border-bottom: none;
    }

    /* Button styles */
    .btn {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
        margin-right: 0.5rem;
    }

    .btn-primary {
        background-color: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background-color: #2563eb;
    }

    .btn-secondary {
        background-color: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #4b5563;
    }

    /* Badge styles */
    .badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge-success {
        background-color: #d1fae5;
        color: #065f46;
    }
    .dark .badge-success {
        background-color: #064e3b;
        color: #d1fae5;
    }

    .badge-warning {
        background-color: #fef3c7;
        color: #92400e;
    }
    .dark .badge-warning {
        background-color: #78350f;
        color: #fef3c7;
    }

    .badge-danger {
        background-color: #fee2e2;
        color: #991b1b;
    }
    .dark .badge-danger {
        background-color: #7f1d1d;
        color: #fee2e2;
    }

    .badge-info {
        background-color: #dbeafe;
        color: #1e40af;
    }
    .dark .badge-info {
        background-color: #1e3a8a;
        color: #dbeafe;
    }

    /* Image grid */
    .image-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .image-item {
        border: 1px solid #d1d5db;
        padding: 0.5rem;
        border-radius: 0.5rem;
        background: white;
    }
    .dark .image-item {
        background: #374151;
        border-color: #4b5563;
    }

    .image-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 0.25rem;
    }

    /* Review styles */
    .review-item {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 1rem;
    }
    .dark .review-item {
        border-bottom-color: #4b5563;
    }

    .review-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .review-header strong {
        color: #1f2937;
    }
    .dark .review-header strong {
        color: #f9fafb;
    }

    .review-content {
        color: #4b5563;
        margin-bottom: 0.5rem;
    }
    .dark .review-content {
        color: #d1d5db;
    }

    .review-date {
        color: #6b7280;
        font-size: 0.875rem;
    }
    .dark .review-date {
        color: #9ca3af;
    }

    /* Text colors for dark mode */
    h1, h2 {
        color: #1f2937;
    }
    .dark h1,
    .dark h2 {
        color: #f9fafb;
    }

    /* Responsive */
    @media (max-width: 768px) {
        main {
            padding: 1rem;
        }

        .table {
            font-size: 0.875rem;
        }

        .table th,
        .table td {
            padding: 0.5rem;
        }

        .image-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }
    }
</style>
@endpush

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
            <h2 style="margin-bottom: 1rem;">Product Images</h2>
            <div class="image-grid">
                @foreach($product->images as $image)
                    <div class="image-item">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image">
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <h2 style="margin-top: 2rem; margin-bottom: 1rem;">Reviews</h2>
    @forelse($product->reviews as $review)
        <div class="review-item">
            <div class="review-header">
                <strong>{{ $review->client->name }}</strong>
                <span class="badge badge-info">{{ $review->rating }} / 5</span>
            </div>
            <p class="review-content">{{ $review->comment }}</p>
            <small class="review-date">{{ $review->created_at->format('M d, Y') }}</small>
        </div>
    @empty
        <p style="color: #6b7280; padding: 2rem; text-align: center;" class="dark:text-gray-400">No reviews yet.</p>
    @endforelse
</div>
@endsection

