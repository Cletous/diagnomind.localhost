<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            @if ($mode === 'login')
                <h3 class="mb-4">Login</h3>
                @if (session()->has('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form wire:submit.prevent="login">
                    <div class="mb-3">
                        <input type="email" wire:model.defer="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <input type="{{ $show_password ? 'text' : 'password' }}" wire:model.defer="password"
                            class="form-control" placeholder="Password" required>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox"
                                wire:model.live.debounce.10ms="show_password" id="showPassword">
                            <label class="form-check-label" for="showPassword">Show password</label>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100">Login</button>
                    <div class="text-center mt-3">
                        <a href="{{ route('register') }}">Don't have an account? Register</a>
                    </div>
                </form>
            @elseif($mode === 'register')
                <h3 class="mb-4">Register</h3>
                <form wire:submit.prevent="register">
                    <div class="mb-3">
                        <input type="text" wire:model.defer="first_name" class="form-control"
                            placeholder="First Name" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" wire:model.defer="last_name" class="form-control" placeholder="Last Name"
                            required>
                    </div>
                    <div class="mb-3">
                        <input type="text" wire:model.defer="national_id_number" class="form-control"
                            placeholder="National ID Number" required>
                    </div>
                    <div class="mb-3">
                        <select wire:model.defer="role" class="form-select" required>
                            <option value="patient">Patient</option>
                            <option value="doctor">Doctor</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="email" wire:model.defer="email" class="form-control" placeholder="Email"
                            required>
                    </div>
                    <div class="mb-3">
                        <input type="{{ $show_password ? 'text' : 'password' }}" wire:model.defer="password"
                            class="form-control" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <input type="{{ $show_password ? 'text' : 'password' }}"
                            wire:model.defer="password_confirmation" class="form-control" placeholder="Confirm Password"
                            required>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox"
                                wire:model.live.debounce.10ms="show_password" id="showPasswordReg">
                            <label class="form-check-label" for="showPasswordReg">Show password</label>
                        </div>
                    </div>
                    <button class="btn btn-success w-100">Register</button>
                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}">Already have an account? Login</a>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
