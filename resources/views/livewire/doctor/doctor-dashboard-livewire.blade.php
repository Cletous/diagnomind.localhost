<div class="container py-4">
    {{-- Welcome Banner --}}
    <div class="alert alert-primary d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0">Welcome, Dr. {{ auth()->user()->first_name }}!</h4>
            <small class="text-muted">Here’s your overview dashboard.</small>
        </div>
        <div>
            <a href="{{ route('doctor.hospitals.create') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-hospital"></i> Create New Hospital
            </a>
        </div>
    </div>

    {{-- Stats Section --}}
    <div class="row g-4 mt-2">
        <div class="col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title text-primary">Hospitals</h5>
                        <h3 class="fw-bold">{{ $hospitalCount ?? 0 }}</h3>
                    </div>
                    <i class="bi bi-building text-primary fs-1"></i>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('doctor.hospitals.index') }}" class="btn btn-link btn-sm">Manage Hospitals</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title text-success">Diagnosed Patients</h5>
                        <h3 class="fw-bold">{{ $diagnosedPatientsCount ?? 0 }}</h3>
                    </div>
                    <i class="bi bi-people-fill text-success fs-1"></i>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('doctor.submit.diagnosis') }}" class="btn btn-link btn-sm">Submit New
                        Diagnosis</a>
                </div>
            </div>
        </div>
    </div>
</div>
