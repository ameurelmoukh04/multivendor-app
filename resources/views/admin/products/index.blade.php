@extends('layouts.app')

@section('title', 'Products')

@section('content')
<h1 style="margin-bottom: 2rem;">Products Pending Approval</h1>

<div style="margin-bottom: 2rem;">
    <a href="{{ route('admin.products.index', ['status' => 'pending']) }}" class="btn {{ request('status') != 'active' && request('status') != 'inactive' ? 'btn-primary' : 'btn-secondary' }}" style="margin-right: 0.5rem;">Pending</a>
    <a href="{{ route('admin.products.index', ['status' => 'active']) }}" class="btn {{ request('status') == 'active' ? 'btn-primary' : 'btn-secondary' }}" style="margin-right: 0.5rem;">Approved</a>
    <a href="{{ route('admin.products.index', ['status' => 'inactive']) }}" class="btn {{ request('status') == 'inactive' ? 'btn-primary' : 'btn-secondary' }}">Rejected</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Vendor</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->vendor->store_name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock }}</td>
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
                    <td>
                        <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-primary" style="padding: 0.5rem 1rem;">View</a>
                        @if($product->status === 'pending')
                            <form action="{{ route('admin.products.approve', $product->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success" style="padding: 0.5rem 1rem;">Approve</button>
                            </form>
                            <form action="{{ route('admin.products.reject', $product->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem;">Reject</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 2rem;">No products found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 2rem;">
    {{ $products->links() }}
</div>
@endsection

