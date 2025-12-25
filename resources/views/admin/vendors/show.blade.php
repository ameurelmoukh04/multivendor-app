@extends('layouts.app')

@section('title', $vendor->store_name)

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
            <select id="status" name="status" class="form-control" style="width: auto; display: inline-block;">
                <option value="active" {{ $vendor->status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $vendor->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="btn btn-primary" style="margin-left: 1rem;">Update Status</button>
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

