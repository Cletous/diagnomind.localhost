<nav class="navbar navbar-light bg-light shadow-sm">
    <div class="container">
        {{-- Logo --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="DiagnoMind Logo" height="40" class="me-2">
        </a>

        {{-- Offcanvas toggle --}}
        <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#patientMenu"
            aria-controls="patientMenu">
            <i class="bi bi-list"></i> Menu
        </button>
    </div>
</nav>

{{-- Offcanvas --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="patientMenu" aria-labelledby="patientMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="patientMenuLabel">Patient Navigation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        @auth
            <a href="{{ route('patient.dashboard') }}" class="btn btn-outline-primary w-100 mb-2">Patient Dashboard</a>

            <a href="{{ route('patient.diagnosis.history') }}" class="btn btn-outline-primary w-100 mb-2">Diagnosis
                History</a>

            @if (auth()->user()->hasRole('doctor'))
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-outline-secondary w-100 mb-2">Switch to Doctor</a>
            @endif

            @if (auth()->user()->hasRole('admin'))
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark w-100 mb-2">Switch to Admin</a>
            @endif

            <form method="POST" action="{{ route('logout') }}" class="d-grid mt-3">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-outline-primary w-100 mb-2">Login</a>
            <a href="{{ route('register') }}" class="btn btn-primary w-100">Register</a>
        @endauth
    </div>
</div>
