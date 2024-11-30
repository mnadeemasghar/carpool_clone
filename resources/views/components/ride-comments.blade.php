<!-- Comment Form -->
<form action="{{ route('comment.store', ['ride_id' => $ride->id]) }}" method="POST" class="d-flex align-items-start mb-3">
    @csrf
    <div class="form-group flex-grow-1 mr-2">
        <input type="text" class="form-control" name="body" placeholder="Write your comment..." />
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Post</button>
    </div>
</form>
<!-- Display Comments Section -->
@if ($ride->comments && $ride->comments->count() > 0)
    <div class="mb-3">
        <h5>Comments</h5>
        @foreach ($ride->comments as $comment)
            <div class="card mb-2">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">{{ $comment->created_at->format('d M Y, H:i') }}</small>
                        <span class="font-weight-bold">{{ $comment->user->name }}</span>
                    </div>
                    <p class="mb-0">{{ $comment->body }}</p>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p>No comments yet</p>
@endif