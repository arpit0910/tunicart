@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Manage Products</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary" style="text-decoration: none;">+ Add New Product</a>
</div>

<div class="admin-card">
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Featured</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $prod)
                <tr>
                    <td><img src="{{ asset('storage/'.$prod->image) }}" style="width: 50px; height: 50px; border-radius: 5px; object-fit: cover;"></td>
                    <td>{{ $prod->name }}</td>
                    <td>{{ $prod->category->name }}</td>
                    <td>₹{{ $prod->price }}</td>
                    <td>{{ $prod->is_featured ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', $prod->id) }}" style="color: blue; text-decoration: none; margin-right: 15px;"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('admin.products.delete', $prod->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this product?')">
                            @csrf
                            <button type="submit" style="color: red; border:none; background:none; cursor:pointer;"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
