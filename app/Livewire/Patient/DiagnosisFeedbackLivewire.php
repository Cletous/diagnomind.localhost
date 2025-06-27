<?php

namespace App\Livewire\Patient;

use App\Models\AiFeedback;
use App\Models\DiagnosisRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DiagnosisFeedbackLivewire extends Component
{
    public $diagnosisId;
    public $comment = '';
    public $rating = 'none'; // like, dislike, none
    public $showModal = false;

    protected $rules = [
        'rating' => 'required|in:like,dislike,none',
        'comment' => 'nullable|string|max:1000',
    ];

    protected $listeners = ['openFeedbackModal' => 'loadDiagnosis'];

    public function loadDiagnosis($diagnosisId)
    {
        $this->diagnosisId = $diagnosisId;
        $this->reset(['comment', 'rating']);

        $existing = AiFeedback::where('diagnosis_request_id', $diagnosisId)
            ->where('doctor_id', Auth::id()) // or use `patient_id` if stored differently
            ->first();

        if ($existing) {
            $this->comment = $existing->comment;
            $this->rating = $existing->diagnosis->rating ?? 'none';
        }

        $this->showModal = true;
    }

    public function submitFeedback()
    {
        $this->validate();

        $diagnosis = DiagnosisRequest::where('id', $this->diagnosisId)
            ->where('patient_id', Auth::id())
            ->firstOrFail();

        $diagnosis->update(['rating' => $this->rating]);

        AiFeedback::updateOrCreate(
            [
                'diagnosis_request_id' => $this->diagnosisId,
                'doctor_id' => $diagnosis->doctor_id,
            ],
            ['comment' => $this->comment]
        );

        session()->flash('success', 'Feedback submitted successfully.');
        $this->showModal = false;
        $this->dispatch('feedbackSubmitted');
    }

    public function render()
    {
        return view('livewire.patient.diagnosis-feedback-livewire');
    }
}
