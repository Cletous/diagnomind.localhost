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

    @if ($createPatientForm && !$patient)
        <div class="alert alert-warning mt-3">
            <strong>No patient found with this ID.</strong> <br>
            Would you like to create one?
        </div>

        <form wire:submit.prevent="createPatient" class="mb-4">
            <div class="mb-3">
                <label>National Id Number</label>
                <input type="text" wire:model.defer="national_id_number" class="form-control">
                @error('national_id_number')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label>First Name</label>
                <input type="text" wire:model.defer="new_patient_first_name" class="form-control">
                @error('new_patient_first_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label>Last Name</label>
                <input type="text" wire:model.defer="new_patient_last_name" class="form-control">
                @error('new_patient_last_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" wire:model.defer="new_patient_email" class="form-control">
                @error('new_patient_email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-outline-success">Create Patient</button>
        </form>
    @endif

    @if ($patient)
        <div class="alert alert-info">
            <div class="text-decoration-underline fw-bold">Patient found:</div>
            <div><span class="fw-bold">Name:</span> {{ $patient->name }}</div>
            <div><span class="fw-bold">Id:</span> {{ $patient->national_id_number }}</div>
            <div><span class="fw-bold">Email:</span> {{ $patient->email }}</div>
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
