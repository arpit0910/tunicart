@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Manage Coupons</h1>
    <button onclick="document.getElementById('addModal').style.display='block'" class="btn btn-primary">+ Create Coupon</button>
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
                        <button onclick="openEditModal({{ json_encode($coupon) }})" style="color: blue; border:none; background:none; cursor:pointer; margin-right: 15px;"><i class="fa-solid fa-pen"></i></button>
                        <form action="{{ route('admin.coupons.delete', $coupon->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this coupon?')">
                            @csrf
                            <button type="submit" style="color: red; border:none; background:none; cursor:pointer;"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;">No coupons found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div id="addModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; width:500px; margin:100px auto; padding:40px; border-radius:15px;">
        <h2>Create Coupon</h2>
        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Coupon Code</label>
                <input type="text" name="code" class="form-control" required placeholder="SAVE20">
            </div>
            <div class="form-group">
                <label>Type</label>
                <select name="type" class="form-control" required>
                    <option value="percent">Percentage</option>
                    <option value="fixed">Fixed Amount</option>
                </select>
            </div>
            <div class="form-group">
                <label>Value</label>
                <input type="number" name="value" class="form-control" required step="0.01">
            </div>
            <div class="form-group">
                <label>Min. Order Amount (₹)</label>
                <input type="number" name="min_amount" class="form-control" value="0" step="0.01">
            </div>
            <div class="form-group">
                <label>Expiry Date</label>
                <input type="date" name="expiry_date" class="form-control">
            </div>
            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="flex:1;">Save Coupon</button>
                <button type="button" onclick="document.getElementById('addModal').style.display='none'" class="btn" style="background:#eee; flex:1;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; width:500px; margin:100px auto; padding:40px; border-radius:15px;">
        <h2>Edit Coupon</h2>
        <form id="editForm" method="POST">
            @csrf
            <div class="form-group">
                <label>Coupon Code</label>
                <input type="text" name="code" id="edit_code" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Type</label>
                <select name="type" id="edit_type" class="form-control" required>
                    <option value="percent">Percentage</option>
                    <option value="fixed">Fixed Amount</option>
                </select>
            </div>
            <div class="form-group">
                <label>Value</label>
                <input type="number" name="value" id="edit_value" class="form-control" required step="0.01">
            </div>
            <div class="form-group">
                <label>Min. Order Amount (₹)</label>
                <input type="number" name="min_amount" id="edit_min_amount" class="form-control" step="0.01">
            </div>
            <div class="form-group">
                <label>Expiry Date</label>
                <input type="date" name="expiry_date" id="edit_expiry_date" class="form-control">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" id="edit_status" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="flex:1;">Update Coupon</button>
                <button type="button" onclick="document.getElementById('editModal').style.display='none'" class="btn" style="background:#eee; flex:1;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(coupon) {
        document.getElementById('editForm').action = "/admin/coupons/update/" + coupon.id;
        document.getElementById('edit_code').value = coupon.code;
        document.getElementById('edit_type').value = coupon.type;
        document.getElementById('edit_value').value = coupon.value;
        document.getElementById('edit_min_amount').value = coupon.min_amount;
        document.getElementById('edit_expiry_date').value = coupon.expiry_date;
        document.getElementById('edit_status').value = coupon.status;
        document.getElementById('editModal').style.display = 'block';
    }
</script>
@endsection
