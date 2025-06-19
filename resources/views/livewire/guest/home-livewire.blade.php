<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-primary">Welcome to DiagnoMind</h1>
        <p class="lead text-secondary">AI-Powered Medical Diagnosis at Your Fingertips</p>
    </div>

    <div class="row align-items-center">
        <div class="col-md-6 mb-4">
            <img src="{{ asset('assets/img/ai-diagnosis-illustration.png') }}" alt="AI Diagnosis Illustration"
                class="img-fluid rounded shadow-sm">
        </div>
        <div class="col-md-6">
            <h2 class="fw-semibold">Empowering Doctors with AI</h2>
            <p class="text-muted">DiagnoMind allows registered doctors to enter symptoms and receive AI-powered
                diagnosis predictions using a fine-tuned DistilBERT model.</p>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <i class="bi bi-cpu me-2 text-primary"></i> Fast and accurate prediction
                </li>
                <li class="list-group-item">
                    <i class="bi bi-bar-chart-line me-2 text-primary"></i> Save and review diagnosis history
                </li>
                <li class="list-group-item">
                    <i class="bi bi-chat-dots me-2 text-primary"></i> Doctor feedback to improve results
                </li>
                <li class="list-group-item">
                    <i class="bi bi-person-badge me-2 text-primary"></i> Patients view their diagnosis anytime
                </li>
            </ul>

            @if (auth()->check())
                <a href="{{ route(name: 'patient.dashboard') }}" class="btn btn-primary mt-4">Dashboard</a>
                <a href="{{ route(name: 'doctor.submit.diagnosis') }}" class="btn btn-outline-primary mt-4">Diagnose
                    Patients</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary mt-4">Login to Start Diagnosing</a>
            @endif
        </div>
    </div>

    <div class="mt-5 text-center">
        <h3 class="mb-3">Secure. Smart. Scalable.</h3>
        <p class="text-muted">Your data is safe and your insights are smarter with DiagnoMind.</p>
    </div>
</div>
