@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Manage Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary" style="text-decoration: none;">+ Add New Category</a>
</div>

<div class="admin-card">
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Products</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $cat)
                <tr>
                    <td><img src="{{ asset('storage/'.$cat->image) }}" style="width: 50px; height: 50px; border-radius: 5px; object-fit: cover;"></td>
                    <td>{{ $cat->name }}</td>
                    <td>{{ $cat->slug }}</td>
                    <td>{{ $cat->products->count() }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $cat->id) }}" style="color: blue; text-decoration: none; margin-right: 15px;"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('admin.categories.delete', $cat->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this category?')">
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
