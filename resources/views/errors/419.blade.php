<x-layouts.blank.app>
    <div class="container py-5 text-center">
        <h1 class="display-1 text-secondary">419</h1>
        <p class="lead">Session Expired – Your prescription ran out ⏳</p>
        <p class="text-muted">This form’s dosage expired. Please reload and try again.</p>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mt-3">
            Refill Prescription (Go Back)
        </a>
    </div>
</x-layouts.blank.app>
