@extends('layouts.frontend')

@section('title', 'Your Cart - Tunicart')

@section('content')
<section class="section">
    <div class="container">
        <h1 style="margin-bottom: 40px; font-weight: 900; font-size: 2.5rem;">Shopping <span style="color: var(--secondary-color);">Cart</span></h1>

        @if(session('success'))
            <div class="glass" style="background: rgba(34, 197, 94, 0.1); color: #4ade80; padding: 15px 25px; border-radius: 12px; margin-bottom: 30px; border: 1px solid rgba(34, 197, 94, 0.2); display: flex; align-items: center; gap: 15px;">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(count($cart) > 0)
            <div style="display: flex; gap: 40px; flex-wrap: wrap;">
                <div style="flex: 2; min-width: 400px;">
                    <div class="glass" style="border-radius: 24px; overflow: hidden; border: 1px solid var(--glass-border);">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: rgba(255,255,255,0.03); text-align: left; border-bottom: 1px solid var(--glass-border);">
                                    <th style="padding: 20px; font-weight: 800; color: var(--text-light); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px;">Product</th>
                                    <th style="padding: 20px; font-weight: 800; color: var(--text-light); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px;">Price</th>
                                    <th style="padding: 20px; font-weight: 800; color: var(--text-light); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px;">Qty</th>
                                    <th style="padding: 20px; font-weight: 800; color: var(--text-light); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px;">Subtotal</th>
                                    <th style="padding: 20px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $id => $details)
                                    <tr style="border-bottom: 1px solid var(--glass-border); transition: var(--transition);">
                                        <td style="padding: 20px;">
                                            <div style="display: flex; gap: 20px; align-items: center;">
                                                <div style="position: relative;">
                                                    <img src="{{ asset('storage/' . $details['image']) }}" style="width: 80px; height: 100px; object-fit: cover; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
                                                    @if($details['front_image'] || $details['back_image'])
                                                        <span style="position: absolute; -top: 10px; -left: 10px; font-size: 0.6rem; background: var(--primary-color); color: #fff; padding: 3px 8px; border-radius: 50px; font-weight: 900; text-transform: uppercase; border: 2px solid var(--bg-color);">Custom</span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h4 style="margin-bottom: 5px; font-size: 1.1rem; color: var(--black);">{{ $details['name'] }}</h4>
                                                    <p style="font-size: 0.85rem; color: var(--text-light);">
                                                        @if(isset($details['variants']) && is_array($details['variants']))
                                                            @foreach($details['variants'] as $name => $value)
                                                                {{ $name }}: {{ $value }}{{ !$loop->last ? ' | ' : '' }}
                                                            @endforeach
                                                        @else
                                                            Standard
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 20px; font-weight: 600; color: var(--black);">₹{{ $details['price'] }}</td>
                                        <td style="padding: 20px;">
                                            <div style="display: flex; align-items: center; gap: 10px; background: rgba(255,255,255,0.05); padding: 5px 12px; border-radius: 8px; width: fit-content;">
                                                <span style="font-weight: 700;">{{ $details['quantity'] }}</span>
                                            </div>
                                        </td>
                                        <td style="padding: 20px; font-weight: 800; color: var(--secondary-color);">₹{{ $details['price'] * $details['quantity'] }}</td>
                                        <td style="padding: 20px;">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                <button type="submit" style="background: rgba(239, 68, 68, 0.1); border: none; color: #ef4444; width: 35px; height: 35px; border-radius: 10px; cursor: pointer; transition: var(--transition); display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div style="flex: 1; min-width: 320px;">
                    <div class="glass" style="padding: 35px; border-radius: 24px; border: 1px solid var(--glass-border); position: sticky; top: 100px;">
                        <h3 style="margin-bottom: 25px; font-weight: 800; font-size: 1.5rem;">Summary</h3>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 18px; color: var(--text-light);">
                            <span>Order Subtotal</span>
                            <span style="color: var(--black); font-weight: 600;">₹{{ $total }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 18px; color: var(--text-light);">
                            <span>Shipping (Standard)</span>
                            <span style="color: #4ade80; font-weight: 600;">FREE</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 25px; color: var(--text-light);">
                            <span>Tax (GST 12%)</span>
                            <span style="color: var(--black); font-weight: 600;">Included</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-top: 25px; padding-top: 25px; border-top: 1px solid var(--glass-border); font-weight: 900; font-size: 1.4rem;">
                            <span>Total</span>
                            <span style="color: var(--primary-color);">₹{{ $total }}</span>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary" style="display: block; text-align: center; margin-top: 35px; padding: 18px; border-radius: 15px; font-size: 1rem; box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2);">
                            Checkout Now <i class="fa-solid fa-arrow-right" style="margin-left: 10px;"></i>
                        </a>
                        <div style="text-align: center; margin-top: 20px;">
                            <a href="{{ route('products.index') }}" style="font-size: 0.9rem; color: var(--text-light); font-weight: 600; hover: color: var(--white);">
                                <i class="fa-solid fa-chevron-left" style="font-size: 0.7rem; margin-right: 5px;"></i> Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="glass" style="text-align: center; padding: 100px 40px; border-radius: 30px; border: 1px dashed var(--glass-border);">
                <div style="width: 100px; height: 100px; background: rgba(212, 175, 55, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px; color: var(--primary-color); font-size: 3rem;">
                    <i class="fa-solid fa-cart-arrow-down"></i>
                </div>
                <h2 style="font-weight: 900; margin-bottom: 15px;">Your vault is empty</h2>
                <p style="color: var(--text-light); margin-bottom: 40px; max-width: 400px; margin-inline: auto;">Ready to fill it with custom-engineered apparel? Start your design journey today.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary" style="padding: 15px 40px;">Launch Shop</a>
            </div>
        @endif
    </div>
</section>

@endsection
