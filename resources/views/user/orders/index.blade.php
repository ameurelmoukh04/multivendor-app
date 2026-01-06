@extends('layouts.app')

@section('title', 'My Orders')

@push('styles')
<style>
    /* Container padding */
    main {
        padding: 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Page Title */
    h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 2rem;
    }
    .dark h1 {
        color: #f9fafb;
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
        border-bottom: 2px solid #e5e7eb;
    }
    .dark .table th {
        color: #e5e7eb;
        border-bottom-color: #4b5563;
    }

    .table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e5e7eb;
        color: #1f2937;
    }
    .dark .table td {
        border-bottom-color: #4b5563;
        color: #f9fafb;
    }

    .table tr:last-child td {
        border-bottom: none;
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
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
    }

    .btn-success {
        background-color: #10b981;
        color: white;
    }

    .btn-success:hover {
        background-color: #059669;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3);
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
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

    .badge-warning {
        background-color: #fef3c7;
        color: #92400e;
    }
    .dark .badge-warning {
        background-color: #78350f;
        color: #fef3c7;
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

    /* Action buttons container */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #6b7280;
    }
    .dark .empty-state {
        color: #9ca3af;
    }

    .empty-state a {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }
    .dark .empty-state a {
        color: #60a5fa;
    }

    .empty-state a:hover {
        color: #2563eb;
        text-decoration: underline;
    }
    .dark .empty-state a:hover {
        color: #93c5fd;
    }

    /* Pagination */
    .pagination-container {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }

    /* Responsive */
    @media (max-width: 768px) {
        main {
            padding: 1rem;
        }

        h1 {
            font-size: 1.5rem;
        }

        .table {
            font-size: 0.875rem;
        }

        .table th,
        .table td {
            padding: 0.5rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<h1>My Orders</h1>

@if(session('success'))
    <div class="alert alert-success" style="padding: 1rem 1.5rem; background-color: #d1fae5; color: #065f46; border-radius: 0.5rem; margin-bottom: 1rem; border-left: 4px solid #10b981;">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Payment Method</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td><strong>#{{ $order->id }}</strong></td>
                    <td><strong style="color: #10b981;">${{ number_format($order->total_amount, 2) }}</strong></td>
                    <td>
                        @php
                            $badgeClass = match($order->status) {
                                'completed', 'received' => 'success',
                                'cancelled' => 'danger',
                                'delivered' => 'warning',
                                default => 'info'
                            };
                        @endphp
                        <span class="badge badge-{{ $badgeClass }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</td>
                    <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('user.orders.show', $order->id) }}" class="btn btn-primary">
                                View Details
                            </a>
                            @if(in_array($order->status, ['pending','delivered']))
                                <form action="{{ route('user.orders.confirmReceipt', $order->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Have you received your order?');">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        Confirm Receipt
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty-state">
                        <p style="font-size: 1.125rem; margin-bottom: 0.5rem;">No orders yet.</p>
                        <a href="{{ route('products.index') }}">Browse products</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($orders->hasPages())
    <div class="pagination-container">
        {{ $orders->links() }}
    </div>
@endif
@endsection

