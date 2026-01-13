@extends('layouts.app')

@section('title', 'Order #' . $order->id)

@push('styles')
<style>
    /* Container padding */
    main {
        padding: 2rem;
        max-width: 1200px;
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

    /* Delivery confirmation card */
    .delivery-confirmation-card {
        background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%);
        border: 2px solid #ffc107;
        padding: 2rem;
        border-radius: 0.5rem;
        margin-top: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .dark .delivery-confirmation-card {
        background: linear-gradient(135deg, #78350f 0%, #92400e 100%);
        border-color: #f59e0b;
    }

    .delivery-confirmation-card h3 {
        color: #856404;
        margin-bottom: 1rem;
        font-size: 1.5rem;
    }
    .dark .delivery-confirmation-card h3 {
        color: #fef3c7;
    }

    .delivery-confirmation-card p {
        color: #856404;
        margin-bottom: 1.5rem;
        font-size: 1rem;
    }
    .dark .delivery-confirmation-card p {
        color: #fef3c7;
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
    }

    .btn-secondary {
        background-color: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #4b5563;
    }

    .btn-success {
        background-color: #10b981;
        color: white;
        padding: 0.75rem 2rem;
        font-size: 1rem;
        font-weight: 600;
    }

    .btn-success:hover {
        background-color: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
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

    /* Review Modal */
    #reviewModal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 2000;
        align-items: center;
        justify-content: center;
    }

    #reviewModal .card {
        max-width: 500px;
        width: 90%;
        padding: 2rem;
        position: relative;
    }

    /* Form styles */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #374151;
        font-size: 0.875rem;
    }
    .dark .form-group label {
        color: #e5e7eb;
    }

    .form-control {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        background: white;
        color: #1f2937;
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

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    select.form-control {
        cursor: pointer;
    }

    /* Text colors for dark mode */
    h1, h2, h3 {
        color: #1f2937;
    }
    .dark h1,
    .dark h2,
    .dark h3 {
        color: #f9fafb;
    }

    /* Success message */
    .alert-success {
        padding: 1rem 1.5rem;
        background-color: #d1fae5;
        color: #065f46;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
        border-left: 4px solid #10b981;
    }
    .dark .alert-success {
        background-color: #064e3b;
        color: #d1fae5;
        border-left-color: #10b981;
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
<h1 style="margin-bottom: 2rem;">Order #{{ $order->id }}</h1>

@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

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
                @if($order->received_at)
                    <br><small style="color: #7f8c8d;">Received on: {{ is_string($order->received_at) ? \Carbon\Carbon::parse($order->received_at)->format('M d, Y H:i') : $order->received_at->format('M d, Y H:i') }}</small>
                @endif
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

@if(in_array($order->status, ['paid', 'shipped', 'delivered']))
    <div class="delivery-confirmation-card">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
            <div style="font-size: 3rem;">📦</div>
            <div>
                <h3 style="margin: 0;">
                    @if($order->status === 'delivered')
                        Order Delivered!
                    @elseif($order->status === 'shipped')
                        Order Shipped!
                    @else
                        Order Ready!
                    @endif
                </h3>
                <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem;">
                    @if($order->status === 'delivered')
                        Your order has been delivered to your address
                    @elseif($order->status === 'shipped')
                        Your order is on the way
                    @else
                        Your order is ready for pickup/delivery
                    @endif
                </p>
            </div>
        </div>
        <p style="margin-bottom: 1.5rem; font-weight: 500;">
            Please confirm that you have received your order. Once confirmed, you'll be able to add reviews for the products you purchased.
        </p>
        <form action="{{ route('user.orders.confirmReceipt', $order->id) }}" method="POST" onsubmit="return confirm('Have you received your order? Click OK to confirm receipt.');">
            @csrf
            <button type="submit" class="btn btn-success">
                ✓ Confirm I Received My Order
            </button>
        </form>
    </div>
@endif

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
                @if($order->status === 'received')
                    <th>Review</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>
                        <a href="{{ route('products.show', $item->product->id) }}" style="color: #3498db; text-decoration: none;">
                            {{ $item->product->name }}
                        </a>
                    </td>
                    <td>{{ $item->vendor->store_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                    @if($order->status === 'received')
                        <td>
                            @if($item->review)
                                <span class="badge badge-success">Reviewed</span>
                                <br><small style="color: #7f8c8d;">Rating: {{ $item->review->rating }}/5</small>
                            @else
                                <button type="button" class="btn btn-primary btn-sm" onclick="showReviewModal({{ $item->id }}, '{{ $item->product->name }}')">
                                    Add Review
                                </button>
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if($order->status === 'received')
    <!-- Review Modal -->
    <div id="reviewModal">
        <div class="card">
            <button onclick="closeReviewModal()" style="position: absolute; top: 10px; right: 10px; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #6b7280;">&times;</button>
            <h2 style="margin-bottom: 1rem;">Add Review</h2>
            <p id="reviewProductName" style="margin-bottom: 1rem; font-weight: bold;"></p>
            <form id="reviewForm" method="POST">
                @csrf
                <div class="form-group">
                    <label for="rating">Rating *</label>
                    <select id="rating" name="rating" class="form-control" required>
                        <option value="">Select Rating</option>
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Very Good</option>
                        <option value="3">3 - Good</option>
                        <option value="2">2 - Fair</option>
                        <option value="1">1 - Poor</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea id="comment" name="comment" class="form-control" rows="4" maxlength="1000"></textarea>
                </div>
                <div style="margin-top: 1rem;">
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                    <button type="button" class="btn btn-secondary" onclick="closeReviewModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showReviewModal(orderItemId, productName) {
            document.getElementById('reviewProductName').textContent = productName;
            document.getElementById('reviewForm').action = '{{ route("user.reviews.store", ":id") }}'.replace(':id', orderItemId);
            document.getElementById('reviewModal').style.display = 'flex';
        }

        function closeReviewModal() {
            document.getElementById('reviewModal').style.display = 'none';
            document.getElementById('reviewForm').reset();
        }

        // Close modal when clicking outside
        document.getElementById('reviewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReviewModal();
            }
        });
    </script>
@endif
@endsection

