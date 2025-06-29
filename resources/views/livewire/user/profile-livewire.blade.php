<div class="container mt-5">
    <h3>My Profile</h3>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="updateProfile" class="mb-4">
        <div class="mb-3">
            <label>First Name</label>
            <input type="text" wire:model.defer="first_name" class="form-control">
            @error('first_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" wire:model.defer="last_name" class="form-control">
            @error('last_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" wire:model.defer="email" class="form-control">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label>National ID Number</label>
            <input type="text" wire:model.defer="national_id_number" class="form-control">
            @error('national_id_number')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>

    {{-- Account Deletion --}}
    <div class="border-top pt-3">
        <h5>Delete Account</h5>

        @if ($confirmingDeletion)
            <form wire:submit.prevent="deleteAccount">
                <p class="text-danger">This action is irreversible. Type <strong>DELETE</strong> to confirm:</p>
                <input type="text" wire:model.defer="confirmDelete" class="form-control w-50 mb-2">
                @error('confirmDelete')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <button type="submit" class="btn btn-danger">Confirm Deletion</button>
            </form>
        @else
            <button wire:click="confirmDeletion" class="btn btn-outline-danger">Delete My Account</button>
        @endif
    </div>
</div>
