@extends('layouts.frontend')

@section('title', 'Pay via UPI - Tunicart')

@section('content')
<section class="section">
    <div class="container" style="max-width: 600px; text-align: center;">
        <h2 style="margin-bottom: 20px;">Complete Your Payment</h2>
        <p style="color: var(--text-light); margin-bottom: 30px;">Scan the QR code below using any UPI app (GPay, PhonePe, Paytm) and enter the Transaction ID to place your order.</p>
        
        <div style="background: #fff; padding: 40px; border-radius: 30px; box-shadow: var(--shadow-lg); border: 1px solid #eee;">
            <div style="margin-bottom: 30px;">
                <span style="font-size: 0.9rem; font-weight: 700; color: var(--text-light); text-transform: uppercase;">Amount to Pay</span>
                <div style="font-size: 3rem; font-weight: 900; color: var(--primary-color);">₹{{ $total }}</div>
            </div>

            <!-- Simulated QR Code -->
            <div style="width: 250px; height: 250px; margin: 0 auto 30px; padding: 20px; border: 1px solid #ddd; border-radius: 20px; background: #fafafa; display: flex; align-items: center; justify-content: center;">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=upi://pay?pa=tunicart@upi%26pn=Tunicart%26am={{ $total }}%26cu=INR" alt="UPI QR Code" style="width: 100%;">
            </div>

            <div style="margin-bottom: 30px;">
                <p style="font-weight: 700; margin-bottom: 5px;">UPI ID: <span style="color: var(--primary-color);">tunicart@upi</span></p>
                <p style="font-size: 0.8rem; color: var(--text-light);">Merchant: Tunicart Apparel India</p>
            </div>

            <form action="{{ route('order.place') }}" method="POST">
                @csrf
                <div style="margin-bottom: 20px; text-align: left;">
                    <label style="display: block; margin-bottom: 10px; font-weight: 600;">Transaction ID / UTR Number</label>
                    <input type="text" name="transaction_id" placeholder="12-digit UPI Ref No." style="width: 100%; padding: 15px; border-radius: 10px; border: 2px solid var(--primary-color); font-size: 1.1rem;" required>
                    <small style="color: var(--text-light); display: block; margin-top: 5px;">You can find this in your payment app history.</small>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 18px; font-size: 1.1rem; font-weight: 800;">Verify & Place Order</button>
            </form>
        </div>

        <div style="margin-top: 30px; display: flex; justify-content: center; gap: 20px; opacity: 0.6;">
            <i class="fa-brands fa-google-pay" style="font-size: 2rem;"></i>
            <i class="fa-solid fa-p" style="font-size: 2rem;"></i> <!-- PhonePe Placeholder -->
            <i class="fa-solid fa-wallet" style="font-size: 2rem;"></i>
        </div>
    </div>
</section>
@endsection
