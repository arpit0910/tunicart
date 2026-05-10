@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Mailing List</h1>
    <span style="background: var(--primary-color); color: white; padding: 8px 15px; border-radius: 10px; font-weight: 700;">{{ $subscribers->count() }} Subscribers</span>
</div>

<div class="admin-card">
    <table>
        <thead>
            <tr>
                <th>Email Address</th>
                <th>Subscribed On</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subscribers as $sub)
                <tr>
                    <td style="font-weight: 600;">{{ $sub->email }}</td>
                    <td>{{ $sub->created_at->format('d M Y, h:i A') }}</td>
                    <td>
                        <a href="mailto:{{ $sub->email }}" style="color: blue; text-decoration: none; margin-right: 15px;"><i class="fa-solid fa-envelope"></i> Send Email</a>
                        <form action="{{ route('admin.subscribers.delete', $sub->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Remove this email from mailing list?')">
                            @csrf
                            <button type="submit" style="color: red; border:none; background:none; cursor:pointer;"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" style="text-align:center;">No subscribers yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
