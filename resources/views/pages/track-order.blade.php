@extends('layouts.frontend')

@section('title', 'Track Your Order - Tunicart')

@section('content')
<section class="section bg-pattern">
    <div class="container">
        <div class="glass" style="max-width: 650px; margin: 0 auto; padding: 60px 40px; border-radius: 40px; border: 1px solid var(--glass-border); text-align: center; box-shadow: var(--shadow-lg);">
            <i class="fa-solid fa-truck-fast" style="font-size: 3.5rem; color: var(--accent-color); margin-bottom: 25px; filter: drop-shadow(0 0 15px var(--accent-glow));"></i>
            <h1 style="margin-bottom: 12px; font-weight: 900; font-size: 2.5rem; letter-spacing: -1px;">Track <span style="color: var(--accent-color);">Order</span></h1>
            <p style="color: var(--text-light); margin-bottom: 40px; font-size: 1.1rem;">Enter your Order Reference ID to manifest its current location.</p>
            
            <form action="{{ route('track-order') }}" method="GET" style="margin-bottom: 20px;">
                <input type="text" name="order_id" placeholder="Reference ID (e.g. 1)" style="width: 100%; padding: 18px; border-radius: 15px; border: 1px solid var(--glass-border); margin-bottom: 25px; outline: none; background: #fff; font-weight: 700; font-size: 1.1rem; color: var(--black); text-align: center; box-shadow: var(--shadow);" required>
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 18px; border-radius: 15px; font-size: 1.1rem; font-weight: 900; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); box-shadow: 0 10px 20px var(--accent-glow);">Initialize Search <i class="fa-solid fa-satellite-dish" style="margin-left: 10px;"></i></button>
            </form>

            @if(request()->has('order_id'))
                @if($order)
                    <div style="margin-top: 50px; border-top: 1px solid #eee; pt: 30px; text-align: left;">
                        <h3 style="margin-bottom: 20px;">Order Status: <span style="color: var(--primary-color);">{{ strtoupper($order->status) }}</span></h3>
                        
                        <!-- Progress Bar -->
                        <div style="display: flex; justify-content: space-between; margin-bottom: 20px; position: relative; padding-top: 10px;">
                            <div style="width: 100%; height: 6px; background: var(--glass-border); position: absolute; top: 20px; left: 0; z-index: 1; border-radius: 10px;"></div>
                            <div style="width: {{ $order->status == 'delivered' ? '100%' : ($order->status == 'shipped' ? '66%' : ($order->status == 'processing' ? '33%' : '0%')) }}; height: 6px; background: var(--accent-color); position: absolute; top: 20px; left: 0; z-index: 2; transition: 1.5s cubic-bezier(0.23, 1, 0.32, 1); border-radius: 10px; box-shadow: 0 0 15px var(--accent-glow);"></div>
                            
                            @php $stages = ['Pending', 'Processing', 'Shipped', 'Delivered']; @endphp
                            @foreach($stages as $index => $stage)
                                <div style="z-index: 3; text-align: center;">
                                    <div style="width: 20px; height: 20px; background: {{ ($index * 33) <= ($order->status == 'delivered' ? 100 : ($order->status == 'shipped' ? 66 : ($order->status == 'processing' ? 33 : 0))) ? 'var(--accent-color)' : '#eee' }}; border: 4px solid #fff; border-radius: 50%; margin: 0 auto 8px; box-shadow: var(--shadow);"></div>
                                    <span style="font-size: 0.75rem; font-weight: 800; color: {{ ($index * 33) <= ($order->status == 'delivered' ? 100 : ($order->status == 'shipped' ? 66 : ($order->status == 'processing' ? 33 : 0))) ? 'var(--black)' : 'var(--text-light)' }}; text-transform: uppercase; letter-spacing: 0.5px;">{{ $stage }}</span>
                                </div>
                            @endforeach
                        </div>
                        
                        <div style="background: var(--bg-alt); padding: 25px; border-radius: 20px; margin-top: 40px; border: 1px solid var(--glass-border); display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 20px;">
                            <div>
                                <span style="font-size: 0.7rem; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px;">Order Reference</span>
                                <p style="font-weight: 900; font-size: 1.1rem; color: var(--black); margin-top: 5px;">#{{ $order->id }}</p>
                            </div>
                            <div>
                                <span style="font-size: 0.7rem; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px;">Amount Manifested</span>
                                <p style="font-weight: 900; font-size: 1.1rem; color: var(--black); margin-top: 5px;">₹{{ $order->total_amount }}</p>
                            </div>
                            <div>
                                <span style="font-size: 0.7rem; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px;">Initialization Date</span>
                                <p style="font-weight: 900; font-size: 1.1rem; color: var(--black); margin-top: 5px;">{{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <h4 style="margin-top: 30px; margin-bottom: 15px;">Items in this order:</h4>
                        <div style="display: flex; flex-direction: column; gap: 20px;">
                            @foreach($order->items as $item)
                                <div style="display: flex; gap: 20px; background: #fff; padding: 20px; border-radius: 20px; border: 1px solid var(--glass-border); box-shadow: var(--shadow);">
                                    <img src="{{ asset('storage/'.$item->product->image) }}" style="width: 80px; height: 100px; border-radius: 12px; object-fit: cover; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                                    <div style="flex: 1;">
                                        <div style="font-weight: 900; font-size: 1.1rem; color: var(--black);">{{ $item->product->name }}</div>
                                        <div style="font-size: 0.9rem; color: var(--text-light); margin-top: 4px; font-weight: 600;">Qty: <span style="color: var(--black);">{{ $item->quantity }}</span> • Value: <span style="color: var(--black);">₹{{ $item->price }}</span></div>
                                        
                                        @if($item->variant_details)
                                            @php $variants = json_decode($item->variant_details, true); @endphp
                                            <div style="display: flex; gap: 10px; margin-top: 10px; flex-wrap: wrap;">
                                                @foreach($variants as $key => $val)
                                                    <span style="font-size: 0.7rem; background: rgba(var(--primary-rgb), 0.05); padding: 4px 12px; border-radius: 50px; border: 1px solid var(--glass-border); font-weight: 800; color: var(--primary-color); text-transform: uppercase;">
                                                        {{ $key }}: {{ $val }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif

                                        @if($item->front_image || $item->back_image)
                                            <div style="display: flex; gap: 10px; margin-top: 10px;">
                                                @if($item->front_image)
                                                    <a href="{{ asset('storage/'.$item->front_image) }}" target="_blank" style="font-size: 0.7rem; color: var(--primary-color);">[Front Design]</a>
                                                @endif
                                                @if($item->back_image)
                                                    <a href="{{ asset('storage/'.$item->back_image) }}" target="_blank" style="font-size: 0.7rem; color: var(--primary-color);">[Back Design]</a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
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
