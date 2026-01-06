@extends('layouts.app')

@section('title', 'Vendors')

@push('styles')
<style>
    /* Container padding */
    main {
        padding: 2rem;
        max-width: 1400px;
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

    /* Form control styles */
    .form-control {
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background: white;
        color: #1f2937;
        font-size: 0.875rem;
        cursor: pointer;
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
                            <select name="status" onchange="this.form.submit()" class="form-control" style="width: auto; display: inline-block;">
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

