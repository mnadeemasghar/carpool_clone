<div>
    <!-- Comment Form -->
    <form wire:submit.prevent="submitComment">
        <div class="input-group">
            <input type="text" class="form-control" wire:model="body" placeholder="Write your comment..." />
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-send"></i>
            </button>
        </div>
        @error('body') 
            <span class="text-danger">{{ $message }}</span> 
        @enderror
    </form>


    <!-- Display Comments Section -->
    @if ($comments && $comments->count() > 0)
        <div class="mb-3">
            <h5>Comments</h5>
            @foreach ($comments as $comment)
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
    @endif
</div>
