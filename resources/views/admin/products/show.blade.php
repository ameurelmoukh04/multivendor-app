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

    /* Action section */
    .action-section {
        margin-top: 2rem;
        padding: 1.5rem;
        background-color: #f8f9fa;
        border-radius: 0.5rem;
    }
    .dark .action-section {
        background-color: #374151;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
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

    .btn-success {
        background-color: #10b981;
        color: white;
    }

    .btn-success:hover {
        background-color: #059669;
    }

    .btn-danger {
        background-color: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background-color: #dc2626;
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

    /* Text colors for dark mode */
    h1, h2, h3 {
        color: #1f2937;
    }
    .dark h1,
    .dark h2,
    .dark h3 {
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

        .action-buttons {
            flex-direction: column;
        }
    }
</style>
@endpush

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
            <div class="image-grid">
                @foreach($product->images as $image)
                    <div class="image-item">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image">
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($product->status === 'pending')
        <div class="action-section">
            <h3 style="margin-bottom: 1rem;">Product Actions</h3>
            <div class="action-buttons">
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


