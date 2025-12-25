@extends('layouts.app')

@section('title', 'Vendors')

@section('content')
<h1 style="margin-bottom: 2rem;">Vendors</h1>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Store Name</th>
                <th>Owner</th>
                <th>Email</th>
                <th>Status</th>
                <th>Rating</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vendors as $vendor)
                <tr>
                    <td>{{ $vendor->id }}</td>
                    <td>{{ $vendor->store_name }}</td>
                    <td>{{ $vendor->user->name }}</td>
                    <td>{{ $vendor->user->email }}</td>
                    <td>
                        <span class="badge badge-{{ $vendor->status === 'active' ? 'success' : 'danger' }}">
                            {{ ucfirst($vendor->status) }}
                        </span>
                    </td>
                    <td>{{ number_format($vendor->rating, 2) }}</td>
                    <td>
                        <a href="{{ route('admin.vendors.show', $vendor->id) }}" class="btn btn-primary" style="padding: 0.5rem 1rem;">View</a>
                        <form action="{{ route('admin.vendors.updateStatus', $vendor->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <select name="status" onchange="this.form.submit()" style="padding: 0.5rem;">
                                <option value="active" {{ $vendor->status === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $vendor->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem;">No vendors yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 2rem;">
    {{ $vendors->links() }}
</div>
@endsection

