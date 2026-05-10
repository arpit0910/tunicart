@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Manage Customers</h1>
</div>

<div class="admin-card">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Joined Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>#{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->created_at->format('M d, Y') }}</td>
                    <td>
                        <form action="{{ route('admin.customers.delete', $customer->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this customer? This cannot be undone if they have no orders.')">
                            @csrf
                            <button type="submit" style="color: red; border:none; background:none; cursor:pointer;"><i class="fa-solid fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
