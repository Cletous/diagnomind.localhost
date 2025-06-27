<div class="container mt-4">
    <h3>Your Diagnosis History</h3>

    @forelse ($diagnoses as $diagnosis)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $diagnosis->prompt }}</h5>
                <p class="card-text">
                    <strong>Doctor:</strong> {{ $diagnosis->doctor->first_name }}
                    {{ $diagnosis->doctor->last_name }}<br>
                    <strong>Hospital:</strong> {{ $diagnosis->hospital->name ?? 'N/A' }}<br>
                    <strong>Diagnosis:</strong> {{ $diagnosis->ai_response }}<br>
                    <small class="text-muted">Submitted {{ $diagnosis->created_at->diffForHumans() }}</small>
                </p>
            </div>
        </div>
    @empty
        <p class="text-muted">You have no past diagnoses yet.</p>
    @endforelse
</div>
