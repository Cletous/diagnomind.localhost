<div class="container mt-5">
    <h2 class="mb-4">Reviews for {{ $hospital->name }}</h2>

    @if ($reviews->isEmpty())
        <div class="alert alert-warning">No reviews yet for this hospital.</div>
    @else
        @foreach ($reviews as $review)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">⭐ {{ $review->rating }}/5</h5>
                    <p class="card-text">{{ $review->review }}</p>
                    <small class="text-muted">By {{ $review->patient->name ?? 'Anonymous' }} on
                        {{ $review->created_at->format('F j, Y') }}</small>
                </div>
            </div>
        @endforeach

        <div class="mt-4">
            {{ $reviews->links() }}
        </div>
    @endif
</div>
