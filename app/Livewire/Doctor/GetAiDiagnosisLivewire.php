<?php

namespace App\Livewire\Doctor;

use App\Models\AiFeedback;
use App\Models\User;
use App\Models\DiagnosisRequest;
use App\Models\Hospital;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class GetAiDiagnosisLivewire extends Component
{
    public $national_id_number;
    public $patient;
    public $prompt;
    public $ai_response;
    public $comment;
    public $submitted = false;

    public $hospitals = [];
    public $selected_hospital_id;

    public $createPatientForm = false;
    public $new_patient_first_name;
    public $new_patient_last_name;
    public $new_patient_email;

    public $title = 'Get AI Diagnpsis';

    public function mount()
    {
        // Load hospitals linked to the logged-in doctor
        $this->hospitals = auth()->user()->hospitals()->get();
    }

    public function findPatient()
    {
        $this->validate([
            'national_id_number' => 'required|regex:/^\d{8,9}[A-Z]\d{2}$/',
        ], [
            'national_id_number.regex' =>
                'The national id number must be in the format NNNNNNNNLNN or NNNNNNNNNLNN where N is a Number and L a capital letter.'
        ]);

        $this->patient = User::where('national_id_number', $this->national_id_number)->first();

        if (!$this->patient) {
            $this->addError('national_id_number', 'No patient found with this ID.');
            $this->createPatientForm = true;
        }
    }

    public function createPatient()
    {
        $this->validate([
            'new_patient_first_name' => 'required|string|max:100',
            'new_patient_last_name' => 'required|string|max:100',
            'new_patient_email' => 'required|email|unique:users,email',
            'national_id_number' => 'required|regex:/^\d{8,9}[A-Z]\d{2}$/|unique:users,national_id_number',
        ]);

        $user = User::create([
            'first_name' => $this->new_patient_first_name,
            'last_name' => $this->new_patient_last_name,
            'email' => $this->new_patient_email,
            'national_id_number' => $this->national_id_number,
            'password' => bcrypt('patient'), // Default password
        ]);

        // Attach 'patient' role if using roles
        $user->assignRole('patient');

        $this->patient = $user;
        $this->resetValidation();
        $this->createPatientForm = false;
        session()->flash('message', 'Patient created successfully.');
    }

    public function submit()
    {
        $this->validate([
            'prompt' => 'required|string',
            'selected_hospital_id' => 'required|exists:hospitals,id',
        ]);

        if (!$this->patient) {
            $this->addError('national_id_number', 'Please search for a valid patient first.');
            return;
        }

        try {
            $response = Http::post('http://127.0.0.1:2500/predict', [
                'inputs' => $this->prompt,
            ]);

            $this->ai_response = $response->json('prediction') ?? 'No diagnosis returned.';
        } catch (\Exception $e) {
            throw ValidationException::withMessages(['prompt' => $e->getMessage()]);
        }
    }

    public function submitDiagnosisAndComment()
    {
        $this->validate([
            'comment' => 'nullable|string',
        ]);

        if (!$this->ai_response || !$this->patient || !$this->prompt || !$this->selected_hospital_id) {
            $this->addError('prompt', 'Please complete the AI step first.');
            return;
        }

        $diagnosis = DiagnosisRequest::create([
            'doctor_id' => auth()->id(),
            'patient_id' => $this->patient->id,
            'prompt' => $this->prompt,
            'ai_response' => $this->ai_response,
            'hospital_id' => $this->selected_hospital_id,
        ]);

        if (!empty(trim($this->comment))) {
            AiFeedback::create([
                'diagnosis_request_id' => $diagnosis->id,
                'doctor_id' => auth()->id(),
                'comment' => $this->comment,
            ]);
        }

        $this->submitted = true;
        $this->reset(['prompt', 'ai_response', 'comment', 'selected_hospital_id']);
    }


    public function render()
    {
        return view('livewire.doctor.get-ai-diagnosis')->layout('components.layouts.doctor.app', ['title' => ucfirst($this->title)]);
        ;
    }
}
