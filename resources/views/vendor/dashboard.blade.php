@extends('layouts.app')

@section('title', 'Vendor Dashboard')

@section('content')

<h1 style="margin-bottom: 2rem;">Vendor Dashboard</h1>

<div class="alert alert-success">
    Vendor dashboard loaded successfully
</div>
<form method="GET" style="margin-bottom: 1.5rem;">
    <label><strong>Filter by period:</strong></label>
    <select name="period" onchange="this.form.submit()">
        <option value="7" {{ request('period', 7) == 7 ? 'selected' : '' }}>Last 7 days</option>
        <option value="14" {{ request('period') == 14 ? 'selected' : '' }}>Last 2 weeks</option>
        <option value="30" {{ request('period') == 30 ? 'selected' : '' }}>Last 30 days</option>
        <option value="90" {{ request('period') == 90 ? 'selected' : '' }}>Last 90 days</option>
    </select>
</form>

<div class="stats-grid">
    <div class="stat-card">
        <h3>{{ number_format($totalRevenue ?? 0, 2) }} $</h3>

        <p>Total Revenue</p>
    </div>

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

<div class="card" style="margin-top: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Recent Products</h2>
        <a href="{{ route('vendor.products.create') }}" class="btn btn-primary">
            Add New Product
        </a>
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
                        <span class="badge badge-secondary">
                            {{ ucfirst($product->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('vendor.products.edit', $product->id) }}" class="btn btn-secondary">
                            Edit
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">
                        No products yet.
                        <a href="{{ route('vendor.products.create') }}">
                            Create your first product
                        </a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
