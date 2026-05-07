@extends('layouts.frontend')

@section('title', 'Dashboard - Tunicart')

@section('content')
<section class="section">
    <div class="container">
        <div style="display: flex; gap: 30px;">
            <!-- Sidebar -->
            <div style="flex: 1; max-width: 250px;">
                <div style="background: var(--bg-alt); padding: 20px; border-radius: 15px;">
                    <h3 style="margin-bottom: 20px;">My Account</h3>
                    <ul style="display: flex; flex-direction: column; gap: 10px;">
                        <li><a href="#" style="font-weight: 700; color: var(--primary-color);">Dashboard</a></li>
                        <li><a href="#">My Orders</a></li>
                        <li><a href="#">Profile Settings</a></li>
                        <li><a href="#">Custom Designs</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" style="color: #ef4444;">Logout</a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div style="flex: 3;">
                <div style="background: var(--white); padding: 30px; border-radius: 15px; box-shadow: var(--shadow);">
                    <h2>Welcome back, {{ Auth::user()->name }}!</h2>
                    <p style="color: var(--text-light); margin-bottom: 30px;">From your dashboard you can view your recent orders and manage your account details.</p>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
                        <div style="background: #eff6ff; padding: 20px; border-radius: 12px; border-left: 4px solid var(--primary-color);">
                            <div style="font-size: 0.9rem; color: var(--text-light);">Total Orders</div>
                            <div style="font-size: 1.8rem; font-weight: 800;">0</div>
                        </div>
                        <div style="background: #fef2f2; padding: 20px; border-radius: 12px; border-left: 4px solid #ef4444;">
                            <div style="font-size: 0.9rem; color: var(--text-light);">Active Designs</div>
                            <div style="font-size: 1.8rem; font-weight: 800;">0</div>
                        </div>
                    </div>

                    <h3>Recent Orders</h3>
                    <div style="text-align: center; padding: 40px; color: var(--text-light); background: var(--bg-alt); border-radius: 12px; margin-top: 20px;">
                        No orders found yet. <a href="{{ route('products.index') }}" style="color: var(--primary-color); font-weight: 600;">Browse Products</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
