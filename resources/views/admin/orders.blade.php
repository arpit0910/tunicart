@extends('admin.layout')

@section('content')
<h1 style="margin-bottom: 30px;">Manage Orders</h1>

<div class="admin-card">
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->user->name }}<br><small>{{ $order->user->email }}</small></td>
                    <td>₹{{ $order->total_amount }}</td>
                    <td>
                        <span style="padding: 5px 10px; border-radius: 5px; font-size: 0.8rem; font-weight: 700; background: 
                            {{ $order->status == 'delivered' ? '#dcfce7' : ($order->status == 'shipped' ? '#dbeafe' : '#fef3c7') }};
                            color: {{ $order->status == 'delivered' ? '#166534' : ($order->status == 'shipped' ? '#1e40af' : '#92400e') }};">
                            {{ strtoupper($order->status) }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                    <td>
                        <button onclick="viewOrder({{ $order->id }})" style="color: blue; border: none; background: none; cursor: pointer;"><i class="fa-solid fa-eye"></i> View</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- View Order Modal (Simplified for now) -->
<div id="viewModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; width:800px; margin:50px auto; padding:40px; border-radius:15px; max-height: 90vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h2>Order Details #<span id="modalOrderId"></span></h2>
            <button onclick="document.getElementById('viewModal').style.display='none'" style="border:none; background:none; font-size: 1.5rem; cursor:pointer;">&times;</button>
        </div>
        
        <form id="statusForm" method="POST" style="margin-bottom: 30px; display: flex; gap: 10px; align-items: center;">
            @csrf
            <label>Change Status:</label>
            <select name="status" class="form-control" style="width: 200px;">
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <button type="submit" class="btn btn-primary">Update Status</button>
        </form>

        <h3>Order Items</h3>
        <div id="orderItemsList" style="margin-top: 20px;">
            <!-- Dynamic Content -->
        </div>
    </div>
</div>

<script>
    function viewOrder(id) {
        document.getElementById('modalOrderId').innerText = id;
        document.getElementById('statusForm').action = "/admin/orders/update-status/" + id;
        document.getElementById('viewModal').style.display = 'block';
        // In a real app, you'd fetch item details via AJAX.
        // For now, we'll show a message.
        document.getElementById('orderItemsList').innerHTML = "<p>Loading items and customization images...</p>";
    }
</script>
@endsection
