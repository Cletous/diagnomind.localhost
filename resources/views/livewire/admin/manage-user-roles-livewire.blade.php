<div class="container py-4">
    <h2 class="fw-bold mb-4">Manage User Roles</h2>

    <!-- Role Filter -->
    <div class="mb-3 row">
        <label for="roleFilter" class="col-sm-2 col-form-label">Filter by Role:</label>
        <div class="col-sm-4">
            <select wire:model.live.debounce.10ms="filterRole" id="roleFilter" class="form-select">
                <option value="all">All</option>
                <option value="admin">Admins</option>
                <option value="doctor">Doctors</option>
                <option value="patient">Patients</option>
            </select>
        </div>
    </div>

    <!-- User Table -->
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
                        <td>{{ ($users->firstItem() ?? 0) + $index }}</td>
                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->national_id_number }}</td>
                        <td>
                            @foreach ($user->roles as $role)
                                <span class="badge bg-secondary me-1">{{ ucfirst($role->name) }}</span>
                            @endforeach
                        </td>
                        <td>
                            @if ($user->hasRole('doctor'))
                                <button wire:click="confirmRoleRemoval({{ $user->id }}, 'doctor')"
                                    class="btn btn-sm btn-outline-danger me-2">Revoke Doctor</button>
                            @else
                                <button wire:click="assignRole({{ $user->id }}, 'doctor')"
                                    class="btn btn-sm btn-outline-success me-2">Make Doctor</button>
                            @endif

                            @if ($user->hasRole('admin'))
                                <button wire:click="confirmRoleRemoval({{ $user->id }}, 'admin')"
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

        <div class="mt-3">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>

    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade @if ($confirmingRemoval) show d-block @endif" tabindex="-1"
        style="background-color: rgba(0,0,0,0.5);" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title">Confirm Role Removal</h5>
                    <button type="button" class="btn-close" wire:click="cancelRemoval"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to <strong>remove</strong> the role <span
                            class="text-danger fw-bold">{{ $removalRole }}</span> from this user?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" wire:click="cancelRemoval">Cancel</button>
                    <button class="btn btn-danger" wire:click="removeRoleConfirmed">Yes, Remove</button>
                </div>
            </div>
        </div>
    </div>
</div>
