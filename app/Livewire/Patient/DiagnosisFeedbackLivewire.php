<?php

namespace App\Livewire\Patient;

use App\Models\DiagnosisRequest;
use App\Models\DoctorReview;
use App\Models\HospitalReview;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DiagnosisFeedbackLivewire extends Component
{
    protected $listeners = ['openFeedbackModal' => 'open'];

    public $diagnosisId;
    public $showModal = false;

    public $doctor_rating;
    public $doctor_review;
    public $hospital_rating;
    public $hospital_review;

    protected $rules = [
        'doctor_rating' => 'required|integer|min:1|max:5',
        'doctor_review' => 'required|string|max:1000',
        'hospital_rating' => 'required|integer|min:1|max:5',
        'hospital_review' => 'required|string|max:1000',
    ];


    public function open($diagnosisId)
    {
        $this->diagnosisId = $diagnosisId;
        $this->reset(['doctor_rating', 'doctor_review', 'hospital_rating', 'hospital_review']);
        $this->showModal = true;
    }

    public function submit()
    {
        $this->validate();

        $diagnosis = DiagnosisRequest::with(['doctor', 'hospital'])->findOrFail($this->diagnosisId);

        // Doctor Review
        if ($diagnosis->doctor && $this->doctor_rating) {
            DoctorReview::updateOrCreate(
                [
                    'doctor_id' => $diagnosis->doctor->id,
                    'patient_id' => Auth::id(),
                ],
                [
                    'rating' => $this->doctor_rating,
                    'review' => $this->doctor_review,
                ]
            );
        }

        // Hospital Review
        if ($diagnosis->hospital && $this->hospital_rating) {
            HospitalReview::updateOrCreate(
                [
                    'hospital_id' => $diagnosis->hospital->id,
                    'patient_id' => Auth::id(),
                ],
                [
                    'rating' => $this->hospital_rating,
                    'review' => $this->hospital_review,
                ]
            );
        }

        $this->dispatch('closeModal');
        $this->showModal = false;
        $this->dispatch('feedbackSubmitted');
    }

    public function render()
    {
        return view('livewire.patient.diagnosis-feedback-livewire');
    }
}
