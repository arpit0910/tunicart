@extends('layouts.frontend')

@section('title', 'Pay Order - Tunicart')

@section('content')
<section class="section">
    <div class="container" style="max-width: 650px; text-align: center;">
        <h1 style="margin-bottom: 20px; font-weight: 900; font-size: 2.2rem;">Complete <span style="color: var(--secondary-color);">Payment</span></h1>
        <p style="color: var(--text-light); margin-bottom: 40px; line-height: 1.6;">Select your preferred payment method below to transfer the funds, then enter your transaction ID to complete your order.</p>
        
        <div class="glass" style="padding: 40px 30px; border-radius: 40px; border: 1px solid var(--glass-border); position: relative; overflow: hidden; margin-bottom: 30px;">
            <!-- Glow Effect -->
            <div style="position: absolute; top: -50px; left: -50px; width: 150px; height: 150px; background: var(--primary-color); filter: blur(70px); opacity: 0.1; z-index: 0;"></div>

            <div style="margin-bottom: 30px; position: relative; z-index: 1;">
                <span style="font-size: 0.8rem; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 2px;">Total Payable</span>
                <div style="font-size: 3.2rem; font-weight: 900; color: var(--black); margin-top: 5px; text-shadow: 0 0 30px var(--accent-glow);">₹{{ $grand_total }}</div>
            </div>

            <!-- Payment Method Tabs -->
            <div style="display: flex; gap: 15px; margin-bottom: 35px; justify-content: center; position: relative; z-index: 1;">
                <button type="button" class="tab-btn active" onclick="switchTab('upi')" style="flex: 1; padding: 15px; border-radius: 15px; border: 2px solid var(--glass-border); background: rgba(255,255,255,0.05); color: var(--text-light); font-weight: 700; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fa-solid fa-qrcode" style="font-size: 1.1rem;"></i> UPI QR Code
                </button>
                <button type="button" class="tab-btn" onclick="switchTab('bank')" style="flex: 1; padding: 15px; border-radius: 15px; border: 2px solid var(--glass-border); background: rgba(255,255,255,0.05); color: var(--text-light); font-weight: 700; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fa-solid fa-building-columns" style="font-size: 1.1rem;"></i> Bank Transfer
                </button>
            </div>

            <!-- UPI Payment Tab Content -->
            <div id="upi-content" class="payment-tab-content" style="position: relative; z-index: 1; margin-bottom: 35px;">
                <div style="width: 260px; height: 260px; margin: 0 auto 25px; padding: 20px; border: 2px solid var(--glass-border); border-radius: 30px; background: #fff; box-shadow: 0 0 40px rgba(0,0,0,0.05); transition: 0.3s;" class="qr-container">
                    @if($settings->upi_qr_code)
                        <img src="{{ asset('storage/' . $settings->upi_qr_code) }}" alt="UPI QR Code" style="width: 100%; height: 100%; object-fit: contain; border-radius: 10px;">
                    @else
                        @php
                            $upiUri = "upi://pay?pa=" . $settings->upi_id . "&pn=" . rawurlencode($settings->account_holder) . "&am=" . $grand_total . "&cu=INR";
                            $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=" . urlencode($upiUri);
                        @endphp
                        <img src="{{ $qrCodeUrl }}" alt="UPI QR Code" style="width: 100%; height: 100%; border-radius: 10px;">
                    @endif
                </div>
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 10px; background: rgba(255,255,255,0.08); padding: 8px 18px; border-radius: 30px; border: 1px solid var(--glass-border); margin-bottom: 10px;">
                        <span style="font-weight: 800; color: var(--black); font-size: 1.05rem;">UPI ID: <span style="color: var(--secondary-color);">{{ $settings->upi_id }}</span></span>
                        <button type="button" id="copy-upi-btn" onclick="copyToClipboard('{{ $settings->upi_id }}', 'copy-upi-btn')" style="border: none; background: var(--secondary-color); color: #fff; border-radius: 50%; width: 26px; height: 26px; font-size: 0.8rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.2s;"><i class="fa-solid fa-copy"></i></button>
                    </div>
                    <p style="font-size: 0.85rem; color: var(--text-light);">Verified Merchant: {{ $settings->account_holder }}</p>
                </div>
            </div>

            <!-- Bank Transfer Tab Content -->
            <div id="bank-content" class="payment-tab-content" style="position: relative; z-index: 1; margin-bottom: 35px; display: none;">
                @if($settings->bank_name && $settings->account_number)
                    <div style="background: rgba(255, 255, 255, 0.04); border: 1px solid var(--glass-border); border-radius: 20px; padding: 25px; text-align: left; max-width: 480px; margin: 0 auto;">
                        <div style="margin-bottom: 15px;">
                            <label style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-light); display: block; font-weight: 700; margin-bottom: 4px;">Bank Name</label>
                            <div style="font-weight: 800; font-size: 1.1rem; color: var(--black);">{{ $settings->bank_name }}</div>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-light); display: block; font-weight: 700; margin-bottom: 4px;">Account Holder</label>
                            <div style="font-weight: 800; font-size: 1.1rem; color: var(--black);">{{ $settings->account_holder }}</div>
                        </div>
                        <div style="margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <label style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-light); display: block; font-weight: 700; margin-bottom: 4px;">Account Number</label>
                                <div style="font-weight: 800; font-size: 1.1rem; color: var(--black);">{{ $settings->account_number }}</div>
                            </div>
                            <button type="button" id="copy-acc-btn" onclick="copyToClipboard('{{ $settings->account_number }}', 'copy-acc-btn')" class="btn-copy"><i class="fa-solid fa-copy"></i> Copy</button>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <label style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-light); display: block; font-weight: 700; margin-bottom: 4px;">IFSC Code</label>
                                <div style="font-weight: 800; font-size: 1.1rem; color: var(--black);">{{ $settings->ifsc_code }}</div>
                            </div>
                            <button type="button" id="copy-ifsc-btn" onclick="copyToClipboard('{{ $settings->ifsc_code }}', 'copy-ifsc-btn')" class="btn-copy"><i class="fa-solid fa-copy"></i> Copy</button>
                        </div>
                    </div>
                @else
                    <div style="padding: 30px; text-align: center; color: var(--text-light);">
                        <i class="fa-solid fa-triangle-exclamation" style="font-size: 2rem; color: #dc3545; margin-bottom: 15px;"></i>
                        <p style="font-weight: 700;">Bank Details Unconfigured</p>
                        <p style="font-size: 0.85rem; margin-top: 5px;">Bank transfer is currently unavailable. Please complete your transaction using UPI.</p>
                    </div>
                @endif
            </div>

            <!-- Transaction Form -->
            <form action="{{ route('order.place') }}" method="POST" style="position: relative; z-index: 1;">
                @csrf
                <div style="margin-bottom: 25px; text-align: left;">
                    <label style="display: block; margin-bottom: 12px; font-weight: 700; color: var(--text-color); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">Transaction ID / UTR Number</label>
                    <input type="text" name="transaction_id" placeholder="12-digit Ref No. (e.g. 123456...)" 
                        style="width: 100%; padding: 18px; border-radius: 15px; border: 2px solid var(--accent-color); background: #fff; color: var(--black); font-size: 1.1rem; font-weight: 700; outline: none; box-shadow: var(--shadow);" required>
                    <div style="display: flex; align-items: center; gap: 8px; margin-top: 10px; color: var(--text-light);">
                        <i class="fa-solid fa-circle-info" style="font-size: 0.8rem;"></i>
                        <small style="font-size: 0.8rem;">Provide the transaction reference to allow admin approval.</small>
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
        box-shadow: 0 0 50px rgba(212, 175, 55, 0.2);
    }
    .tab-btn.active {
        border-color: var(--secondary-color) !important;
        background: var(--secondary-color) !important;
        color: #fff !important;
    }
    .tab-btn:hover {
        border-color: var(--secondary-color);
        color: var(--black);
    }
    .tab-btn.active:hover {
        color: #fff;
    }
    .btn-copy {
        background: var(--secondary-color);
        color: #fff;
        border: none;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
    }
    .btn-copy:hover {
        background: var(--primary-color);
    }
</style>

<script>
    function switchTab(type) {
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.payment-tab-content').forEach(content => content.style.display = 'none');
        
        if (type === 'upi') {
            document.querySelector('.tab-btn:first-child').classList.add('active');
            document.getElementById('upi-content').style.display = 'block';
        } else {
            document.querySelector('.tab-btn:last-child').classList.add('active');
            document.getElementById('bank-content').style.display = 'block';
        }
    }

    function copyToClipboard(text, elementId) {
        navigator.clipboard.writeText(text).then(() => {
            const btn = document.getElementById(elementId);
            const origText = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-check"></i> Copied!';
            btn.style.background = '#28a745';
            btn.style.color = '#fff';
            setTimeout(() => {
                btn.innerHTML = origText;
                btn.style.background = '';
                btn.style.color = '';
            }, 1500);
        }).catch(err => {
            console.error('Failed to copy: ', err);
        });
    }
</script>

@endsection
