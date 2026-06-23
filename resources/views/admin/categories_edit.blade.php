@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Edit Category</h1>
    <a href="{{ route('admin.categories') }}" class="btn-admin" style="background: #eee; color: var(--black); text-decoration: none; padding: 12px 25px; border-radius: 10px; font-weight: 700;">Back to Categories</a>
</div>

<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Category Name</label>
            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
        </div>
        <div class="form-group" style="margin-bottom: 30px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Category Image (Leave blank to keep current)</label>
            <input type="file" name="image" class="form-control">
            @if($category->image)
                <div style="margin-top: 15px;">
                    <span style="display:block; margin-bottom: 5px; font-size: 0.85rem; color: var(--text-light);">Current image:</span>
                    <img src="{{ asset('storage/'.$category->image) }}" style="width: 100px; height: 100px; border-radius: 8px; object-fit: cover; border: 1px solid #ddd;">
                </div>
            @endif
        </div>
        <div style="display: flex; gap: 15px;">
            <button type="submit" class="btn-admin btn-primary" style="padding: 15px 40px; border-radius: 10px; font-size: 1rem; cursor: pointer;">Save Changes</button>
            <a href="{{ route('admin.categories') }}" class="btn-admin" style="background: #eee; color: var(--black); text-decoration: none; padding: 15px 40px; border-radius: 10px; font-size: 1rem; text-align: center;">Cancel</a>
        </div>
    </form>
</div>
@endsection
