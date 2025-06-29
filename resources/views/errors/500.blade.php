<x-layouts.blank.app>
    <div class="container py-5 text-center">
        <h1 class="display-1 text-danger">500</h1>
        <p class="lead">Yikes! Our server just flatlined 💀</p>
        <p class="text-muted">We're calling in the dev doctors to diagnose the issue.</p>
        <p class="text-danger"> {{ $exception->getMessage() }}</p>
        <a href="{{ route('home') }}" class="btn btn-outline-danger mt-3">
            Back to Operating Room (Home)
        </a>
    </div>
</x-layouts.blank.app>
