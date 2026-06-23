@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Edit Hero Banner</h1>
    <a href="{{ route('admin.banners') }}" class="btn-admin" style="background: #eee; color: var(--black); text-decoration: none; padding: 12px 25px; border-radius: 10px; font-weight: 700;">Back to Banners</a>
</div>

<div class="admin-card" style="max-width: 800px;">
    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Banner Image (Leave blank to keep current)</label>
            <input type="file" name="image" class="form-control">
            @if($banner->image)
                <div style="margin-top: 15px;">
                    <span style="display:block; margin-bottom: 5px; font-size: 0.85rem; color: var(--text-light);">Current image:</span>
                    <img src="{{ Str::startsWith($banner->image, 'http') ? $banner->image : asset('storage/'.$banner->image) }}" style="width: 250px; height: 100px; border-radius: 8px; object-fit: cover; border: 1px solid #ddd;">
                </div>
            @endif
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Title</label>
                <input type="text" name="title" class="form-control" value="{{ $banner->title }}">
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Sub Title</label>
                <input type="text" name="sub_title" class="form-control" value="{{ $banner->sub_title }}">
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 700;">Description</label>
            <textarea name="description" class="form-control" rows="4">{{ $banner->description }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Button Text</label>
                <input type="text" name="button_text" class="form-control" value="{{ $banner->button_text }}">
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Text Color</label>
                <input type="color" name="text_color" class="form-control" value="{{ $banner->text_color }}" style="height: 50px; padding: 5px;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Display On</label>
                <select name="display_on" class="form-control">
                    <option value="both" {{ $banner->display_on === 'both' ? 'selected' : '' }}>Both (Web & Mobile)</option>
                    <option value="web" {{ $banner->display_on === 'web' ? 'selected' : '' }}>Web Only</option>
                    <option value="mobile" {{ $banner->display_on === 'mobile' ? 'selected' : '' }}>Mobile Only</option>
                </select>
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Link URL</label>
                <input type="text" name="link" class="form-control" value="{{ $banner->link }}">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; background: #f9f9f9; padding: 20px; border-radius: 12px; border: 1px solid #eee;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Vertical Position</label>
                <select name="vertical_position" class="form-control">
                    <option value="flex-start" {{ $banner->vertical_position === 'flex-start' ? 'selected' : '' }}>Top</option>
                    <option value="center" {{ $banner->vertical_position === 'center' ? 'selected' : '' }}>Middle (Center)</option>
                    <option value="flex-end" {{ $banner->vertical_position === 'flex-end' ? 'selected' : '' }}>Bottom</option>
                </select>
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Horizontal Position</label>
                <select name="horizontal_position" class="form-control">
                    <option value="flex-start" {{ $banner->horizontal_position === 'flex-start' ? 'selected' : '' }}>Left</option>
                    <option value="center" {{ $banner->horizontal_position === 'center' ? 'selected' : '' }}>Center</option>
                    <option value="flex-end" {{ $banner->horizontal_position === 'flex-end' ? 'selected' : '' }}>Right</option>
                </select>
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Text Align</label>
                <select name="text_align" class="form-control">
                    <option value="left" {{ $banner->text_align === 'left' ? 'selected' : '' }}>Left</option>
                    <option value="center" {{ $banner->text_align === 'center' ? 'selected' : '' }}>Center</option>
                    <option value="right" {{ $banner->text_align === 'right' ? 'selected' : '' }}>Right</option>
                </select>
            </div>
        </div>

        <div style="display: flex; gap: 15px;">
            <button type="submit" class="btn-admin btn-primary" style="padding: 15px 40px; border-radius: 10px; font-size: 1rem; cursor: pointer;">Save Changes</button>
            <a href="{{ route('admin.banners') }}" class="btn-admin" style="background: #eee; color: var(--black); text-decoration: none; padding: 15px 40px; border-radius: 10px; font-size: 1rem; text-align: center;">Cancel</a>
        </div>
    </form>
</div>
@endsection
