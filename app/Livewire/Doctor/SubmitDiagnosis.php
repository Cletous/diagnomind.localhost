<?php

namespace App\Livewire\Doctor;

use App\Models\User;
use App\Models\DiagnosisRequest;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class SubmitDiagnosis extends Component
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
            ->where('role', 'patient')
            ->first();

        if (!$this->patient) {
            $this->addError('national_id_number', 'No patient found with this ID.');
        }
    }

    public function submit()
    {
        $this->validate([
            'prompt' => 'required|string|min:10',
        ]);

        if (!$this->patient) {
            $this->addError('national_id_number', 'Please search for a valid patient first.');
            return;
        }

        // Call AI API
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.huggingface.token'),
        ])->post('https://api-inference.huggingface.co/models/KarmaIncarnate/DistilForMedicalDiagnosis', [
                    'inputs' => $this->prompt,
                ]);

        $this->ai_response = $response['generated_text'] ?? 'No response received.';

        // Save to DB
        DiagnosisRequest::create([
            'doctor_id' => auth()->id(),
            'patient_id' => $this->patient->id,
            'prompt' => $this->prompt,
            'ai_response' => $this->ai_response,
        ]);

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.doctor.submit-diagnosis');
    }
}
