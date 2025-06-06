<div class="container mt-4">
    <h2 class="mb-4">Your Diagnosis History</h2>

    @if ($diagnoses->isEmpty())
        <p>No diagnosis records found.</p>
    @else
        <div class="list-group">
            @foreach ($diagnoses as $diagnosis)
                <div class="list-group-item mb-3 border rounded shadow-sm p-3">
                    <h5>Seen by Dr. {{ $diagnosis->doctor->first_name }} {{ $diagnosis->doctor->last_name }}</h5>
                    <p><strong>Condition:</strong> {{ $diagnosis->prompt }}</p>
                    <p><strong>AI Response:</strong> {{ $diagnosis->ai_response }}</p>
                    <p>
                        <strong>Rating:</strong>
                        @if ($diagnosis->rating === 'like')
                            👍 Liked by Doctor
                        @elseif($diagnosis->rating === 'dislike')
                            👎 Disliked by Doctor
                        @else
                            Not Rated Yet
                        @endif
                    </p>
                    <small class="text-muted">Diagnosed on {{ $diagnosis->created_at->format('F j, Y, g:i a') }}</small>
                </div>
            @endforeach
        </div>
    @endif
</div>
