@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Manage FAQs</h1>
    <button onclick="document.getElementById('addModal').style.display='block'" class="btn btn-primary">+ Add New FAQ</button>
</div>

<div class="admin-card">
    <table>
        <thead>
            <tr>
                <th>Question</th>
                <th>Answer</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($faqs as $faq)
                <tr>
                    <td style="font-weight: 700;">{{ $faq->question }}</td>
                    <td>{{ Str::limit($faq->answer, 100) }}</td>
                    <td>
                        <button onclick="openEditModal({{ json_encode($faq) }})" style="color: blue; border:none; background:none; cursor:pointer; margin-right: 15px;"><i class="fa-solid fa-pen"></i></button>
                        <form action="{{ route('admin.faqs.delete', $faq->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this FAQ?')">
                            @csrf
                            <button type="submit" style="color: red; border:none; background:none; cursor:pointer;"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" style="text-align:center;">No FAQs found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div id="addModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; width:600px; margin:100px auto; padding:40px; border-radius:15px;">
        <h2>Add FAQ</h2>
        <form action="{{ route('admin.faqs.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Question</label>
                <input type="text" name="question" class="form-control" required placeholder="What is your return policy?">
            </div>
            <div class="form-group">
                <label>Answer</label>
                <textarea name="answer" class="form-control" rows="5" required placeholder="Enter detailed answer here..."></textarea>
            </div>
            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="flex:1;">Save FAQ</button>
                <button type="button" onclick="document.getElementById('addModal').style.display='none'" class="btn" style="background:#eee; flex:1;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; width:600px; margin:100px auto; padding:40px; border-radius:15px;">
        <h2>Edit FAQ</h2>
        <form id="editForm" method="POST">
            @csrf
            <div class="form-group">
                <label>Question</label>
                <input type="text" name="question" id="edit_question" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Answer</label>
                <textarea name="answer" id="edit_answer" class="form-control" rows="5" required></textarea>
            </div>
            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="flex:1;">Update FAQ</button>
                <button type="button" onclick="document.getElementById('editModal').style.display='none'" class="btn" style="background:#eee; flex:1;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(faq) {
        document.getElementById('editForm').action = "/admin/faqs/update/" + faq.id;
        document.getElementById('edit_question').value = faq.question;
        document.getElementById('edit_answer').value = faq.answer;
        document.getElementById('editModal').style.display = 'block';
    }
</script>
@endsection
