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
                <label>Select Hospital</label>
                <select wire:model="selected_hospital_id" class="form-select">
                    <option value="">-- Choose Hospital --</option>
                    @foreach ($hospitals as $hospital)
                        <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                    @endforeach
                </select>
                @error('selected_hospital_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

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

            <form wire:submit.prevent="submitDiagnosisAndComment" class="mt-3">
                <div class="mb-3">
                    <label>Doctor's Comment (Optional)</label>
                    <textarea wire:model="comment" class="form-control" rows="3"
                        placeholder="Add your opinion based on patient's condition..."></textarea>
                    @error('comment')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button class="btn btn-primary">Finalize Diagnosis</button>
            </form>
        @endif

    @endif

</div>
