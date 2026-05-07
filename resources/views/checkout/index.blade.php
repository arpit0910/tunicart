@extends('layouts.frontend')

@section('title', 'Checkout - Tunicart')

@section('content')
<section class="section">
    <div class="container">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 50px;">
            <!-- Shipping Form -->
            <div>
                <h2 style="margin-bottom: 30px;">Shipping Details</h2>
                <form action="{{ route('checkout.payment') }}" method="POST" style="background: #fff; padding: 40px; border-radius: 20px; box-shadow: var(--shadow);">
                    @csrf
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Phone Number</label>
                        <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ddd;" required>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Shipping Address</label>
                        <textarea name="shipping_address" rows="3" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ddd; font-family: inherit;" required></textarea>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600;">City</label>
                            <input type="text" name="city" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ddd;" required>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Pincode</label>
                            <input type="text" name="pincode" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ddd;" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px;">Continue to Payment</button>
                </form>
            </div>

            <!-- Order Summary -->
            <div>
                <div style="background: var(--bg-alt); padding: 30px; border-radius: 20px;">
                    <h3 style="margin-bottom: 20px;">Order Summary</h3>
                    @foreach($cart as $id => $item)
                        <div style="display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 0.9rem;">
                            <span>{{ $item['name'] }} x {{ $item['quantity'] }}</span>
                            <span>₹{{ $item['price'] * $item['quantity'] }}</span>
                        </div>
                    @endforeach
                    <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">
                    <div style="display: flex; justify-content: space-between; font-weight: 800; font-size: 1.2rem;">
                        <span>Total</span>
                        <span>₹{{ $total }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
