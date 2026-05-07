@extends('layouts.frontend')

@section('title', 'Your Cart - Tunicart')

@section('content')
<section class="section">
    <div class="container">
        <h1 style="margin-bottom: 40px;">Shopping Cart</h1>

        @if(session('success'))
            <div style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 10px; margin-bottom: 30px;">
                {{ session('success') }}
            </div>
        @endif

        @if(count($cart) > 0)
            <div style="display: flex; gap: 40px; flex-wrap: wrap;">
                <div style="flex: 2; min-width: 400px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--bg-alt); text-align: left;">
                                <th style="padding: 15px 0;">Product</th>
                                <th style="padding: 15px 0;">Price</th>
                                <th style="padding: 15px 0;">Quantity</th>
                                <th style="padding: 15px 0;">Subtotal</th>
                                <th style="padding: 15px 0;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $id => $details)
                                <tr style="border-bottom: 1px solid var(--bg-alt);">
                                    <td style="padding: 20px 0;">
                                        <div style="display: flex; gap: 20px; align-items: center;">
                                            <img src="{{ asset('storage/' . $details['image']) }}" style="width: 80px; height: 100px; object-fit: cover; border-radius: 10px;">
                                            <div>
                                                <h4 style="margin-bottom: 5px;">{{ $details['name'] }}</h4>
                                                @if($details['front_image'] || $details['back_image'])
                                                    <span style="font-size: 0.8rem; background: #e0e7ff; color: #3730a3; padding: 2px 8px; border-radius: 4px;">Customized</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 20px 0;">₹{{ $details['price'] }}</td>
                                    <td style="padding: 20px 0;">{{ $details['quantity'] }}</td>
                                    <td style="padding: 20px 0;">₹{{ $details['price'] * $details['quantity'] }}</td>
                                    <td style="padding: 20px 0;">
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf
                                            <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer;"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="flex: 1; min-width: 300px;">
                    <div style="background: var(--bg-alt); padding: 30px; border-radius: 20px;">
                        <h3 style="margin-bottom: 20px;">Order Summary</h3>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                            <span>Subtotal</span>
                            <span>₹{{ $total }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                            <span>Shipping</span>
                            <span>Free</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-top: 20px; padding-top: 20px; border-top: 1px solid #cbd5e1; font-weight: 800; font-size: 1.2rem;">
                            <span>Total</span>
                            <span>₹{{ $total }}</span>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary" style="display: block; text-align: center; margin-top: 30px; padding: 15px;">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        @else
            <div style="text-align: center; padding: 50px 0;">
                <i class="fa-solid fa-cart-shopping" style="font-size: 4rem; color: #cbd5e1; margin-bottom: 20px;"></i>
                <h2>Your cart is empty</h2>
                <p style="color: var(--text-light); margin-bottom: 30px;">Looks like you haven't added anything to your cart yet.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Start Shopping</a>
            </div>
        @endif
    </div>
</section>
@endsection
