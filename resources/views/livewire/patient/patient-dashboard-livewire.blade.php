<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold">Welcome, {{ auth()->user()->first_name }} 👋</h2>
            <p class="text-muted">Here’s a quick overview of your diagnosis activity. {{ sss }}</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Card: Total Diagnoses -->
        <div class="col-md-4">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary">Total Diagnoses</h5>
                    <h2 class="fw-bold">{{ $totalDiagnoses }}</h2>
                </div>
            </div>
        </div>

        <!-- Card: Most Visited Hospital -->
        <div class="col-md-4">
            <div class="card border-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success">Most Visited Hospital</h5>
                    <p class="fw-bold">{{ $mostVisitedHospital ?? '—' }}</p>
                </div>
            </div>
        </div>

        <!-- Card: Feedback Given -->
        <div class="col-md-4">
            <div class="card border-info shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-info">Feedback Submitted</h5>
                    <h2 class="fw-bold">{{ $feedbackCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h4 class="mb-3">Recent Diagnoses</h4>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Hospital</th>
                        <th>Symptoms</th>
                        <th>AI Diagnosis</th>
                        <th>Rated</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentDiagnoses as $index => $diagnosis)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $diagnosis->hospital->name ?? '—' }}</td>
                            <td>{{ Str::limit($diagnosis->prompt, 30) }}</td>
                            <td>{{ Str::limit($diagnosis->ai_response, 30) }}</td>
                            <td>
                                @if ($diagnosis->rating === 'like')
                                    👍
                                @elseif($diagnosis->rating === 'dislike')
                                    👎
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $diagnosis->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No diagnoses yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
