@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Add Product Attribute</h1>
    <a href="{{ route('admin.attributes') }}" class="btn-admin" style="background: #eee; color: var(--black); text-decoration: none; padding: 12px 25px; border-radius: 10px; font-weight: 700;">Back to Attributes</a>
</div>

<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.attributes.store') }}" method="POST">
        @csrf
        <div class="form-group" style="margin-bottom: 30px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Attribute Name (e.g., Size, Color, Fabric)</label>
            <input type="text" name="name" class="form-control" placeholder="e.g., Size" required>
        </div>
        <div style="display: flex; gap: 15px;">
            <button type="submit" class="btn-admin btn-primary" style="padding: 15px 40px; border-radius: 10px; font-size: 1rem; cursor: pointer;">Save Attribute</button>
            <a href="{{ route('admin.attributes') }}" class="btn-admin" style="background: #eee; color: var(--black); text-decoration: none; padding: 15px 40px; border-radius: 10px; font-size: 1rem; text-align: center;">Cancel</a>
        </div>
    </form>
</div>
@endsection
