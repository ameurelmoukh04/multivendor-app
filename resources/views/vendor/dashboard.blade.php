@extends('layouts.app')

@section('title', 'Vendor Dashboard')

@push('styles')
<style>
    /* Container padding */
    main {
        padding: 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Alert styles */
    .alert {
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        border-radius: 0.5rem;
        border-left: 4px solid;
    }
    .alert-success {
        background-color: #d1fae5;
        border-color: #10b981;
        color: #065f46;
    }
    .dark .alert-success {
        background-color: #064e3b;
        border-color: #10b981;
        color: #d1fae5;
    }
    .alert-warning {
        background-color: #fef3c7;
        border-color: #f59e0b;
        color: #92400e;
    }
    .dark .alert-warning {
        background-color: #78350f;
        border-color: #f59e0b;
        color: #fef3c7;
    }

    /* Stats grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        text-align: center;
    }
    .dark .stat-card {
        background: #1f2937;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3), 0 1px 2px 0 rgba(0, 0, 0, 0.2);
    }

    .stat-card h3 {
        font-size: 2rem;
        font-weight: bold;
        color: #1f2937;
        margin: 0 0 0.5rem 0;
    }
    .dark .stat-card h3 {
        color: #f9fafb;
    }

    .stat-card p {
        color: #6b7280;
        margin: 0;
        font-size: 0.875rem;
    }
    .dark .stat-card p {
        color: #9ca3af;
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

    .card h2 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 1rem 0;
    }
    .dark .card h2 {
        color: #f9fafb;
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
    }
    .dark .table th {
        color: #e5e7eb;
    }

    .table td {
        padding: 0.75rem 1rem;
        border-top: 1px solid #e5e7eb;
        color: #1f2937;
    }
    .dark .table td {
        border-top: 1px solid #4b5563;
        color: #f9fafb;
    }

    .table tbody tr:hover {
        background-color: #f9fafb;
    }
    .dark .table tbody tr:hover {
        background-color: #374151;
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

    .badge-info {
        background-color: #dbeafe;
        color: #1e40af;
    }
    .dark .badge-info {
        background-color: #1e3a8a;
        color: #dbeafe;
    }

    /* Text colors for dark mode */
    h1 {
        color: #1f2937;
    }
    .dark h1 {
        color: #f9fafb;
    }

    /* Responsive */
    @media (max-width: 768px) {
        main {
            padding: 1rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
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

@push('styles')
<style>
    /* Date Filter Styles */
    .date-filter-card {
        background: white;
        padding: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        margin-bottom: 2rem;
    }
    .dark .date-filter-card {
        background: #1f2937;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3), 0 1px 2px 0 rgba(0, 0, 0, 0.2);
    }

    .date-filter-form {
        display: flex;
        gap: 1rem;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .date-filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        flex: 1;
        min-width: 200px;
    }

    .date-filter-group label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
    }
    .dark .date-filter-group label {
        color: #e5e7eb;
    }

    .date-filter-group input {
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        background: white;
        color: #1f2937;
    }
    .dark .date-filter-group input {
        background: #374151;
        border-color: #4b5563;
        color: #f9fafb;
    }

    .date-filter-group input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .date-filter-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-filter {
        padding: 0.5rem 1.5rem;
        background: #3b82f6;
        color: white;
        border: none;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.875rem;
    }

    .btn-filter:hover {
        background: #2563eb;
    }

    .btn-reset {
        padding: 0.5rem 1.5rem;
        background: #6b7280;
        color: white;
        border: none;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.875rem;
        text-decoration: none;
        display: inline-block;
    }

    .btn-reset:hover {
        background: #4b5563;
    }

    .filter-active-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #dbeafe;
        color: #1e40af;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        margin-left: 1rem;
    }
    .dark .filter-active-badge {
        background: #1e3a8a;
        color: #dbeafe;
    }

    @media (max-width: 640px) {
        .date-filter-form {
            flex-direction: column;
        }

        .date-filter-group {
            width: 100%;
        }

        .date-filter-actions {
            width: 100%;
        }

        .btn-filter,
        .btn-reset {
            flex: 1;
        }
    }
</style>
@endpush

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
    <h1 style="margin: 0;" class="text-gray-900 dark:text-gray-100">Vendor Dashboard</h1>
    @if($startDate ?? false || $endDate ?? false)
        <span class="filter-active-badge">
            <span>📅 Filter Active</span>
        </span>
    @endif
</div>

<div class="alert alert-{{ $vendor->status === 'active' ? 'success' : 'warning' }}">
    Your vendor account status: <strong>{{ ucfirst($vendor->status) }}</strong>
</div>

<!-- Date Filter -->
<div class="date-filter-card">
    <form method="GET" action="{{ route('vendor.dashboard') }}" class="date-filter-form">
        <div class="date-filter-group">
            <label for="start_date">Start Date</label>
            <input 
                type="date" 
                id="start_date" 
                name="start_date" 
                value="{{ $startDate ?? '' }}"
                max="{{ date('Y-m-d') }}"
            >
        </div>
        <div class="date-filter-group">
            <label for="end_date">End Date</label>
            <input 
                type="date" 
                id="end_date" 
                name="end_date" 
                value="{{ $endDate ?? '' }}"
                max="{{ date('Y-m-d') }}"
            >
        </div>
        <div class="date-filter-actions">
            <button type="submit" class="btn-filter">Apply Filter</button>
            @if($startDate ?? false || $endDate ?? false)
                <a href="{{ route('vendor.dashboard') }}" class="btn-reset">Reset</a>
            @endif
        </div>
    </form>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>{{ $stats['products'] }}</h3>
        <p>Total Products</p>
    </div>
    <div class="stat-card">
        <h3>{{ $stats['active_products'] }}</h3>
        <p>Active Products</p>
    </div>
    <div class="stat-card">
        <h3>{{ $stats['total_orders'] }}</h3>
        <p>Total Orders</p>
    </div>
    <div class="stat-card">
        <h3>{{ $stats['pending_orders'] }}</h3>
        <p>Pending Orders</p>
    </div>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Recent Products</h2>
        <a href="{{ route('vendor.products.create') }}" class="btn btn-primary">Add New Product</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentProducts as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <span class="badge badge-{{ $product->status === 'active' ? 'success' : 'danger' }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('vendor.products.edit', $product->id) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem;">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">No products yet. <a href="{{ route('vendor.products.create') }}">Create your first product</a></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

