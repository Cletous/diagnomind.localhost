<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="DiagnoMind Logo" height="40" class="me-2">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
            @auth
                <a href="{{ route('patient.dashboard') }}" class="btn btn-outline-primary me-2">Patient Dashboard</a>

                @if (auth()->user()->hasRole('doctor'))
                    <a href="{{ route('doctor.dashboard') }}" class="btn btn-outline-secondary me-2">Switch to Doctor</a>
                @endif

                @if (auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark me-2">Switch to Admin</a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
            @endauth
        </div>
    </div>
</nav>
