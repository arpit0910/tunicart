@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Product Attributes</h1>
    <a href="{{ route('admin.attributes.create') }}" class="btn btn-primary" style="text-decoration: none;">+ Add New Attribute</a>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 30px;">
    @foreach($attributes as $attr)
        <div class="admin-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="margin: 0;">{{ $attr->name }}</h3>
                <a href="{{ route('admin.attributes.values.create', $attr->id) }}" class="btn" style="padding: 5px 10px; font-size: 0.8rem; background: #eee; text-decoration: none;">+ Add Value</a>
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
@endsection
