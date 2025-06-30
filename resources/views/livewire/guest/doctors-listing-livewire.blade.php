<div class="container mt-5">
    <h2 class="mb-4">All Registered Doctors</h2>

    @if ($doctors->isEmpty())
        <div class="alert alert-warning">No doctors found.</div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($doctors as $doctor)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary">
                                {{ $doctor->first_name }} {{ $doctor->last_name }}
                            </h5>

                            <p class="mb-1"><strong>Email:</strong> {{ $doctor->email }}</p>

                            <p class="mb-1">
                                <strong>Rating:</strong>
                                @if ($doctor->doctor_reviews_count)
                                    ⭐ {{ number_format($doctor->doctor_reviews_avg_rating, 1) }}/5
                                    ({{ $doctor->doctor_reviews_count }}
                                    review{{ $doctor->doctor_reviews_count > 1 ? 's' : '' }})
                                @else
                                    <span class="text-muted">No reviews yet</span>
                                @endif
                            </p>
                            <a href="{{ route('doctor.reviews', $doctor->id) }}"
                                class="btn btn-outline-primary btn-sm mt-2">
                                View Reviews
                            </a>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $doctors->links() }}
        </div>
    @endif
</div>
