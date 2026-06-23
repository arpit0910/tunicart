@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Manage Banners</h1>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary" style="text-decoration: none;">+ Add New Banner</a>
</div>

<div class="admin-card">
    <table>
        <thead>
            <tr>
                <th>Banner</th>
                <th>Title</th>
                <th>Sub Title</th>
                <th>Display On</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($banners as $banner)
                <tr>
                    <td><img src="{{ Str::startsWith($banner->image, 'http') ? $banner->image : asset('storage/'.$banner->image) }}" style="width: 150px; height: 60px; border-radius: 5px; object-fit: cover;"></td>
                    <td>{{ $banner->title }}</td>
                    <td>{{ $banner->sub_title }}</td>
                    <td><span class="badge" style="background: var(--accent-color); color: var(--primary-color); padding: 5px 10px; border-radius: 20px; font-size: 0.7rem; text-transform: uppercase; font-weight: 800;">{{ $banner->display_on }}</span></td>
                    <td>
                        <a href="{{ route('admin.banners.edit', $banner->id) }}" style="color: blue; text-decoration: none; margin-right: 15px;"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('admin.banners.delete', $banner->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this banner?')">
                            @csrf
                            <button type="submit" style="color: red; border:none; background:none; cursor:pointer;"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;">No banners found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
