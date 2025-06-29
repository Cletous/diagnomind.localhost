<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold">Admin Dashboard</h2>
            <p class="text-muted">System overview and user role management</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-primary">Total Users</h6>
                    <h2 class="fw-bold">{{ $userCount }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-success shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-success">Doctors</h6>
                    <h2 class="fw-bold">{{ $doctorCount }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-info shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-info">Patients</h6>
                    <h2 class="fw-bold">{{ $patientCount }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-warning shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-warning">Hospitals</h6>
                    <h2 class="fw-bold">{{ $hospitalCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Role Summary -->
    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h4 class="mb-0">User Roles Overview</h4>

            <div class="d-flex flex-wrap gap-2 align-items-center">
                <input type="text" wire:model.live.debounce.10ms="search" placeholder="Search by name, ID, or phone"
                    class="form-control" style="min-width: 250px;">
                <button wire:click="toggleUserList" class="btn btn-outline-primary">
                    {{ $showAllUsers ? 'Show Latest 10' : 'Show All Users' }}
                </button>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Id Number</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->national_id_number }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach ($user->roles as $role)
                                    <span class="badge bg-secondary me-1">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($showAllUsers && $users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="mt-3">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            @endif

        </div>
    </div>

</div>
