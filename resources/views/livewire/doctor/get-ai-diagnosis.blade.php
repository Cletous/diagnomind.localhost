<div class="container mt-4">
    <h3>Get AI Diagnosis</h3>

    @if ($submitted)
        <div class="alert alert-success">Diagnosis submitted successfully.</div>
    @endif

    <form wire:submit.prevent="findPatient" class="mb-4">
        <div class="mb-3">
            <label>Patient National ID</label>
            <input type="text" wire:model="national_id_number" class="form-control" autocomplete="national_id_number">
            @error('national_id_number')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Find Patient</button>
    </form>

    @if ($patient)
        <div class="alert alert-info">
            Patient found: {{ $patient->first_name }} {{ $patient->last_name }} ({{ $patient->email }})
        </div>

        <form wire:submit.prevent="submit">
            <div class="mb-3">
                <label>Symptoms / Prompt</label>
                <textarea wire:model="prompt" class="form-control" rows="5"></textarea>
                @error('prompt')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button class="btn btn-success">Submit to AI</button>
        </form>

        @if ($ai_response)
            <div class="mt-4 p-3 border rounded shadow-sm bg-light">
                <h5>AI Response</h5>
                <p>{{ $ai_response }}</p>
            </div>
        @endif
    @endif
</div>
