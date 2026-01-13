@extends('layouts.app')

@section('title', 'Admin Dashboard')

@push('styles')
<style>
    /* Date Filter Styles */
    .date-filter-card {
        background: white;
        padding: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        margin-bottom: 2rem;
    }
    .dark .date-filter-card {
        background: #1f2937;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3), 0 1px 2px 0 rgba(0, 0, 0, 0.2);
    }

    .date-filter-form {
        display: flex;
        gap: 1rem;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .date-filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        flex: 1;
        min-width: 200px;
    }

    .date-filter-group label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
    }
    .dark .date-filter-group label {
        color: #e5e7eb;
    }

    .date-filter-group input {
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        background: white;
        color: #1f2937;
    }
    .dark .date-filter-group input {
        background: #374151;
        border-color: #4b5563;
        color: #f9fafb;
    }

    .date-filter-group input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .date-filter-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-filter {
        padding: 0.5rem 1.5rem;
        background: #3b82f6;
        color: white;
        border: none;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.875rem;
    }

    .btn-filter:hover {
        background: #2563eb;
    }

    .btn-reset {
        padding: 0.5rem 1.5rem;
        background: #6b7280;
        color: white;
        border: none;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.875rem;
        text-decoration: none;
        display: inline-block;
    }

    .btn-reset:hover {
        background: #4b5563;
    }

    .filter-active-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #dbeafe;
        color: #1e40af;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        margin-left: 1rem;
    }
    .dark .filter-active-badge {
        background: #1e3a8a;
        color: #dbeafe;
    }

    /* Stats grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        text-align: center;
    }
    .dark .stat-card {
        background: #1f2937;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3), 0 1px 2px 0 rgba(0, 0, 0, 0.2);
    }

    .stat-card h3 {
        font-size: 2rem;
        font-weight: bold;
        color: #1f2937;
        margin: 0 0 0.5rem 0;
    }
    .dark .stat-card h3 {
        color: #f9fafb;
    }

    .stat-card p {
        color: #6b7280;
        margin: 0;
        font-size: 0.875rem;
    }
    .dark .stat-card p {
        color: #9ca3af;
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

    .card h2 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 1rem 0;
    }
    .dark .card h2 {
        color: #f9fafb;
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

    .badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge-info {
        background-color: #dbeafe;
        color: #1e40af;
    }
    .dark .badge-info {
        background-color: #1e3a8a;
        color: #dbeafe;
    }

    h1 {
        color: #1f2937;
    }
    .dark h1 {
        color: #f9fafb;
    }

    @media (max-width: 640px) {
        .date-filter-form {
            flex-direction: column;
        }

        .date-filter-group {
            width: 100%;
        }

        .date-filter-actions {
            width: 100%;
        }

        .btn-filter,
        .btn-reset {
            flex: 1;
        }
    }
</style>
@endpush

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
    <h1 style="margin: 0;">Admin Dashboard</h1>
    @if($startDate || $endDate)
        <span class="filter-active-badge">
            <span>📅 Filter Active</span>
        </span>
    @endif
</div>

<!-- Date Filter -->
<div class="date-filter-card">
    <form method="GET" action="{{ route('admin.dashboard') }}" class="date-filter-form">
        <div class="date-filter-group">
            <label for="start_date">Start Date</label>
            <input 
                type="date" 
                id="start_date" 
                name="start_date" 
                value="{{ $startDate ?? '' }}"
                max="{{ date('Y-m-d') }}"
            >
        </div>
        <div class="date-filter-group">
            <label for="end_date">End Date</label>
            <input 
                type="date" 
                id="end_date" 
                name="end_date" 
                value="{{ $endDate ?? '' }}"
                max="{{ date('Y-m-d') }}"
            >
        </div>
        <div class="date-filter-actions">
            <button type="submit" class="btn-filter">Apply Filter</button>
            @if($startDate || $endDate)
                <a href="{{ route('admin.dashboard') }}" class="btn-reset">Reset</a>
            @endif
        </div>
    </form>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>{{ number_format($totalRevenue ?? 0, 2) }} $</h3>
        <p>Total Revenue</p>
    </div>

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

@endsection
