<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        {{-- Brand Logo --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="DiagnoMind Logo" height="40" class="me-2">
        </a>

        {{-- Mobile Toggle --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarGuestMenu"
            aria-controls="navbarGuestMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Navbar Content --}}
        <div class="collapse navbar-collapse justify-content-end" id="navbarGuestMenu">
            <ul class="navbar-nav mb-2 mb-lg-0">
                {{-- Static Guest Links --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold text-primary' : '' }}"
                        href="{{ route('home') }}">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('hospitals') ? 'active fw-bold text-primary' : '' }}"
                        href="{{ route('hospitals') }}">
                        Hospitals
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('doctors') ? 'active fw-bold text-primary' : '' }}"
                        href="{{ route('doctors') }}">
                        Doctors
                    </a>
                </li>
            </ul>

            {{-- Auth Buttons --}}
            <div class="d-flex">
                @auth
                    <a href="{{ route('patient.dashboard') }}" class="btn btn-outline-primary me-2">Dashboard</a>
                    <a href="{{ route('profile') }}" class="btn btn-primary me-2">My Profile</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
