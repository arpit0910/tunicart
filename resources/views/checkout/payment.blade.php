@extends('layouts.frontend')

@section('title', 'Pay via UPI - Tunicart')

@section('content')
<section class="section">
    <div class="container" style="max-width: 650px; text-align: center;">
        <h1 style="margin-bottom: 20px; font-weight: 900; font-size: 2.2rem;">Complete <span style="color: var(--secondary-color);">Payment</span></h1>
        <p style="color: var(--text-light); margin-bottom: 40px; line-height: 1.6;">Scan the secure QR code below using any UPI app (GPay, PhonePe, Paytm) to finalize your masterwork order.</p>
        
        <div class="glass" style="padding: 50px 40px; border-radius: 40px; border: 1px solid var(--glass-border); position: relative; overflow: hidden;">
            <!-- Glow Effect -->
            <div style="position: absolute; top: -50px; left: -50px; width: 150px; height: 150px; background: var(--primary-color); filter: blur(70px); opacity: 0.1; z-index: 0;"></div>

            <div style="margin-bottom: 40px; position: relative; z-index: 1;">
                <span style="font-size: 0.8rem; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 2px;">Total Payable</span>
                <div style="font-size: 3.5rem; font-weight: 900; color: var(--black); margin-top: 5px; text-shadow: 0 0 30px var(--accent-glow);">₹{{ $grand_total }}</div>
            </div>

            <!-- QR Code Section -->
            <div style="position: relative; z-index: 1; margin-bottom: 40px;">
                <div style="width: 280px; height: 280px; margin: 0 auto; padding: 25px; border: 2px solid var(--glass-border); border-radius: 30px; background: #fff; box-shadow: 0 0 50px rgba(0,0,0,0.3); transition: var(--transition);" class="qr-container">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=230x230&data=upi://pay?pa=tunicart@upi%26pn=Tunicart%26am={{ $grand_total }}%26cu=INR" alt="UPI QR Code" style="width: 100%; border-radius: 10px;">
                </div>
                <div style="margin-top: 20px;">
                    <p style="font-weight: 800; color: var(--black); font-size: 1.1rem; letter-spacing: 0.5px;">UPI ID: <span style="color: var(--secondary-color);">tunicart@upi</span></p>
                    <p style="font-size: 0.85rem; color: var(--text-light); margin-top: 5px;">Verified Merchant: Tunicart Apparel India</p>
                </div>
            </div>

            <form action="{{ route('order.place') }}" method="POST" style="position: relative; z-index: 1;">
                @csrf
                <div style="margin-bottom: 25px; text-align: left;">
                    <label style="display: block; margin-bottom: 12px; font-weight: 700; color: var(--text-color); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">Transaction ID / UTR Number</label>
                    <input type="text" name="transaction_id" placeholder="12-digit UPI Ref No. (e.g. 123456...)" 
                        style="width: 100%; padding: 18px; border-radius: 15px; border: 2px solid var(--accent-color); background: #fff; color: var(--black); font-size: 1.1rem; font-weight: 700; outline: none; box-shadow: var(--shadow);" required>
                    <div style="display: flex; align-items: center; gap: 8px; margin-top: 10px; color: var(--text-light);">
                        <i class="fa-solid fa-circle-info" style="font-size: 0.8rem;"></i>
                        <small style="font-size: 0.8rem;">Required for payment verification.</small>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 20px; font-size: 1.1rem; font-weight: 900; border-radius: 15px; letter-spacing: 1px; box-shadow: 0 15px 30px rgba(212, 175, 55, 0.3);">
                    Confirm & Place Order <i class="fa-solid fa-check-double" style="margin-left: 10px;"></i>
                </button>
            </form>
        </div>

        <div style="margin-top: 40px; display: flex; justify-content: center; gap: 30px; opacity: 0.5; align-items: center;">
            <img src="https://upload.wikimedia.org/wikipedia/commons/e/e1/UPI-Logo-vector.svg" style="height: 25px; filter: contrast(0);">
            <i class="fa-brands fa-google-pay" style="font-size: 2.5rem; color: var(--black);"></i>
            <i class="fa-brands fa-apple-pay" style="font-size: 2.5rem; color: var(--black);"></i>
        </div>
    </div>
</section>

<style>
    .qr-container:hover {
        transform: scale(1.03);
        box-shadow: 0 0 60px rgba(212, 175, 55, 0.4);
    }
</style>

@endsection
