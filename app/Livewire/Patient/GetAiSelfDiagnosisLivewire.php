<?php

namespace App\Livewire\Patient;

use App\Models\DiagnosisRequest;
use App\Models\Hospital;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class GetAiSelfDiagnosisLivewire extends Component
{
    public $prompt;
    public $ai_response;
    public $selected_hospital_id;
    public $submitted = false;

    public $hospitals = [];

    public $title = 'AI Self-Diagnosis';

    public function mount()
    {
        $this->hospitals = Hospital::orderBy('name')->get();
    }

    public function submit()
    {
        $this->validate([
            'prompt' => 'required|string',
            'selected_hospital_id' => 'nullable|exists:hospitals,id',
        ], [], ['selected_hospital_id' => 'hospital']);

        // Check if patient has already submitted today
        $alreadySubmitted = DiagnosisRequest::where('patient_id', auth()->id())
            ->whereNull('doctor_id') // only self-diagnoses
            ->whereDate('created_at', now()->toDateString())
            ->exists();

        if ($alreadySubmitted) {
            $this->addError('prompt', 'You can only get a maximum of one AI diagnosis per day. Please try again tomorrow or go see a doctor');
            return;
        }

        try {
            $response = Http::post('http://127.0.0.1:2500/predict', [
                'inputs' => $this->prompt,
            ]);

            $this->ai_response = $response->json('prediction') ?? 'No diagnosis returned.';

            DiagnosisRequest::create([
                'patient_id' => Auth::id(),
                'doctor_id' => null, // No doctor involved
                'prompt' => $this->prompt,
                'ai_response' => $this->ai_response,
                'hospital_id' => $this->selected_hospital_id,
            ]);

            $this->submitted = true;
        } catch (\Exception $e) {
            throw ValidationException::withMessages(['prompt' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.patient.get-ai-self-diagnosis-livewire');
    }
}
