@extends('layouts.app')

@section('title', 'Vendor Dashboard')

@section('content')
<h1 style="margin-bottom: 2rem;">Vendor Dashboard</h1>

<div class="alert alert-{{ $vendor->status === 'active' ? 'success' : 'warning' }}">
    Your vendor account status: <strong>{{ ucfirst($vendor->status) }}</strong>
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

