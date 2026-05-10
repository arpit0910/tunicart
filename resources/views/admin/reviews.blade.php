@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1>Product Reviews</h1>
</div>

<div class="admin-card">
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>User</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reviews as $review)
                <tr>
                    <td>{{ $review->product->name }}</td>
                    <td>{{ $review->user->name }}</td>
                    <td>
                        <div style="color: var(--accent-color);">
                            @for($i=0; $i<$review->rating; $i++) <i class="fa-solid fa-star"></i> @endfor
                        </div>
                    </td>
                    <td><small>{{ $review->comment }}</small></td>
                    <td>{{ $review->created_at->format('M d, Y') }}</td>
                    <td>
                        <form action="{{ route('admin.reviews.delete', $review->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this review?')">
                            @csrf
                            <button type="submit" style="color: red; border:none; background:none; cursor:pointer;"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
