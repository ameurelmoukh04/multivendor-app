@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<h1 style="margin-bottom: 2rem;">Admin Dashboard</h1>

<div class="stats-grid">
    <div class="stat-card">
        <h3>{{ $stats['users'] }}</h3>
        <p>Total Users</p>
    </div>
    <div class="stat-card">
        <h3>{{ $stats['vendors'] }}</h3>
        <p>Total Vendors</p>
    </div>
    <div class="stat-card">
        <h3>{{ $stats['products'] }}</h3>
        <p>Total Products</p>
    </div>
    <div class="stat-card">
        <h3>{{ $stats['orders'] }}</h3>
        <p>Total Orders</p>
    </div>
    <div class="stat-card">
        <h3>{{ $stats['pending_orders'] }}</h3>
        <p>Pending Orders</p>
    </div>
</div>

<div class="card">
    <h2 style="margin-bottom: 1rem;">Recent Orders</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Status</th>
                <th>Total Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentOrders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->client->name }}</td>
                    <td><span class="badge badge-info">{{ ucfirst($order->status) }}</span></td>
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">No orders yet</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

