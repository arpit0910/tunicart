@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Manage Categories</h1>
    <button onclick="document.getElementById('addModal').style.display='block'" class="btn btn-primary">+ Add New Category</button>
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
                        <button onclick="openEditModal({{ json_encode($cat) }})" style="color: blue; border:none; background:none; cursor:pointer; margin-right: 15px;"><i class="fa-solid fa-pen"></i></button>
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

<!-- Add Modal -->
<div id="addModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; width:500px; margin:100px auto; padding:40px; border-radius:15px;">
        <h2>Add Category</h2>
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image" class="form-control">
            </div>
            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="flex:1;">Save Category</button>
                <button type="button" onclick="document.getElementById('addModal').style.display='none'" class="btn" style="background:#eee; flex:1;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; width:500px; margin:100px auto; padding:40px; border-radius:15px;">
        <h2>Edit Category</h2>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="name" id="edit_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Image (Leave blank to keep current)</label>
                <input type="file" name="image" class="form-control">
            </div>
            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="flex:1;">Update Category</button>
                <button type="button" onclick="document.getElementById('editModal').style.display='none'" class="btn" style="background:#eee; flex:1;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(category) {
        document.getElementById('editForm').action = "/admin/categories/update/" + category.id;
        document.getElementById('edit_name').value = category.name;
        document.getElementById('editModal').style.display = 'block';
    }
</script>
@endsection
