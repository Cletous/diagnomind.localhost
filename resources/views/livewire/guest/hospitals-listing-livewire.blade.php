<div class="container mt-5">
    <h2 class="mb-4">All Registered Hospitals</h2>

    @if ($hospitals->isEmpty())
        <div class="alert alert-warning">No hospitals found.</div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($hospitals as $hospital)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary">{{ $hospital->name }}</h5>

                            <p class="mb-1">
                                <strong>Address:</strong> {{ $hospital->address ?? 'N/A' }}
                            </p>

                            <p class="mb-1">
                                <strong>Phone:</strong> {{ $hospital->phone ?? 'N/A' }}
                            </p>

                            <p class="mb-1">
                                <strong>Average Rating:</strong>
                                @if ($hospital->reviews_count)
                                    ⭐ {{ number_format($hospital->reviews_avg_rating, 1) }}/5
                                    ({{ $hospital->reviews_count }} review{{ $hospital->reviews_count > 1 ? 's' : '' }})
                                @else
                                    <span class="text-muted">No reviews yet</span>
                                @endif
                            </p>

                            <p class="mb-0">
                                <strong>Doctors:</strong> {{ $hospital->doctors_count }}
                                doctor{{ $hospital->doctors_count !== 1 ? 's' : '' }}
                            </p>
                            <a href="{{ route('hospital.reviews', $hospital->id) }}"
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
            {{ $hospitals->links() }}
        </div>
    @endif
</div>
