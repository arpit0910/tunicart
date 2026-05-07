@extends('admin.layout')

@section('content')
<h1 style="margin-bottom: 30px;">User Queries</h1>

<div class="admin-card">
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($queries as $query)
                <tr>
                    <td>{{ $query->created_at->format('M d, H:i') }}</td>
                    <td>
                        <strong>{{ $query->name }}</strong><br>
                        <small>{{ $query->email }}</small>
                    </td>
                    <td>{{ $query->subject }}</td>
                    <td><div style="max-width: 300px; white-space: normal;">{{ $query->message }}</div></td>
                    <td>
                        <span style="padding: 5px 10px; border-radius: 5px; font-size: 0.8rem; font-weight: 700; background: 
                            {{ $query->status == 'replied' ? '#dcfce7' : '#fef3c7' }};
                            color: {{ $query->status == 'replied' ? '#166534' : '#92400e' }};">
                            {{ strtoupper($query->status) }}
                        </span>
                    </td>
                    <td>
                        @if($query->status == 'pending')
                            <form action="{{ route('admin.queries.update-status', $query->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.7rem;">Mark Replied</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
