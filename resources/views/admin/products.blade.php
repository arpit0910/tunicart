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
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Front Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="form-group">
                    <label>Back Image</label>
                    <input type="file" name="back_image" class="form-control">
                </div>
            </div>
            
            <div class="form-group">
                <label>Product Variants</label>
                <div style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 8px;">
                    @foreach($attributes as $attr)
                        <div style="margin-bottom: 10px;">
                            <strong style="display: block; margin-bottom: 5px; color: var(--primary-color);">{{ $attr->name }}</strong>
                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 15px;">
                                @foreach($attr->values as $val)
                                    <div style="display: flex; flex-direction: column; gap: 5px; background: #f8f9fa; padding: 10px; border-radius: 8px; border: 1px solid #eee;">
                                        <label style="font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 5px; margin-bottom: 0;">
                                            <input type="checkbox" name="attribute_values[]" value="{{ $val->id }}" onchange="document.getElementById('variant_inputs_{{ $val->id }}').style.display = this.checked ? 'flex' : 'none'"> {{ $val->value }}
                                        </label>
                                        <div id="variant_inputs_{{ $val->id }}" style="display: none; flex-direction: column; gap: 5px; margin-top: 5px;">
                                            <label style="font-size: 0.65rem; color: var(--text-light); text-transform: uppercase;">Front Image</label>
                                            <input type="file" name="variant_image_{{ $val->id }}" class="form-control" style="font-size: 0.7rem; padding: 5px;">
                                            <label style="font-size: 0.65rem; color: var(--text-light); text-transform: uppercase;">Back Image</label>
                                            <input type="file" name="variant_back_image_{{ $val->id }}" class="form-control" style="font-size: 0.7rem; padding: 5px;">
                                        </div>
                                    </div>
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
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Front Image (Change)</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="form-group">
                    <label>Back Image (Change)</label>
                    <input type="file" name="back_image" class="form-control">
                </div>
            </div>
            
            <div class="form-group">
                <label>Product Variants</label>
                <div style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 8px;">
                    @foreach($attributes as $attr)
                        <div style="margin-bottom: 10px;">
                            <strong style="display: block; margin-bottom: 5px; color: var(--primary-color);">{{ $attr->name }}</strong>
                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 15px;">
                                @foreach($attr->values as $val)
                                    <div style="display: flex; flex-direction: column; gap: 5px; background: #f8f9fa; padding: 10px; border-radius: 8px; border: 1px solid #eee;">
                                        <label style="font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 5px; margin-bottom: 0;">
                                            <input type="checkbox" name="attribute_values[]" value="{{ $val->id }}" class="edit-attr-checkbox" onchange="document.getElementById('edit_variant_inputs_{{ $val->id }}').style.display = this.checked ? 'flex' : 'none'"> {{ $val->value }}
                                        </label>
                                        <div id="edit_variant_inputs_{{ $val->id }}" style="display: none; flex-direction: column; gap: 5px; margin-top: 5px;">
                                            <label style="font-size: 0.65rem; color: var(--text-light); text-transform: uppercase;">Front Image</label>
                                            <input type="file" name="variant_image_{{ $val->id }}" class="form-control" style="font-size: 0.7rem; padding: 5px;">
                                            <label style="font-size: 0.65rem; color: var(--text-light); text-transform: uppercase;">Back Image</label>
                                            <input type="file" name="variant_back_image_{{ $val->id }}" class="form-control" style="font-size: 0.7rem; padding: 5px;">
                                        </div>
                                    </div>
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
        
        // Reset checkboxes and inputs
        document.querySelectorAll('.edit-attr-checkbox').forEach(cb => {
            const isChecked = selectedValues.includes(parseInt(cb.value));
            cb.checked = isChecked;
            const inputContainer = document.getElementById('edit_variant_inputs_' + cb.value);
            if (inputContainer) {
                inputContainer.style.display = isChecked ? 'flex' : 'none';
            }
        });

        document.getElementById('editModal').style.display = 'block';
    }
</script>
@endsection
