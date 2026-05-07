@extends('layouts.frontend')

@section('title', 'Track Your Order - Tunicart')

@section('content')
<section class="section bg-pattern">
    <div class="container">
        <div style="max-width: 600px; margin: 0 auto; background: var(--white); padding: 50px; border-radius: 20px; box-shadow: var(--shadow-lg); text-align: center;">
            <i class="fa-solid fa-truck-fast" style="font-size: 3rem; color: var(--primary-color); margin-bottom: 20px;"></i>
            <h1 style="margin-bottom: 10px;">Track Your Order</h1>
            <p style="color: var(--text-light); margin-bottom: 30px;">Enter your Order ID to get the latest status.</p>
            
            <form action="{{ route('track-order') }}" method="GET">
                <input type="text" name="order_id" placeholder="Order ID (e.g. 1)" style="width: 100%; padding: 15px; border-radius: 10px; border: 1px solid #ddd; margin-bottom: 20px;" required>
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px;">Track Status</button>
            </form>

            @if(request()->has('order_id'))
                @if($order)
                    <div style="margin-top: 50px; border-top: 1px solid #eee; pt: 30px; text-align: left;">
                        <h3 style="margin-bottom: 20px;">Order Status: <span style="color: var(--primary-color);">{{ strtoupper($order->status) }}</span></h3>
                        
                        <!-- Progress Bar -->
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; position: relative;">
                            <div style="width: 100%; height: 8px; background: #eee; position: absolute; top: 10px; left: 0; z-index: 1;"></div>
                            <div style="width: {{ $order->status == 'delivered' ? '100%' : ($order->status == 'shipped' ? '66%' : ($order->status == 'processing' ? '33%' : '0%')) }}; height: 8px; background: var(--primary-color); position: absolute; top: 10px; left: 0; z-index: 2; transition: 1s;"></div>
                            
                            @php $stages = ['Pending', 'Processing', 'Shipped', 'Delivered']; @endphp
                            @foreach($stages as $index => $stage)
                                <div style="z-index: 3; text-align: center;">
                                    <div style="width: 25px; height: 25px; background: {{ ($index * 33) <= ($order->status == 'delivered' ? 100 : ($order->status == 'shipped' ? 66 : ($order->status == 'processing' ? 33 : 0))) ? 'var(--primary-color)' : '#eee' }}; border-radius: 50%; margin: 0 auto 5px;"></div>
                                    <span style="font-size: 0.7rem; font-weight: 700;">{{ $stage }}</span>
                                </div>
                            @endforeach
                        </div>
                        
                        <div style="background: var(--bg-alt); padding: 20px; border-radius: 15px; margin-top: 40px;">
                            <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                            <p><strong>Total Amount:</strong> ₹{{ $order->total_amount }}</p>
                            <p><strong>Items:</strong> {{ $order->items->count() }}</p>
                        </div>
                    </div>
                @else
                    <div style="margin-top: 30px; color: #ef4444; font-weight: 700;">
                        No order found with that ID. Please check and try again.
                    </div>
                @endif
            @endif
        </div>
    </div>
</section>
@endsection
