<div class="container mt-4">
    @if ($user->id === auth()->id())
        <h3 class="mb-3">Your Diagnosis History</h3>
    @else
        <div class="mb-3">
            <h3 class="mb-1">
                Diagnosis History for {{ $user->first_name }} {{ $user->last_name }}
            </h3>
            <p class="mb-0 text-muted">
                <strong>Email:</strong> {{ $user->email }} <br>
                <strong>National ID:</strong> {{ $user->national_id_number }}
            </p>
        </div>
    @endif

    {{-- Filters --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <label for="hospitalFilter">Filter by Hospital:</label>
            <select wire:model.live.debounce.10ms="hospitalFilter" class="form-select">
                <option value="">-- All Hospitals --</option>
                @foreach ($hospitals as $hospital)
                    <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label for="dateFilter">Filter by Date:</label>
            <input type="date" wire:model.live.debounce.10ms="dateFilter" class="form-control" />
        </div>
    </div>

    {{-- Diagnoses List --}}
    @forelse ($diagnoses as $diagnosis)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $diagnosis->prompt }}</h5>
                <p class="card-text">
                    <strong>Doctor:</strong>
                    <a href="#">{{ $diagnosis->doctor?->name ?? 'Self AI-Diagnosis' }}</a><br>
                    <strong>Hospital:</strong>
                    <a href="#">{{ $diagnosis->hospital->name ?? 'N/A' }}</a><br>
                    <strong>AI Diagnosis:</strong> {{ $diagnosis->ai_response }}<br>
                    {{-- Doctor’s comment --}}
                    @if ($diagnosis->feedback)
                        <div class="mt-3">
                            <strong>Doctor’s Comment(s):</strong>
                            <p class="mb-1">{{ $diagnosis->feedback->comment }}</p>
                            <small class="text-muted">Submitted on
                                {{ $diagnosis->feedback->created_at->format('D, d M Y @ h:i a') }}</small>
                        </div>
                    @endif
                    <strong>Rating:</strong>
                    @if ($user->id === auth()->id())
                        @if ($diagnosis->rating === 'like')
                            👍 Liked
                        @elseif($diagnosis->rating === 'dislike')
                            👎 Disliked
                        @else
                            Not Rated
                        @endif

                        <div class="mt-2">
                            <button wire:click="likeDiagnosis({{ $diagnosis->id }})"
                                class="btn btn-sm btn-outline-success me-1">
                                👍 Like
                            </button>
                            <button wire:click="dislikeDiagnosis({{ $diagnosis->id }})"
                                class="btn btn-sm btn-outline-danger">
                                👎 Dislike
                            </button>
                        </div>
                    @else
                        @if ($diagnosis->rating === 'like')
                            👍 Liked
                        @elseif($diagnosis->rating === 'dislike')
                            👎 Disliked
                        @else
                            Not Rated
                        @endif
                    @endif

                    <br>
                    <small class="text-muted">Diagnosed on:
                        {{ $diagnosis->created_at->format('D, d M Y @ h:i a') }}</small>
                </p>

                {{-- Feedback Button --}}
                <button class="btn btn-sm btn-outline-primary mt-2"
                    wire:click="$emit('openFeedbackModal', {{ $diagnosis->id }})">
                    Rate / Feedback
                </button>
            </div>
        </div>
    @empty
        <p class="text-muted">You have no past diagnoses yet.</p>
    @endforelse

    {{-- Include feedback modal component at the bottom of the page --}}
    @livewire('patient.diagnosis-feedback-livewire')

</div>
