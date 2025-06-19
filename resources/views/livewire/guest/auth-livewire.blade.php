<div class="container py-5">
    <div class="row justify-content-center align-items-center">
        {{-- Left side: Logo and pitch --}}
        <div class="col-lg-6 text-center text-lg-start mb-5 mb-lg-0">
            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="DiagnoMind Logo" class="img-fluid mb-4"
                style="max-width: 150px;">
            <h1 class="fw-bold">Welcome to DiagnoMind</h1>
            <p class="text-muted">
                DiagnoMind empowers doctors with AI-powered diagnosis, delivers fast and reliable predictions,
                and helps patients track their medical history anytime, anywhere.
            </p>
        </div>

        {{-- Right side: Form --}}
        <div class="col-lg-6">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    {{-- LOGIN --}}
                    @if ($mode === 'login')
                        <h3 class="mb-4">Login</h3>
                        @if (session()->has('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form wire:submit.prevent="login">
                            <x-auth.input type="email" model="email" label="Email" />
                            <x-auth.password model="password" showModel="show_password" />

                            <button class="btn btn-primary w-100">Login</button>
                            <div class="text-center mt-3">
                                <a href="{{ route('register') }}">Don't have an account? Register</a>
                            </div>
                            <div class="text-center mb-3">
                                <a href="{{ route('forget_password') }}">Forgot Password?</a>
                            </div>
                        </form>

                        {{-- REGISTER --}}
                    @elseif($mode === 'register')
                        <h3 class="mb-4">Register</h3>
                        <form wire:submit.prevent="register">
                            <x-auth.input type="text" model="first_name" label="First Name" />
                            <x-auth.input type="text" model="last_name" label="Last Name" />
                            <x-auth.input type="text" model="national_id_number"
                                label="National ID Number (NNNNNNNNLNN)" />
                            <x-auth.input type="email" model="email" label="Email" />
                            <x-auth.password model="password" showModel="show_password" />
                            <x-auth.password model="password_confirmation" label="Confirm Password"
                                showModel="show_password" />

                            <button class="btn btn-success w-100">Register</button>
                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}">Already have an account? Login</a>
                            </div>
                        </form>

                        {{-- FORGOT PASSWORD --}}
                    @elseif($mode === 'forget_password')
                        <h3 class="mb-4">Reset Your Password</h3>
                        @if (session()->has('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @elseif (session()->has('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form wire:submit.prevent="sendPasswordResetLink">
                            <x-auth.input type="email" model="email" label="Email Address" />
                            <button class="btn btn-primary w-100" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="sendPasswordResetLink">Send Reset Link</span>
                                <span wire:loading wire:target="sendPasswordResetLink">
                                    <span class="spinner-border spinner-border-sm"></span> Sending...
                                </span>
                            </button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}">← Back to login</a>
                        </div>

                        {{-- RESET PASSWORD --}}
                    @elseif($mode === 'reset_password')
                        <h3 class="mb-4">Set New Password</h3>
                        @if (session()->has('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @elseif (session()->has('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form wire:submit.prevent="reset_password">
                            <x-auth.input type="email" model="email" label="Email" readonly />
                            <x-auth.password model="new_password" label="New Password" showModel="show_password" />
                            <x-auth.password model="new_password_confirmation" label="Confirm Password"
                                showModel="show_password" />

                            <button class="btn btn-success w-100">Reset Password</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}">← Back to login</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
