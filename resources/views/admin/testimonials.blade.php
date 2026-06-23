@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Manage Testimonials</h1>
    <a href="{{ route('admin.testimonials.create') }}" class="btn-admin btn-primary" style="text-decoration: none; display: inline-block;">+ Add New Testimonial</a>
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
                    <td>
                        @if($test->image)
                            <img src="{{ asset('storage/'.$test->image) }}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                        @else
                            <div style="width: 50px; height: 50px; border-radius: 50%; background: #eee; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; font-weight: 700; color: #aaa;">
                                {{ strtoupper(substr($test->user_name, 0, 1)) }}
                            </div>
                        @endif
                    </td>
                    <td>{{ $test->user_name }}</td>
                    <td>{{ $test->rating }}/5</td>
                    <td>{{ Str::limit($test->content, 50) }}</td>
                    <td>
                        <a href="{{ route('admin.testimonials.edit', $test->id) }}" style="color: blue; text-decoration: none; margin-right: 15px; font-size: 1.1rem;"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('admin.testimonials.delete', $test->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this testimonial?')">
                            @csrf
                            <button type="submit" style="color: red; border:none; background:none; cursor:pointer; font-size: 1.1rem;"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;">No testimonials found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
