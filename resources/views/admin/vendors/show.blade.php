@extends('layouts.app')

@section('title', $vendor->store_name)

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

    .table thead {
        background-color: #f9fafb;
    }
    .dark .table thead {
        background-color: #374151;
    }

    .table th {
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
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

    .table tbody tr:hover {
        background-color: #f9fafb;
    }
    .dark .table tbody tr:hover {
        background-color: #374151;
    }

    .table tr:last-child td {
        border-bottom: none;
    }

    /* Form styles */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #374151;
        font-size: 0.875rem;
    }
    .dark .form-group label {
        color: #e5e7eb;
    }

    .form-control {
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        background: white;
        color: #1f2937;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .dark .form-control {
        background: #374151;
        border-color: #4b5563;
        color: #f9fafb;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    select.form-control {
        cursor: pointer;
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

    .badge-danger {
        background-color: #fee2e2;
        color: #991b1b;
    }
    .dark .badge-danger {
        background-color: #7f1d1d;
        color: #fee2e2;
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
    }
</style>
@endpush

@section('content')
<h1 style="margin-bottom: 2rem;">{{ $vendor->store_name }}</h1>

<div class="card">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.vendors.index') }}" class="btn btn-secondary">Back to Vendors</a>
    </div>

    <table class="table">
        <tr>
            <th style="width: 200px;">Store Name</th>
            <td>{{ $vendor->store_name }}</td>
        </tr>
        <tr>
            <th>Owner</th>
            <td>{{ $vendor->user->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $vendor->user->email }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <span class="badge badge-{{ $vendor->status === 'active' ? 'success' : 'danger' }}">
                    {{ ucfirst($vendor->status) }}
                </span>
            </td>
        </tr>
        <tr>
            <th>Rating</th>
            <td>{{ number_format($vendor->rating, 2) }} / 5.00</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{{ $vendor->description ?? 'No description' }}</td>
        </tr>
        <tr>
            <th>Products Count</th>
            <td>{{ $vendor->products->count() }}</td>
        </tr>
    </table>

    <form action="{{ route('admin.vendors.updateStatus', $vendor->id) }}" method="POST" style="margin-top: 2rem;">
        @csrf
        <div class="form-group">
            <label for="status">Change Status</label>
            <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                <select id="status" name="status" class="form-control" style="width: auto;">
                    <option value="active" {{ $vendor->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $vendor->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                <button type="submit" class="btn btn-primary">Update Status</button>
            </div>
        </div>
    </form>
</div>

<div class="card" style="margin-top: 2rem;">
    <h2 style="margin-bottom: 1rem;">Products</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vendor->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <span class="badge badge-{{ $product->status === 'active' ? 'success' : 'danger' }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 2rem;">No products yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

