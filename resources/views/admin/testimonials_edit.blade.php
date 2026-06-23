@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Edit Testimonial</h1>
    <a href="{{ route('admin.testimonials') }}" class="btn-admin" style="background: #eee; color: var(--black); text-decoration: none; padding: 12px 25px; border-radius: 10px; font-weight: 700;">Back to Testimonials</a>
</div>

<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">User Name</label>
            <input type="text" name="user_name" class="form-control" value="{{ old('user_name', $testimonial->user_name) }}" required>
        </div>
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Rating (1-5)</label>
            <input type="number" name="rating" min="1" max="5" class="form-control" value="{{ old('rating', $testimonial->rating) }}" required>
        </div>
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">User Image</label>
            @if($testimonial->image)
                <div style="margin-bottom: 10px; display: flex; align-items: center; gap: 10px;">
                    <img src="{{ asset('storage/' . $testimonial->image) }}" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                    <span style="font-size: 0.9rem; color: var(--text-light);">Current Image</span>
                </div>
            @endif
            <input type="file" name="image" class="form-control">
            <small style="color: var(--text-light); display: block; margin-top: 5px;">Leave empty to keep the current image</small>
        </div>
        <div class="form-group" style="margin-bottom: 30px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Testimonial Content</label>
            <textarea name="content" class="form-control" rows="4" required>{{ old('content', $testimonial->content) }}</textarea>
        </div>
        <div style="display: flex; gap: 15px;">
            <button type="submit" class="btn-admin btn-primary" style="padding: 15px 40px; border-radius: 10px; font-size: 1rem; cursor: pointer;">Update Testimonial</button>
            <a href="{{ route('admin.testimonials') }}" class="btn-admin" style="background: #eee; color: var(--black); text-decoration: none; padding: 15px 40px; border-radius: 10px; font-size: 1rem; text-align: center;">Cancel</a>
        </div>
    </form>
</div>
@endsection
