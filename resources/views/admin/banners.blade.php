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
                        <button onclick="openEditModal({{ json_encode($banner) }})" style="color: blue; border:none; background:none; cursor:pointer; margin-right: 15px;"><i class="fa-solid fa-pen"></i></button>
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

<!-- Add Modal -->
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
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Button Text</label>
                <input type="text" name="button_text" class="form-control" value="Shop Now">
            </div>
            <div class="form-group">
                <label>Text Color</label>
                <input type="color" name="text_color" class="form-control" value="#1E0E00" style="height: 50px;">
            </div>
            <div class="form-group">
                <label>Display On</label>
                <select name="display_on" class="form-control">
                    <option value="both">Both (Web & Mobile)</option>
                    <option value="web">Web Only</option>
                    <option value="mobile">Mobile Only</option>
                </select>
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

<!-- Edit Modal -->
<div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; width:500px; margin:100px auto; padding:40px; border-radius:15px; max-height: 80vh; overflow-y: auto;">
        <h2>Edit Banner</h2>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Banner Image (Leave blank to keep current)</label>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" id="edit_title" class="form-control">
            </div>
            <div class="form-group">
                <label>Sub Title</label>
                <input type="text" name="sub_title" id="edit_sub_title" class="form-control">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Button Text</label>
                <input type="text" name="button_text" id="edit_button_text" class="form-control">
            </div>
            <div class="form-group">
                <label>Text Color</label>
                <input type="color" name="text_color" id="edit_text_color" class="form-control" style="height: 50px;">
            </div>
            <div class="form-group">
                <label>Display On</label>
                <select name="display_on" id="edit_display_on" class="form-control">
                    <option value="both">Both (Web & Mobile)</option>
                    <option value="web">Web Only</option>
                    <option value="mobile">Mobile Only</option>
                </select>
            </div>
            <div class="form-group">
                <label>Link URL</label>
                <input type="text" name="link" id="edit_link" class="form-control">
            </div>
            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="flex:1;">Update Banner</button>
                <button type="button" onclick="document.getElementById('editModal').style.display='none'" class="btn" style="background:#eee; flex:1;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(banner) {
        document.getElementById('editForm').action = "/admin/banners/update/" + banner.id;
        document.getElementById('edit_title').value = banner.title;
        document.getElementById('edit_sub_title').value = banner.sub_title;
        document.getElementById('edit_description').value = banner.description || '';
        document.getElementById('edit_button_text').value = banner.button_text || 'Shop Now';
        document.getElementById('edit_text_color').value = banner.text_color || '#1E0E00';
        document.getElementById('edit_display_on').value = banner.display_on || 'both';
        document.getElementById('edit_link').value = banner.link;
        document.getElementById('editModal').style.display = 'block';
    }
</script>
@endsection
