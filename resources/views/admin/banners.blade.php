@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Manage Banners</h1>
    <button onclick="document.getElementById('addModal').style.display='block'" class="btn btn-primary">+ Add New Banner</button>
</div>

<div class="admin-card">
    <table>
        <thead>
            <tr>
                <th>Banner</th>
                <th>Title</th>
                <th>Sub Title</th>
                <th>Link</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($banners as $banner)
                <tr>
                    <td><img src="{{ asset('storage/'.$banner->image) }}" style="width: 150px; height: 60px; border-radius: 5px; object-fit: cover;"></td>
                    <td>{{ $banner->title }}</td>
                    <td>{{ $banner->sub_title }}</td>
                    <td>{{ $banner->link }}</td>
                    <td>
                        <a href="#" style="color: red;"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;">No banners found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="addModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; width:500px; margin:100px auto; padding:40px; border-radius:15px;">
        <h2>Add Hero Banner</h2>
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Banner Image</label>
                <input type="file" name="image" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control">
            </div>
            <div class="form-group">
                <label>Sub Title</label>
                <input type="text" name="sub_title" class="form-control">
            </div>
            <div class="form-group">
                <label>Link URL</label>
                <input type="text" name="link" class="form-control">
            </div>
            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="flex:1;">Upload Banner</button>
                <button type="button" onclick="document.getElementById('addModal').style.display='none'" class="btn" style="background:#eee; flex:1;">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection
