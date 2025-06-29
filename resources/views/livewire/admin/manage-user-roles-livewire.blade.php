<div class="container py-4">
    <h2 class="fw-bold mb-4">Manage User Roles 🧑‍⚕️</h2>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>National ID</th>
                    <th>Roles</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->national_id_number }}</td>
                        <td>
                            @foreach ($user->roles as $role)
                                <span class="badge bg-secondary me-1">{{ ucfirst($role->name) }}</span>
                            @endforeach
                        </td>
                        <td>
                            <!-- Toggle doctor role -->
                            @if ($user->hasRole('doctor'))
                                <button wire:click="removeRole({{ $user->id }}, 'doctor')"
                                    class="btn btn-sm btn-outline-danger me-2">Revoke Doctor</button>
                            @else
                                <button wire:click="assignRole({{ $user->id }}, 'doctor')"
                                    class="btn btn-sm btn-outline-success me-2">Make Doctor</button>
                            @endif

                            <!-- Toggle admin role -->
                            @if ($user->hasRole('admin'))
                                <button wire:click="removeRole({{ $user->id }}, 'admin')"
                                    class="btn btn-sm btn-outline-danger">Revoke Admin</button>
                            @else
                                <button wire:click="assignRole({{ $user->id }}, 'admin')"
                                    class="btn btn-sm btn-outline-primary">Make Admin</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
