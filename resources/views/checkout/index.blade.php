@extends('layouts.frontend')

@section('title', 'Checkout - Tunicart')

@section('content')
<section class="section">
    <div class="container">
        <h1 style="margin-bottom: 45px; font-weight: 900; font-size: 2.5rem;">Secure <span style="color: var(--secondary-color);">Checkout</span></h1>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 50px;">
            <!-- Shipping Form -->
            <div>
                <h2 style="margin-bottom: 30px; font-size: 1.6rem; font-weight: 800; display: flex; align-items: center; gap: 12px;">
                    <i class="fa-solid fa-truck-fast" style="color: var(--primary-color);"></i> Shipping Details
                </h2>
                <form action="{{ route('checkout.payment') }}" method="POST" class="glass" style="padding: 40px; border-radius: 24px; border: 1px solid var(--glass-border);">
                    @csrf
                    <div style="margin-bottom: 25px;">
                        <label style="display: block; margin-bottom: 10px; font-weight: 600; font-size: 0.9rem; color: var(--text-light);">Phone Number</label>
                        <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}" 
                            style="width: 100%; padding: 14px; border-radius: 12px; border: 1px solid var(--glass-border); background: #fff; color: var(--black); outline: none; transition: var(--transition);" 
                            placeholder="+91 00000 00000" required>
                    </div>
                    <div style="margin-bottom: 25px;">
                        <label style="display: block; margin-bottom: 10px; font-weight: 600; font-size: 0.9rem; color: var(--text-light);">Shipping Address</label>
                        <textarea name="shipping_address" rows="3" 
                            style="width: 100%; padding: 14px; border-radius: 12px; border: 1px solid var(--glass-border); background: #fff; color: var(--black); outline: none; font-family: inherit; transition: var(--transition);" 
                            placeholder="Apt, Street, Area..." required></textarea>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 40px;">
                        <div>
                            <label style="display: block; margin-bottom: 10px; font-weight: 600; font-size: 0.9rem; color: var(--text-light);">City</label>
                            <input type="text" name="city" 
                                style="width: 100%; padding: 14px; border-radius: 12px; border: 1px solid var(--glass-border); background: #fff; color: var(--black); outline: none; transition: var(--transition);" 
                                placeholder="New Delhi" required>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 10px; font-weight: 600; font-size: 0.9rem; color: var(--text-light);">Pincode</label>
                            <input type="text" name="pincode" 
                                style="width: 100%; padding: 14px; border-radius: 12px; border: 1px solid var(--glass-border); background: #fff; color: var(--black); outline: none; transition: var(--transition);" 
                                placeholder="110001" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 18px; border-radius: 15px; font-size: 1.1rem; box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2);">
                        Continue to Payment <i class="fa-solid fa-credit-card" style="margin-left: 10px;"></i>
                    </button>
                </form>
            </div>

            <!-- Order Summary -->
            <div>
                <div class="glass" style="padding: 35px; border-radius: 24px; border: 1px solid var(--glass-border); position: sticky; top: 120px;">
                    <h3 style="margin-bottom: 30px; font-weight: 800; font-size: 1.5rem;">Order Review</h3>
                    <div style="max-height: 400px; overflow-y: auto; padding-right: 10px; margin-bottom: 25px;">
                        @foreach($cart as $id => $item)
                            <div style="display: flex; justify-content: space-between; margin-bottom: 20px; align-items: center;">
                                <div style="display: flex; gap: 15px; align-items: center;">
                                    <img src="{{ asset('storage/' . $item['image']) }}" style="width: 50px; height: 60px; object-fit: cover; border-radius: 8px;">
                                    <div>
                                        <div style="font-weight: 700; font-size: 0.95rem; color: var(--black);">{{ $item['name'] }}</div>
                                        <div style="font-size: 0.8rem; color: var(--text-light);">Qty: {{ $item['quantity'] }}</div>
                                    </div>
                                </div>
                                <span style="font-weight: 700; color: var(--black);">₹{{ $item['price'] * $item['quantity'] }}</span>
                            </div>
                        @endforeach
                    </div>
                    
                    <div style="border-top: 1px solid var(--glass-border); padding-top: 25px; margin-top: 10px;">
                        <div style="margin-bottom: 25px;">
                            <h4 style="margin-bottom: 15px; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-light);">Have a Coupon?</h4>
                            @if(session('applied_coupon'))
                                <div style="display: flex; justify-content: space-between; align-items: center; background: rgba(74, 222, 128, 0.1); padding: 10px 15px; border-radius: 10px; border: 1px solid #4ade80;">
                                    <span style="font-weight: 700; color: #166534;">{{ session('applied_coupon')->code }} Applied</span>
                                    <form action="{{ route('checkout.remove-coupon') }}" method="POST">
                                        @csrf
                                        <button type="submit" style="background: none; border: none; color: #dc2626; cursor: pointer; font-size: 0.8rem; font-weight: 700;">Remove</button>
                                    </form>
                                </div>
                            @else
                                <form action="{{ route('checkout.apply-coupon') }}" method="POST" style="display: flex; gap: 10px;">
                                    @csrf
                                    <input type="text" name="code" placeholder="Enter Code" required style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid var(--glass-border); outline: none;">
                                    <button type="submit" class="btn btn-primary" style="padding: 10px 15px; font-size: 0.8rem;">Apply</button>
                                </form>
                            @endif
                        </div>

                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; color: var(--text-light);">
                            <span>Subtotal</span>
                            <span style="color: var(--black); font-weight: 600;">₹{{ $total }}</span>
                        </div>
                        @if($discount > 0)
                            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; color: #16a34a; font-weight: 600;">
                                <span>Discount</span>
                                <span>-₹{{ $discount }}</span>
                            </div>
                        @endif
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; color: var(--text-light);">
                            <span>Shipping</span>
                            <span style="color: #4ade80; font-weight: 600;">FREE</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-top: 25px; padding-top: 25px; border-top: 2px solid var(--primary-color); font-weight: 900; font-size: 1.5rem;">
                            <span>Total</span>
                            <span style="color: var(--primary-color);">₹{{ $grand_total }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
