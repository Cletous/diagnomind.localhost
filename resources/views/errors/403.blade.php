<x-layouts.blank.app>
    <div class="container py-5 text-center">
        <h1 class="display-1 text-warning">403</h1>
        <p class="lead">Access Denied – You’re not cleared for surgery 🛑</p>
        <p class="text-muted">Only authorized personnel can enter this ward. {{ $exception->getMessage() }}</p>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary mt-3">
            Back to Reception (Home)
        </a>
    </div>
</x-layouts.blank.app>
