@extends('layouts.frontend')

@section('title', 'Order Success - Tunicart')

@section('content')
<section class="section">
    <div class="container" style="max-width: 700px; text-align: center;">
        <div class="glass" style="padding: 80px 40px; border-radius: 40px; border: 1px solid var(--glass-border); position: relative; overflow: hidden;">
            <!-- Celebration Background Glow -->
            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at 50% 50%, rgba(34, 197, 94, 0.05) 0%, transparent 70%); z-index: 0;"></div>

            <div style="width: 110px; height: 110px; background: rgba(34, 197, 94, 0.1); color: #4ade80; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 35px; font-size: 3.5rem; border: 2px solid rgba(34, 197, 94, 0.2); box-shadow: 0 0 40px rgba(34, 197, 94, 0.2); position: relative; z-index: 1;">
                <i class="fa-solid fa-check"></i>
            </div>
            
            <h1 style="margin-bottom: 15px; font-weight: 900; font-size: 2.5rem; position: relative; z-index: 1;">Order <span style="color: #4ade80;">Confirmed</span>!</h1>
            <p style="color: var(--text-light); margin-bottom: 40px; font-size: 1.1rem; line-height: 1.6; position: relative; z-index: 1;">Your masterwork has been scheduled for production. Our engineers are currently verifying your payment sequence.</p>
            
            <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--glass-border); padding: 30px; border-radius: 20px; text-align: left; margin-bottom: 45px; position: relative; z-index: 1;">
                <h3 style="font-size: 1rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-light); margin-bottom: 20px; border-bottom: 1px solid var(--glass-border); padding-bottom: 10px;">Order Manifesto</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <span style="display: block; font-size: 0.8rem; color: var(--text-light);">Reference ID</span>
                        <span style="font-weight: 800; color: #fff;">#{{ $order->id }}</span>
                    </div>
                    <div>
                        <span style="display: block; font-size: 0.8rem; color: var(--text-light);">Payment Ref</span>
                        <span style="font-weight: 800; color: #fff;">{{ $order->transaction_id }}</span>
                    </div>
                    <div>
                        <span style="display: block; font-size: 0.8rem; color: var(--text-light);">Total Credits</span>
                        <span style="font-weight: 800; color: var(--primary-color);">₹{{ $order->total_amount }}</span>
                    </div>
                    <div>
                        <span style="display: block; font-size: 0.8rem; color: var(--text-light);">Destination</span>
                        <span style="font-weight: 800; color: #fff;">{{ $order->city }}</span>
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 20px; position: relative; z-index: 1; flex-wrap: wrap;">
                <a href="{{ route('track-order', ['order_id' => $order->id]) }}" class="btn btn-primary" style="flex: 1; padding: 20px; border-radius: 15px; font-size: 1rem; min-width: 200px;">
                    Track Expedition <i class="fa-solid fa-location-dot" style="margin-left: 10px;"></i>
                </a>
                <a href="{{ route('home') }}" class="btn" style="flex: 1; border: 1px solid var(--glass-border); padding: 20px; border-radius: 15px; font-size: 1rem; color: #fff; background: rgba(255,255,255,0.05); min-width: 200px;">
                    Return to Base
                </a>
            </div>
        </div>
        
        <p style="margin-top: 30px; color: var(--text-light); font-size: 0.9rem;">
            A confirmation receipt has been transmitted to your registered neural-link (email).
        </p>
    </div>
</section>

@endsection
