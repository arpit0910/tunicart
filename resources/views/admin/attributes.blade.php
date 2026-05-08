@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Product Attributes</h1>
    <button onclick="document.getElementById('attrModal').style.display='block'" class="btn btn-primary">+ Add New Attribute</button>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 30px;">
    @foreach($attributes as $attr)
        <div class="admin-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="margin: 0;">{{ $attr->name }}</h3>
                <button onclick="openValueModal({{ $attr->id }}, '{{ $attr->name }}')" class="btn" style="padding: 5px 10px; font-size: 0.8rem; background: #eee;">+ Add Value</button>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                @foreach($attr->values as $val)
                    <span style="background: #f0f2f5; padding: 5px 15px; border-radius: 20px; font-size: 0.9rem; border: 1px solid #ddd;">
                        {{ $val->value }}
                    </span>
                @endforeach
                @if($attr->values->count() == 0)
                    <p style="color: #999; font-style: italic;">No values added yet.</p>
                @endif
            </div>
        </div>
    @endforeach
</div>

<!-- Attribute Modal -->
<div id="attrModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; width:400px; margin:100px auto; padding:40px; border-radius:15px;">
        <h2>Add Attribute</h2>
        <form action="{{ route('admin.attributes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Attribute Name (e.g., Size, Color)</label>
                <input type="text" name="name" class="form-control" required placeholder="Size">
            </div>
            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="flex:1;">Save</button>
                <button type="button" onclick="document.getElementById('attrModal').style.display='none'" class="btn" style="background:#eee; flex:1;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Value Modal -->
<div id="valModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; width:400px; margin:100px auto; padding:40px; border-radius:15px;">
        <h2>Add <span id="attrNameLabel"></span> Value</h2>
        <form action="{{ route('admin.attributes.values.store') }}" method="POST">
            @csrf
            <input type="hidden" name="attribute_id" id="attrIdInput">
            <div class="form-group">
                <label>Value (e.g., XL, Blue, Cotton)</label>
                <input type="text" name="value" class="form-control" required placeholder="Enter value">
            </div>
            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="flex:1;">Save Value</button>
                <button type="button" onclick="document.getElementById('valModal').style.display='none'" class="btn" style="background:#eee; flex:1;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openValueModal(id, name) {
        document.getElementById('attrIdInput').value = id;
        document.getElementById('attrNameLabel').innerText = name;
        document.getElementById('valModal').style.display = 'block';
    }
</script>
@endsection
