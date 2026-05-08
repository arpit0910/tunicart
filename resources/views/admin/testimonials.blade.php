@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Manage Testimonials</h1>
    <button onclick="document.getElementById('addModal').style.display='block'" class="btn btn-primary">+ Add New Testimonial</button>
</div>

<div class="admin-card">
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Rating</th>
                <th>Content</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($testimonials as $test)
                <tr>
                    <td><img src="{{ asset('storage/'.$test->image) }}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;"></td>
                    <td>{{ $test->user_name }}</td>
                    <td>{{ $test->rating }}/5</td>
                    <td>{{ Str::limit($test->content, 50) }}</td>
                    <td>
                        <button onclick="openEditModal({{ json_encode($test) }})" style="color: blue; border:none; background:none; cursor:pointer; margin-right: 15px;"><i class="fa-solid fa-pen"></i></button>
                        <form action="{{ route('admin.testimonials.delete', $test->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this testimonial?')">
                            @csrf
                            <button type="submit" style="color: red; border:none; background:none; cursor:pointer;"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;">No testimonials found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div id="addModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; width:500px; margin:100px auto; padding:40px; border-radius:15px;">
        <h2>Add Testimonial</h2>
        <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>User Image</label>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="form-group">
                <label>User Name</label>
                <input type="text" name="user_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Rating (1-5)</label>
                <input type="number" name="rating" min="1" max="5" value="5" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Testimonial Content</label>
                <textarea name="content" class="form-control" rows="3" required></textarea>
            </div>
            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="flex:1;">Save Testimonial</button>
                <button type="button" onclick="document.getElementById('addModal').style.display='none'" class="btn" style="background:#eee; flex:1;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; width:500px; margin:100px auto; padding:40px; border-radius:15px;">
        <h2>Edit Testimonial</h2>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>User Image (Leave blank to keep current)</label>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="form-group">
                <label>User Name</label>
                <input type="text" name="user_name" id="edit_user_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Rating (1-5)</label>
                <input type="number" name="rating" id="edit_rating" min="1" max="5" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Testimonial Content</label>
                <textarea name="content" id="edit_content" class="form-control" rows="3" required></textarea>
            </div>
            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="flex:1;">Update Testimonial</button>
                <button type="button" onclick="document.getElementById('editModal').style.display='none'" class="btn" style="background:#eee; flex:1;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(testimonial) {
        document.getElementById('editForm').action = "/admin/testimonials/update/" + testimonial.id;
        document.getElementById('edit_user_name').value = testimonial.user_name;
        document.getElementById('edit_rating').value = testimonial.rating;
        document.getElementById('edit_content').value = testimonial.content;
        document.getElementById('editModal').style.display = 'block';
    }
</script>
@endsection
