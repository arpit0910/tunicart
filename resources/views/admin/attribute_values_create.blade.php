@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Add Value to {{ $attribute->name }}</h1>
    <a href="{{ route('admin.attributes') }}" class="btn-admin" style="background: #eee; color: var(--black); text-decoration: none; padding: 12px 25px; border-radius: 10px; font-weight: 700;">Back to Attributes</a>
</div>

<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.attributes.values.store') }}" method="POST">
        @csrf
        <input type="hidden" name="attribute_id" value="{{ $attribute->id }}">
        
        <div class="form-group" style="margin-bottom: 30px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Value Name (e.g., XL, Navy Blue, Cotton)</label>
            <input type="text" name="value" class="form-control" placeholder="Enter value option" required>
        </div>
        
        <div style="display: flex; gap: 15px;">
            <button type="submit" class="btn-admin btn-primary" style="padding: 15px 40px; border-radius: 10px; font-size: 1rem; cursor: pointer;">Save Value</button>
            <a href="{{ route('admin.attributes') }}" class="btn-admin" style="background: #eee; color: var(--black); text-decoration: none; padding: 15px 40px; border-radius: 10px; font-size: 1rem; text-align: center;">Cancel</a>
        </div>
    </form>
</div>
@endsection
