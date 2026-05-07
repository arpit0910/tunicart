@extends('layouts.frontend')

@section('title', 'Order Success - Tunicart')

@section('content')
<section class="section">
    <div class="container" style="max-width: 600px; text-align: center;">
        <div style="background: #fff; padding: 60px; border-radius: 30px; box-shadow: var(--shadow-lg);">
            <div style="width: 100px; height: 100px; background: #dcfce7; color: #166534; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px; font-size: 3rem;">
                <i class="fa-solid fa-check"></i>
            </div>
            <h1 style="margin-bottom: 10px;">Order Placed Successfully!</h1>
            <p style="color: var(--text-light); margin-bottom: 30px;">Thank you for your order. We are currently verifying your payment. You will receive a confirmation email shortly.</p>
            
            <div style="background: var(--bg-alt); padding: 25px; border-radius: 15px; text-align: left; margin-bottom: 30px;">
                <p style="margin-bottom: 10px;"><strong>Order ID:</strong> #{{ $order->id }}</p>
                <p style="margin-bottom: 10px;"><strong>Transaction ID:</strong> {{ $order->transaction_id }}</p>
                <p style="margin-bottom: 10px;"><strong>Total Amount:</strong> ₹{{ $order->total_amount }}</p>
                <p><strong>Shipping to:</strong> {{ $order->city }}</p>
            </div>

            <div style="display: flex; gap: 20px;">
                <a href="{{ route('track-order', ['order_id' => $order->id]) }}" class="btn btn-primary" style="flex: 1; padding: 15px;">Track Order</a>
                <a href="{{ route('home') }}" class="btn" style="flex: 1; border: 1px solid #ddd; padding: 15px;">Back to Home</a>
            </div>
        </div>
    </div>
</section>
@endsection
