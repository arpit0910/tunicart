@extends('layouts.frontend')

@section('title', 'Dashboard - Tunicart')

@section('content')
<section class="section">
    <div class="container">
        <div style="display: flex; gap: 30px; flex-wrap: wrap;">
            <!-- Sidebar -->
            <div style="flex: 1; min-width: 250px;">
                <div class="glass" style="padding: 25px; border-radius: 20px;">
                    <h3 style="margin-bottom: 25px; font-size: 1.4rem; font-weight: 800;">My Account</h3>
                    <ul style="display: flex; flex-direction: column; gap: 15px;">
                        <li><a href="#" style="font-weight: 700; color: var(--accent-color); display: flex; align-items: center; gap: 10px;">
                            <i class="fa-solid fa-gauge-high"></i> Dashboard
                        </a></li>
                        <li><a href="#" style="display: flex; align-items: center; gap: 10px; color: var(--text-light); transition: var(--transition);">
                            <i class="fa-solid fa-box"></i> My Orders
                        </a></li>
                        <li><a href="#" style="display: flex; align-items: center; gap: 10px; color: var(--text-light);">
                            <i class="fa-solid fa-user-gear"></i> Profile Settings
                        </a></li>
                        <li><a href="#" style="display: flex; align-items: center; gap: 10px; color: var(--text-light);">
                            <i class="fa-solid fa-palette"></i> Custom Designs
                        </a></li>
                        <li style="margin-top: 10px; padding-top: 20px; border-top: 1px solid var(--glass-border);">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" style="color: #ef4444; display: flex; align-items: center; gap: 10px; font-weight: 600;">
                                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div style="flex: 3; min-width: 300px;">
                <div class="glass" style="padding: 40px; border-radius: 20px; border: 1px solid var(--glass-border);">
                    <h2 style="font-size: 2rem; margin-bottom: 10px; font-weight: 900;">Welcome back, <span style="color: var(--secondary-color);">{{ Auth::user()->name }}</span>!</h2>
                    <p style="color: var(--text-light); margin-bottom: 35px; font-size: 1.1rem;">Manage your orders, designs, and account settings from your central command center.</p>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 45px;">
                        <div style="background: rgba(212, 175, 55, 0.1); padding: 25px; border-radius: 18px; border: 1px solid rgba(212, 175, 55, 0.2); position: relative; overflow: hidden;">
                            <div style="position: absolute; top: -10px; right: -10px; font-size: 4rem; color: rgba(212, 175, 55, 0.05); z-index: 0;"><i class="fa-solid fa-shopping-bag"></i></div>
                            <div style="font-size: 0.9rem; color: var(--text-light); font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; position: relative; z-index: 1;">Total Orders</div>
                            <div style="font-size: 2.5rem; font-weight: 900; color: var(--primary-color); position: relative; z-index: 1;">{{ $stats['total_orders'] }}</div>
                        </div>
                        <div style="background: rgba(225, 198, 153, 0.1); padding: 25px; border-radius: 18px; border: 1px solid rgba(225, 198, 153, 0.2); position: relative; overflow: hidden;">
                            <div style="position: absolute; top: -10px; right: -10px; font-size: 4rem; color: rgba(225, 198, 153, 0.05); z-index: 0;"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                            <div style="font-size: 0.9rem; color: var(--text-light); font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; position: relative; z-index: 1;">Active Designs</div>
                            <div style="font-size: 2.5rem; font-weight: 900; color: var(--primary-color); position: relative; z-index: 1;">{{ $stats['active_designs'] }}</div>
                        </div>
                    </div>

                    <h3 style="margin-bottom: 20px; font-size: 1.5rem; font-weight: 800;">Recent Orders</h3>
                    @if($orders->count() > 0)
                        <div style="display: flex; flex-direction: column; gap: 15px;">
                            @foreach($orders as $order)
                                <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--glass-border); padding: 20px; border-radius: 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                                    <div>
                                        <div style="font-weight: 800; font-size: 1.1rem; margin-bottom: 5px;">Order #{{ $order->id }}</div>
                                        <div style="font-size: 0.85rem; color: var(--text-light);">{{ $order->created_at->format('M d, Y') }} • ₹{{ $order->total_amount }}</div>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 20px;">
                                        <span style="padding: 5px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; 
                                            background: {{ $order->status == 'delivered' ? 'rgba(34, 197, 94, 0.1)' : 'rgba(212, 175, 55, 0.1)' }};
                                            color: {{ $order->status == 'delivered' ? '#4ade80' : 'var(--primary-color)' }};
                                            border: 1px solid {{ $order->status == 'delivered' ? 'rgba(34, 197, 94, 0.2)' : 'rgba(212, 175, 55, 0.2)' }};">
                                            {{ $order->status }}
                                        </span>
                                        <a href="{{ route('track-order', ['order_id' => $order->id]) }}" class="btn" style="padding: 8px 15px; font-size: 0.85rem; border: 1px solid var(--glass-border); color: var(--black); border-radius: 8px; font-weight: 700;">Track</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align: center; padding: 60px 40px; color: var(--text-light); background: rgba(255,255,255,0.02); border: 1px dashed var(--glass-border); border-radius: 18px;">
                            <i class="fa-solid fa-box-open" style="font-size: 3rem; margin-bottom: 20px; opacity: 0.3;"></i>
                            <p style="margin-bottom: 20px;">You haven't placed any orders yet. Ready to create something unique?</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary" style="display: inline-block;">Start Shopping</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
