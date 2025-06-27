<div class="container py-4">
    @if ($mode === 'index')
        <h3>Your Hospitals</h3>
        <a href="{{ route('doctor.hospitals.create') }}" class="btn btn-primary btn-sm mb-3">+ Create Hospital</a>
        <ul class="list-group">
            @forelse($hospitals as $hospital)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ $hospital->name }}</span>
                    <div>
                        <a href="{{ route('doctor.hospitals.edit', $hospital) }}"
                            class="btn btn-outline-secondary btn-sm">Edit</a>
                        <a href="{{ route('doctor.hospitals.invite', $hospital) }}"
                            class="btn btn-outline-primary btn-sm">Invite Doctors</a>
                    </div>
                </li>
            @empty
                <li class="list-group-item">You are not associated with any hospitals yet.</li>
            @endforelse
        </ul>
    @elseif ($mode === 'create' || $mode === 'edit')
        <h3>{{ $mode === 'create' ? 'Create Hospital' : 'Edit Hospital' }}</h3>
        <form wire:submit.prevent="{{ $mode === 'create' ? 'store' : 'update' }}">
            <div class="mb-3">
                <label class="form-label">Hospital Name</label>
                <input type="text" wire:model.defer="name" class="form-control">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea wire:model.defer="address" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-success">{{ $mode === 'create' ? 'Create' : 'Update' }}</button>
        </form>
    @elseif ($mode === 'invite')
        <h3>Invite Doctor to Hospital: {{ $hospital->name }}</h3>

        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form wire:submit.prevent="invite" class="mt-3">
            <div class="mb-3">
                <label class="form-label">Doctor's Email</label>
                <input type="email" wire:model.defer="inviteEmail" class="form-control"
                    placeholder="doctor@example.com">
                @error('inviteEmail')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Send Invite</button>
            <a href="{{ route('doctor.hospitals.index') }}" class="btn btn-secondary ms-2">Back</a>
        </form>

        {{-- List of Invited Doctors --}}
        <div class="mt-5">
            <h5>Doctors Assigned to This Hospital</h5>
            @if ($invitedDoctors && count($invitedDoctors))
                <table class="table table-bordered table-sm mt-3">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Doctor Name</th>
                            <th>Email</th>
                            <th>Joined</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($invitedDoctors as $index => $doctor)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $doctor->first_name }} {{ $doctor->last_name }}</td>
                                <td>{{ $doctor->email }}</td>
                                <td>{{ $doctor->created_at->diffForHumans() }}</td>
                                <td>
                                    <button wire:click="removeDoctor({{ $doctor->id }})"
                                        class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to remove this doctor?')"
                                        @if ($doctor->id === auth()->id()) disabled @endif>
                                        Remove
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            @else
                <p class="text-muted mt-3">No doctors have been invited to this hospital yet.</p>
            @endif
        </div>
    @endif
</div>
