@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Manage FAQs</h1>
    <a href="{{ route('admin.faqs.create') }}" class="btn-admin btn-primary" style="text-decoration: none; display: inline-block;">+ Add New FAQ</a>
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
                    <td style="font-weight: 700; width: 30%;">{{ $faq->question }}</td>
                    <td style="width: 55%;">{{ Str::limit($faq->answer, 150) }}</td>
                    <td style="width: 15%;">
                        <a href="{{ route('admin.faqs.edit', $faq->id) }}" style="color: blue; text-decoration: none; margin-right: 15px; font-size: 1.1rem;"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('admin.faqs.delete', $faq->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this FAQ?')">
                            @csrf
                            <button type="submit" style="color: red; border:none; background:none; cursor:pointer; font-size: 1.1rem;"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" style="text-align:center;">No FAQs found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
