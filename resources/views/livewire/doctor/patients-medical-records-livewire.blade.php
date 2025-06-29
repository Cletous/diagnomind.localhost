<div>
    <h2 class="mb-4">My Diagnosed Patients</h2>

    <div class="mb-3">
        <input type="text" class="form-control" placeholder="Search by name, email, or ID..."
            wire:model.live.debounce.10ms="search">
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>National ID</th>
                    <th>Email</th>
                    <th>Medical Records</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                    <tr>
                        <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                        <td>{{ $patient->national_id_number }}</td>
                        <td>{{ $patient->email }}</td>
                        <td>
                            <a href="{{ route('patient.diagnosis.history.with.user', $patient->id) }}"
                                class="btn btn-sm btn-outline-primary">
                                View Medical Records
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No patients found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $patients->links() }}
    </div>
</div>
