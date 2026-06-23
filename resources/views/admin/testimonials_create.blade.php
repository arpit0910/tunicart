@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Add New Testimonial</h1>
    <a href="{{ route('admin.testimonials') }}" class="btn-admin" style="background: #eee; color: var(--black); text-decoration: none; padding: 12px 25px; border-radius: 10px; font-weight: 700;">Back to Testimonials</a>
</div>

<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">User Name</label>
            <input type="text" name="user_name" class="form-control" placeholder="Enter reviewer's name" required>
        </div>
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Rating (1-5)</label>
            <input type="number" name="rating" min="1" max="5" value="5" class="form-control" required>
        </div>
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">User Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <div class="form-group" style="margin-bottom: 30px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Testimonial Content</label>
            <textarea name="content" class="form-control" rows="4" placeholder="Enter testimonial text" required></textarea>
        </div>
        <div style="display: flex; gap: 15px;">
            <button type="submit" class="btn-admin btn-primary" style="padding: 15px 40px; border-radius: 10px; font-size: 1rem; cursor: pointer;">Save Testimonial</button>
            <a href="{{ route('admin.testimonials') }}" class="btn-admin" style="background: #eee; color: var(--black); text-decoration: none; padding: 15px 40px; border-radius: 10px; font-size: 1rem; text-align: center;">Cancel</a>
        </div>
    </form>
</div>
@endsection
