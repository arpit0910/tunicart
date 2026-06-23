@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Add New Hero Banner</h1>
    <a href="{{ route('admin.banners') }}" class="btn-admin" style="background: #eee; color: var(--black); text-decoration: none; padding: 12px 25px; border-radius: 10px; font-weight: 700;">Back to Banners</a>
</div>

<div class="admin-card" style="max-width: 800px;">
    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Banner Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Title</label>
                <input type="text" name="title" class="form-control">
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Sub Title</label>
                <input type="text" name="sub_title" class="form-control">
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Description</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Button Text</label>
                <input type="text" name="button_text" class="form-control" value="Shop Now">
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Text Color</label>
                <input type="color" name="text_color" class="form-control" value="#1E0E00" style="height: 50px; padding: 5px;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Display On</label>
                <select name="display_on" class="form-control">
                    <option value="both">Both (Web & Mobile)</option>
                    <option value="web">Web Only</option>
                    <option value="mobile">Mobile Only</option>
                </select>
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Link URL</label>
                <input type="text" name="link" class="form-control">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; background: #f9f9f9; padding: 20px; border-radius: 12px; border: 1px solid #eee;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Vertical Position</label>
                <select name="vertical_position" class="form-control">
                    <option value="flex-start">Top</option>
                    <option value="center" selected>Middle (Center)</option>
                    <option value="flex-end">Bottom</option>
                </select>
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Horizontal Position</label>
                <select name="horizontal_position" class="form-control">
                    <option value="flex-start" selected>Left</option>
                    <option value="center">Center</option>
                    <option value="flex-end">Right</option>
                </select>
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Text Align</label>
                <select name="text_align" class="form-control">
                    <option value="left" selected>Left</option>
                    <option value="center">Center</option>
                    <option value="right">Right</option>
                </select>
            </div>
        </div>

        <div style="display: flex; gap: 15px;">
            <button type="submit" class="btn-admin btn-primary" style="padding: 15px 40px; border-radius: 10px; font-size: 1rem; cursor: pointer;">Upload & Create Banner</button>
            <a href="{{ route('admin.banners') }}" class="btn-admin" style="background: #eee; color: var(--black); text-decoration: none; padding: 15px 40px; border-radius: 10px; font-size: 1rem; text-align: center;">Cancel</a>
        </div>
    </form>
</div>
@endsection
