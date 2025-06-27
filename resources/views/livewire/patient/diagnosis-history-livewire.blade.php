<div class="container mt-4">
    <h3 class="mb-3">Your Diagnosis History</h3>

    {{-- Filters --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <label for="hospitalFilter">Filter by Hospital:</label>
            <select wire:model="hospitalFilter" class="form-select">
                <option value="">-- All Hospitals --</option>
                @foreach ($hospitals as $hospital)
                    <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label for="dateFilter">Filter by Date:</label>
            <input type="date" wire:model="dateFilter" class="form-control" />
        </div>
    </div>

    {{-- Diagnoses List --}}
    @forelse ($diagnoses as $diagnosis)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $diagnosis->prompt }}</h5>
                <p class="card-text">
                    <strong>Doctor:</strong>
                    <a href="#">{{ $diagnosis->doctor->first_name }} {{ $diagnosis->doctor->last_name }}</a><br>
                    <strong>Hospital:</strong>
                    <a href="#">{{ $diagnosis->hospital->name ?? 'N/A' }}</a><br>
                    <strong>Diagnosis:</strong> {{ $diagnosis->ai_response }}<br>
                    <strong>Rating:</strong>
                    @if ($diagnosis->rating === 'like')
                        👍 Liked
                    @elseif($diagnosis->rating === 'dislike')
                        👎 Disliked
                    @else
                        Not Rated
                    @endif
                    <br>
                    <small class="text-muted">Submitted {{ $diagnosis->created_at->diffForHumans() }}</small>
                </p>

                {{-- Optional feedback display --}}
                @if ($diagnosis->feedback)
                    <div class="mt-2">
                        <strong>Your Feedback:</strong>
                        <p>{{ $diagnosis->feedback->comment }}</p>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <p class="text-muted">You have no past diagnoses yet.</p>
    @endforelse
</div>
