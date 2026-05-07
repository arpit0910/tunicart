@extends('admin.layout')

@section('content')
<h1 style="margin-bottom: 30px;">Dashboard Overview</h1>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px;">
    <div class="admin-card">
        <div style="color: var(--text-light); font-size: 0.9rem;">Total Products</div>
        <div style="font-size: 2rem; font-weight: 800; margin-top: 5px;">{{ $stats['total_products'] }}</div>
    </div>
    <div class="admin-card">
        <div style="color: var(--text-light); font-size: 0.9rem;">Total Categories</div>
        <div style="font-size: 2rem; font-weight: 800; margin-top: 5px;">{{ $stats['total_categories'] }}</div>
    </div>
    <div class="admin-card">
        <div style="color: var(--text-light); font-size: 0.9rem;">Orders Today</div>
        <div style="font-size: 2rem; font-weight: 800; margin-top: 5px;">{{ $stats['total_orders'] }}</div>
    </div>
    <div class="admin-card" style="background: var(--primary-color); color: #fff;">
        <div style="font-size: 0.9rem; opacity: 0.8;">Total Revenue</div>
        <div style="font-size: 2rem; font-weight: 800; margin-top: 5px;">₹{{ number_format($stats['total_revenue']) }}</div>
    </div>
</div>

<div class="admin-card" style="margin-top: 40px;">
    <h2>Recent Activity</h2>
    <p style="color: var(--text-light); padding: 40px 0; text-align: center;">No recent activity logs found.</p>
</div>
@endsection
