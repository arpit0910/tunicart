@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Manage Products</h1>
    <button onclick="document.getElementById('addModal').style.display='block'" class="btn btn-primary">+ Add New Product</button>
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
                    <td><img src="{{ asset('images/'.$prod->image) }}" style="width: 50px; height: 50px; border-radius: 5px; object-fit: cover;"></td>
                    <td>{{ $prod->name }}</td>
                    <td>{{ $prod->category->name }}</td>
                    <td>₹{{ $prod->price }}</td>
                    <td>{{ $prod->is_featured ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="#" style="color: blue; margin-right: 15px;"><i class="fa-solid fa-pen"></i></a>
                        <a href="#" style="color: red;"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="addModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; width:600px; margin:50px auto; padding:40px; border-radius:15px; max-height: 90vh; overflow-y: auto;">
        <h2>Add Product</h2>
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" class="form-control" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Price (₹)</label>
                    <input type="number" name="price" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="form-group">
                <label><input type="checkbox" name="is_featured" value="1"> Featured Product</label>
            </div>
            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="flex:1;">Save Product</button>
                <button type="button" onclick="document.getElementById('addModal').style.display='none'" class="btn" style="background:#eee; flex:1;">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection
