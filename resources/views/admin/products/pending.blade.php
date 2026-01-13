@extends('layouts.app')

@section('title', 'Pending Products')

@section('content')

<h1>Pending Products</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Vendor</th>
            <th>Category</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->vendor->user->email ?? 'Vendor' }}</td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td>${{ number_format($product->price, 2) }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.products.approve', $product->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            Approve
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No pending products</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
