@extends('admin.layout')

@section('content')
<h1 style="margin-bottom: 30px;">Dashboard Overview</h1>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px;">
    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div style="color: var(--text-light); font-size: 0.9rem;">Total Products</div>
            <i class="fa-solid fa-shirt" style="color: var(--accent-color);"></i>
        </div>
        <div style="font-size: 2rem; font-weight: 800; margin-top: 5px;">{{ $stats['total_products'] }}</div>
    </div>
    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div style="color: var(--text-light); font-size: 0.9rem;">Total Customers</div>
            <i class="fa-solid fa-user-group" style="color: var(--accent-color);"></i>
        </div>
        <div style="font-size: 2rem; font-weight: 800; margin-top: 5px;">{{ $stats['total_customers'] }}</div>
    </div>
    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div style="color: var(--text-light); font-size: 0.9rem;">Pending Orders</div>
            <i class="fa-solid fa-clock-rotate-left" style="color: #ef4444;"></i>
        </div>
        <div style="font-size: 2rem; font-weight: 800; margin-top: 5px;">{{ $stats['pending_orders'] }}</div>
    </div>
    <div class="admin-card" style="background: var(--primary-color); color: #fff;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div style="font-size: 0.9rem; opacity: 0.8;">Total Revenue</div>
            <i class="fa-solid fa-indian-rupee-sign" style="color: var(--accent-color);"></i>
        </div>
        <div style="font-size: 2rem; font-weight: 800; margin-top: 5px;">₹{{ number_format($stats['total_revenue']) }}</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-top: 40px;" class="mobile-grid-1">
    <div class="admin-card">
        <h3 style="margin-bottom: 20px;">Recent Orders</h3>
        <table style="margin-top: 0;">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recent_orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>₹{{ $order->total_amount }}</td>
                    <td>
                        <span style="padding: 4px 10px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; 
                            background: {{ $order->status == 'delivered' ? '#dcfce7' : ($order->status == 'pending' ? '#fef3c7' : '#dbeafe') }};
                            color: {{ $order->status == 'delivered' ? '#166534' : ($order->status == 'pending' ? '#92400e' : '#1e40af') }};">
                            {{ $order->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top: 20px; text-align: center;">
            <a href="{{ route('admin.orders') }}" style="color: var(--primary-color); font-weight: 700; font-size: 0.9rem;">View All Orders <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="admin-card">
        <h3 style="margin-bottom: 20px;">Latest Reviews</h3>
        <div style="display: flex; flex-direction: column; gap: 20px;">
            @foreach($latest_reviews as $review)
                <div style="border-bottom: 1px solid #f1f1f1; padding-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                        <strong style="font-size: 0.9rem;">{{ $review->user->name }}</strong>
                        <div style="color: var(--accent-color); font-size: 0.75rem;">
                            @for($i=0; $i<$review->rating; $i++) <i class="fa-solid fa-star"></i> @endfor
                        </div>
                    </div>
                    <div style="font-size: 0.75rem; color: var(--text-light); margin-bottom: 5px;">on <em>{{ $review->product->name }}</em></div>
                    <p style="font-size: 0.8rem; margin: 0; line-height: 1.4;">"{{ Str::limit($review->comment, 60) }}"</p>
                </div>
            @endforeach
        </div>
        <div style="margin-top: 20px; text-align: center;">
            <a href="{{ route('admin.reviews') }}" style="color: var(--primary-color); font-weight: 700; font-size: 0.9rem;">Manage Reviews <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 25px; margin-top: 40px;">
    <div class="admin-card" style="text-align: center; padding: 20px;">
        <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary-color);">{{ $stats['total_reviews'] }}</div>
        <div style="color: var(--text-light); font-size: 0.8rem;">Product Reviews</div>
    </div>
    <div class="admin-card" style="text-align: center; padding: 20px;">
        <div style="font-size: 1.5rem; font-weight: 800; color: #ef4444;">{{ $stats['pending_queries'] }}</div>
        <div style="color: var(--text-light); font-size: 0.8rem;">Unresolved Queries</div>
    </div>
</div>
@endsection
