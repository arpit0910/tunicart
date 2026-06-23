@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Edit Product</h1>
    <a href="{{ route('admin.products') }}" class="btn-admin" style="background: #eee; color: var(--black); text-decoration: none; padding: 12px 25px; border-radius: 10px; font-weight: 700;">Back to Products</a>
</div>

<div class="admin-card" style="max-width: 800px;">
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Product Name</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Category</label>
                <select name="category_id" class="form-control" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Price (₹)</label>
                <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Description</label>
            <textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Front Image (Change)</label>
                <input type="file" name="image" class="form-control">
                @if($product->image)
                    <div style="margin-top: 10px;">
                        <span style="font-size:0.85rem; color:var(--text-light); display:block; margin-bottom:5px;">Current Front:</span>
                        <img src="{{ asset('storage/'.$product->image) }}" style="width: 100px; height: 100px; border-radius: 8px; object-fit: cover; border: 1px solid #ddd;">
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Back Image (Change)</label>
                <input type="file" name="back_image" class="form-control">
                @if($product->back_image)
                    <div style="margin-top: 10px;">
                        <span style="font-size:0.85rem; color:var(--text-light); display:block; margin-bottom:5px;">Current Back:</span>
                        <img src="{{ asset('storage/'.$product->back_image) }}" style="width: 100px; height: 100px; border-radius: 8px; object-fit: cover; border: 1px solid #ddd;">
                    </div>
                @endif
            </div>
        </div>
        
        <div class="form-group" style="margin-bottom: 25px;">
            <label style="display: block; margin-bottom: 12px; font-weight: 700;">Product Variants</label>
            <div style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 20px; border-radius: 12px; background: #fafafa;">
                @php
                    $selectedValues = $product->attributeValues->pluck('id')->toArray();
                @endphp
                @foreach($attributes as $attr)
                    <div style="margin-bottom: 20px;">
                        <strong style="display: block; margin-bottom: 10px; color: var(--primary-color); font-size: 1rem;">{{ $attr->name }}</strong>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 15px;">
                            @foreach($attr->values as $val)
                                @php
                                    $isCheck = in_array($val->id, $selectedValues);
                                    $pivot = $isCheck ? $product->attributeValues->where('id', $val->id)->first()->pivot : null;
                                @endphp
                                <div style="display: flex; flex-direction: column; gap: 5px; background: #fff; padding: 15px; border-radius: 8px; border: 1px solid #eee; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                                    <label style="font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px; margin-bottom: 0;">
                                        <input type="checkbox" name="attribute_values[]" value="{{ $val->id }}" class="edit-attr-checkbox" {{ $isCheck ? 'checked' : '' }} onchange="document.getElementById('edit_variant_inputs_{{ $val->id }}').style.display = this.checked ? 'flex' : 'none'"> {{ $val->value }}
                                    </label>
                                    <div id="edit_variant_inputs_{{ $val->id }}" style="display: {{ $isCheck ? 'flex' : 'none' }}; flex-direction: column; gap: 5px; margin-top: 10px; border-top: 1px solid #eee; padding-top: 10px;">
                                        <label style="font-size: 0.65rem; color: var(--text-light); text-transform: uppercase; font-weight: 700; margin-bottom: 3px;">Front Image</label>
                                        @if($pivot && $pivot->image)
                                            <span style="font-size: 0.7rem; color: var(--text-light); margin-bottom: 5px; display: block;">Current: <a href="{{ asset('storage/'.$pivot->image) }}" target="_blank" style="color: var(--accent-color); font-weight: 700;">View File</a></span>
                                        @endif
                                        <input type="file" name="variant_image_{{ $val->id }}" class="form-control" style="font-size: 0.75rem; padding: 5px;">
                                        
                                        <label style="font-size: 0.65rem; color: var(--text-light); text-transform: uppercase; font-weight: 700; margin-bottom: 3px; margin-top: 5px;">Back Image</label>
                                        @if($pivot && $pivot->back_image)
                                            <span style="font-size: 0.7rem; color: var(--text-light); margin-bottom: 5px; display: block;">Current: <a href="{{ asset('storage/'.$pivot->back_image) }}" target="_blank" style="color: var(--accent-color); font-weight: 700;">View File</a></span>
                                        @endif
                                        <input type="file" name="variant_back_image_{{ $val->id }}" class="form-control" style="font-size: 0.75rem; padding: 5px;">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 30px;">
            <label style="font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }}> Featured Product
            </label>
        </div>

        <div style="display: flex; gap: 15px;">
            <button type="submit" class="btn-admin btn-primary" style="padding: 15px 40px; border-radius: 10px; font-size: 1rem; cursor: pointer;">Save Changes</button>
            <a href="{{ route('admin.products') }}" class="btn-admin" style="background: #eee; color: var(--black); text-decoration: none; padding: 15px 40px; border-radius: 10px; font-size: 1rem; text-align: center;">Cancel</a>
        </div>
    </form>
</div>
@endsection
