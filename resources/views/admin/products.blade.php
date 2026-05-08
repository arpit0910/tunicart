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
                    <td><img src="{{ asset('storage/'.$prod->image) }}" style="width: 50px; height: 50px; border-radius: 5px; object-fit: cover;"></td>
                    <td>{{ $prod->name }}</td>
                    <td>{{ $prod->category->name }}</td>
                    <td>₹{{ $prod->price }}</td>
                    <td>{{ $prod->is_featured ? 'Yes' : 'No' }}</td>
                    <td>
                        <button onclick="openEditModal({{ json_encode($prod) }}, {{ json_encode($prod->attributeValues->pluck('id')) }})" style="color: blue; border:none; background:none; cursor:pointer; margin-right: 15px;"><i class="fa-solid fa-pen"></i></button>
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

<!-- Add Modal -->
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
                <label>Product Variants</label>
                <div style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 8px;">
                    @foreach($attributes as $attr)
                        <div style="margin-bottom: 10px;">
                            <strong style="display: block; margin-bottom: 5px; color: var(--primary-color);">{{ $attr->name }}</strong>
                            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                @foreach($attr->values as $val)
                                    <label style="font-weight: normal; cursor: pointer; background: #f8f9fa; padding: 2px 8px; border-radius: 4px; border: 1px solid #eee;">
                                        <input type="checkbox" name="attribute_values[]" value="{{ $val->id }}"> {{ $val->value }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
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

<!-- Edit Modal -->
<div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; width:600px; margin:50px auto; padding:40px; border-radius:15px; max-height: 90vh; overflow-y: auto;">
        <h2>Edit Product</h2>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" id="edit_name" class="form-control" required>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" id="edit_category_id" class="form-control" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Price (₹)</label>
                    <input type="number" name="price" id="edit_price" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Image (Leave blank to keep current)</label>
                <input type="file" name="image" class="form-control">
            </div>
            
            <div class="form-group">
                <label>Product Variants</label>
                <div style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 8px;">
                    @foreach($attributes as $attr)
                        <div style="margin-bottom: 10px;">
                            <strong style="display: block; margin-bottom: 5px; color: var(--primary-color);">{{ $attr->name }}</strong>
                            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                @foreach($attr->values as $val)
                                    <label style="font-weight: normal; cursor: pointer; background: #f8f9fa; padding: 2px 8px; border-radius: 4px; border: 1px solid #eee;">
                                        <input type="checkbox" name="attribute_values[]" value="{{ $val->id }}" class="edit-attr-checkbox"> {{ $val->value }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label><input type="checkbox" name="is_featured" id="edit_is_featured" value="1"> Featured Product</label>
            </div>
            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="flex:1;">Update Product</button>
                <button type="button" onclick="document.getElementById('editModal').style.display='none'" class="btn" style="background:#eee; flex:1;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(product, selectedValues) {
        document.getElementById('editForm').action = "/admin/products/update/" + product.id;
        document.getElementById('edit_name').value = product.name;
        document.getElementById('edit_category_id').value = product.category_id;
        document.getElementById('edit_price').value = product.price;
        document.getElementById('edit_description').value = product.description;
        document.getElementById('edit_is_featured').checked = product.is_featured == 1;
        
        // Reset checkboxes
        document.querySelectorAll('.edit-attr-checkbox').forEach(cb => {
            cb.checked = selectedValues.includes(parseInt(cb.value));
        });

        document.getElementById('editModal').style.display = 'block';
    }
</script>
@endsection
