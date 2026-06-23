@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Create Coupon</h1>
    <a href="{{ route('admin.coupons') }}" class="btn-admin" style="background: #eee; color: var(--black); text-decoration: none; padding: 12px 25px; border-radius: 10px; font-weight: 700;">Back to Coupons</a>
</div>

<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.coupons.store') }}" method="POST">
        @csrf
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Coupon Code</label>
            <input type="text" name="code" class="form-control" placeholder="SAVE20" required>
        </div>
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Type</label>
            <select name="type" class="form-control" required>
                <option value="percent">Percentage</option>
                <option value="fixed">Fixed Amount</option>
            </select>
        </div>
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Value</label>
            <input type="number" name="value" class="form-control" required step="0.01" placeholder="Enter discount value">
        </div>
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Min. Order Amount (₹)</label>
            <input type="number" name="min_amount" class="form-control" value="0" step="0.01" placeholder="Enter minimum order amount">
        </div>
        <div class="form-group" style="margin-bottom: 30px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Expiry Date</label>
            <input type="date" name="expiry_date" class="form-control">
        </div>
        <div style="display: flex; gap: 15px;">
            <button type="submit" class="btn-admin btn-primary" style="padding: 15px 40px; border-radius: 10px; font-size: 1rem; cursor: pointer;">Save Coupon</button>
            <a href="{{ route('admin.coupons') }}" class="btn-admin" style="background: #eee; color: var(--black); text-decoration: none; padding: 15px 40px; border-radius: 10px; font-size: 1rem; text-align: center;">Cancel</a>
        </div>
    </form>
</div>
@endsection
