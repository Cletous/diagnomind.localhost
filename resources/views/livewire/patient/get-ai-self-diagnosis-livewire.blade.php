<div class="container mt-4">
    <h3>AI Self-Diagnosis</h3>

    @if ($submitted)
        <div class="alert alert-success">Diagnosis saved successfully.</div>
    @endif

    <form wire:submit.prevent="submit">
        <div class="mb-3">
            <label>Describe your symptoms</label>
            <textarea wire:model="prompt" class="form-control" rows="5" placeholder="E.g. Fever, cough, sore throat..."></textarea>
            @error('prompt')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label>Select Preferred Hospital (Optional)</label>
            <select wire:model="selected_hospital_id" class="form-select">
                <option value="">-- None --</option>
                @foreach ($hospitals as $hospital)
                    <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                @endforeach
            </select>
            @error('selected_hospital_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button class="btn btn-primary">Get AI Diagnosis</button>
    </form>

    @if ($ai_response)
        <div class="mt-4 p-3 border rounded shadow-sm bg-light">
            <h5>AI Response</h5>
            <p>{{ $ai_response }}</p>
        </div>
    @endif
</div>
