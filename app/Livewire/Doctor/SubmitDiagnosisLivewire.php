<?php

namespace App\Livewire\Doctor;

use App\Models\User;
use App\Models\DiagnosisRequest;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class SubmitDiagnosisLivewire extends Component
{
    public $national_id_number;
    public $patient;
    public $prompt;
    public $ai_response;
    public $submitted = false;

    public function findPatient()
    {
        $this->validate([
            'national_id_number' => 'required|string',
        ]);

        $this->patient = User::where('national_id_number', $this->national_id_number)
            ->first();

        if (!$this->patient) {
            $this->addError('national_id_number', 'No patient found with this ID.');
        }
    }

    public function submit()
    {
        $this->validate([
            'prompt' => 'required|string',
        ]);

        if (!$this->patient) {
            $this->addError('national_id_number', 'Please search for a valid patient first.');
            return;
        }

        // Fetch doctor’s primary hospital (you may enhance this with a dropdown later)
        $hospital = auth()->user()->hospitals()->first();

        if (!$hospital) {
            $this->addError('prompt', 'You are not assigned to any hospital. Please contact admin.');
            return;
        }

        // Call AI API
        $response = Http::post('http://127.0.0.1:8000/predict', [
            'inputs' => $this->prompt,
        ]);

        $this->ai_response = $response->json('prediction') ?? 'No diagnosis returned.';

        // Save to DB
        DiagnosisRequest::create([
            'doctor_id' => auth()->id(),
            'patient_id' => $this->patient->id,
            'prompt' => $this->prompt,
            'ai_response' => $this->ai_response,
            'hospital_id' => $hospital->id, // ✅ Link diagnosis to hospital
        ]);

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.doctor.submit-diagnosis');
    }
}
