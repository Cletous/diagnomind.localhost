<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        {{-- Logo and brand --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="DiagnoMind Logo" height="40" class="me-2">
        </a>

        {{-- Toggler for mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Navbar links --}}
        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
            @auth
                <a href="{{ route('patient.dashboard') }}" class="btn btn-outline-primary me-2">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
            @endauth
        </div>
    </div>
</nav>
