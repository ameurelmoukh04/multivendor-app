@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<h1>Admin Dashboard</h1>

<form method="GET" style="margin-bottom: 1.5rem;">
    <label><strong>Filter by period:</strong></label>
    <select name="period" onchange="this.form.submit()">
        <option value="7" {{ request('period',7)==7 ? 'selected' : '' }}>Last 7 days</option>
        <option value="14" {{ request('period')==14 ? 'selected' : '' }}>Last 2 weeks</option>
        <option value="30" {{ request('period')==30 ? 'selected' : '' }}>Last 30 days</option>
        <option value="90" {{ request('period')==90 ? 'selected' : '' }}>Last 90 days</option>
    </select>
</form>

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
