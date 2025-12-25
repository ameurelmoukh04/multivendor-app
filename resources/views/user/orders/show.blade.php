@extends('layouts.app')

@section('title', 'Order #' . $order->id)

@section('content')
<h1 style="margin-bottom: 2rem;">Order #{{ $order->id }}</h1>

<div class="card">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('user.orders.index') }}" class="btn btn-secondary">Back to Orders</a>
    </div>

    <table class="table">
        <tr>
            <th style="width: 200px;">Order ID</th>
            <td>#{{ $order->id }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <span class="badge badge-{{ $order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'info') }}">
                    {{ ucfirst($order->status) }}
                </span>
            </td>
        </tr>
        <tr>
            <th>Payment Method</th>
            <td>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</td>
        </tr>
        <tr>
            <th>Shipping Address</th>
            <td>{{ $order->shipping_address }}</td>
        </tr>
        <tr>
            <th>Total Amount</th>
            <td><strong style="font-size: 1.2rem;">${{ number_format($order->total_amount, 2) }}</strong></td>
        </tr>
        <tr>
            <th>Order Date</th>
            <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
        </tr>
    </table>
</div>

<div class="card" style="margin-top: 2rem;">
    <h2 style="margin-bottom: 1rem;">Order Items</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Vendor</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->vendor->store_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

