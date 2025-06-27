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
        <h3>Invite Doctor to Hospital #{{ $hospitalId }}</h3>

        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
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
    @endif
</div>
