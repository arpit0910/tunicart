@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Manage Coupons</h1>
    <a href="{{ route('admin.coupons.create') }}" class="btn-admin btn-primary" style="text-decoration: none; display: inline-block;">+ Create Coupon</a>
</div>

<div class="admin-card">
    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Type</th>
                <th>Value</th>
                <th>Min. Order</th>
                <th>Expiry</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($coupons as $coupon)
                <tr>
                    <td style="font-weight: 700;">{{ $coupon->code }}</td>
                    <td>{{ ucfirst($coupon->type) }}</td>
                    <td>{{ $coupon->type == 'percent' ? $coupon->value.'%' : '₹'.$coupon->value }}</td>
                    <td>₹{{ $coupon->min_amount }}</td>
                    <td>{{ $coupon->expiry_date ?? 'No expiry' }}</td>
                    <td>
                        <span style="padding: 5px 10px; border-radius: 5px; font-size: 0.8rem; background: {{ $coupon->status ? '#dcfce7' : '#fee2e2' }}; color: {{ $coupon->status ? '#166534' : '#991b1b' }};">
                            {{ $coupon->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.coupons.edit', $coupon->id) }}" style="color: blue; text-decoration: none; margin-right: 15px; font-size: 1.1rem;"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('admin.coupons.delete', $coupon->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this coupon?')">
                            @csrf
                            <button type="submit" style="color: red; border:none; background:none; cursor:pointer; font-size: 1.1rem;"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;">No coupons found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
