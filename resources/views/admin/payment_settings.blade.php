@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Payment Settings</h1>
</div>

<form action="{{ route('admin.payment-settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
        <!-- UPI Payment Card -->
        <div class="admin-card">
            <h2 style="font-weight: 800; font-size: 1.5rem; margin-bottom: 25px; color: var(--primary-color); display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-qrcode"></i> UPI Configurations
            </h2>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">UPI ID</label>
                <input type="text" name="upi_id" class="form-control" value="{{ old('upi_id', $settings->upi_id) }}" placeholder="e.g. merchant@upi">
                <small style="color: var(--text-light); margin-top: 5px; display: block;">If no QR code is uploaded, this UPI ID will be used to generate a dynamic code on checkout.</small>
            </div>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">UPI QR Code Image</label>
                @if($settings->upi_qr_code)
                    <div style="margin-bottom: 15px; padding: 15px; border: 1px solid #f1f1f1; border-radius: 12px; display: inline-block; background: #fafafa; text-align: center;">
                        <img src="{{ asset('storage/' . $settings->upi_qr_code) }}" style="max-height: 150px; border-radius: 8px; display: block; margin-bottom: 8px;">
                        <span style="font-size: 0.8rem; font-weight: 700; color: #28a745;"><i class="fa-solid fa-circle-check"></i> Custom QR Uploaded</span>
                    </div>
                @else
                    <div style="margin-bottom: 15px; padding: 15px; border: 1px dotted #ccc; border-radius: 12px; display: inline-block; background: #fafafa; color: var(--text-light); font-size: 0.85rem;">
                        <i class="fa-solid fa-wand-magic-sparkles"></i> Automatic QR Generation Active
                    </div>
                @endif
                <input type="file" name="upi_qr_code" class="form-control" accept="image/*">
                <small style="color: var(--text-light); margin-top: 5px; display: block;">Upload a custom QR code image, or leave empty to use dynamic URI generation.</small>
            </div>
        </div>

        <!-- Bank Details Card -->
        <div class="admin-card">
            <h2 style="font-weight: 800; font-size: 1.5rem; margin-bottom: 25px; color: var(--primary-color); display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-building-columns"></i> Bank Account Details
            </h2>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Bank Name</label>
                <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name', $settings->bank_name) }}" placeholder="e.g. HDFC Bank">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Account Holder Name</label>
                <input type="text" name="account_holder" class="form-control" value="{{ old('account_holder', $settings->account_holder) }}" placeholder="e.g. Tunicart Apparel Pvt Ltd">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Account Number</label>
                <input type="text" name="account_number" class="form-control" value="{{ old('account_number', $settings->account_number) }}" placeholder="e.g. 50100234567890">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">IFSC Code</label>
                <input type="text" name="ifsc_code" class="form-control" value="{{ old('ifsc_code', $settings->ifsc_code) }}" placeholder="e.g. HDFC0001234">
            </div>
        </div>
    </div>

    <div style="text-align: right;">
        <button type="submit" class="btn-admin btn-primary" style="padding: 15px 50px; border-radius: 12px; font-size: 1rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-floppy-disk"></i> Save Payment Settings
        </button>
    </div>
</form>
@endsection
