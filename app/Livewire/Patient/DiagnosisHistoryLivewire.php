<?php

namespace App\Livewire\Patient;

use App\Models\DiagnosisRequest;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DiagnosisHistoryLivewire extends Component
{
    public $diagnoses = [];
    public $hospitalFilter = '';
    public $dateFilter = '';
    public $hospitals;
    public $title = 'Diagnosis History';

    public User|null $user;

    public function mount(User $user)
    {
        if (request()->routeIs('patient.diagnosis.history.with.user')) {
            $this->user = $user;
        } else {
            $this->user = Auth::user();
        }
        // dd($this->user);

        $this->hospitals = Hospital::orderBy('name')->get();
        $this->fetchDiagnoses();
    }

    public function updatedHospitalFilter()
    {
        $this->fetchDiagnoses();
    }

    public function updatedDateFilter()
    {
        $this->fetchDiagnoses();
    }

    public function fetchDiagnoses()
    {
        $query = DiagnosisRequest::with(['doctor', 'feedback', 'hospital'])
            ->where('patient_id', $this->user->id);

        if ($this->hospitalFilter) {
            $query->where('hospital_id', $this->hospitalFilter);
        }

        if ($this->dateFilter) {
            $query->whereDate('created_at', $this->dateFilter);
        }

        $this->diagnoses = $query->latest()->get();
    }

    public function likeDiagnosis($diagnosisId)
    {
        $diagnosis = DiagnosisRequest::where('id', $diagnosisId)
            ->firstOrFail();

        if (!Auth::user()->can('rateDiagnosis', $diagnosis)) {
            abort(403);
        }

        $diagnosis->update(['rating' => 'like']);
        $this->fetchDiagnoses();
    }

    public function dislikeDiagnosis($diagnosisId)
    {
        $diagnosis = DiagnosisRequest::where('id', $diagnosisId)
            ->firstOrFail();

        if (!Auth::user()->can('rateDiagnosis', $diagnosis)) {
            abort(403);
        }

        $diagnosis->update(['rating' => 'dislike']);
        $this->fetchDiagnoses();
    }

    public function openFeedback($diagnosisId)
    {
        $this->dispatch('openFeedbackModal', $diagnosisId);
    }

    public function render()
    {
        return view('livewire.patient.diagnosis-history-livewire')
            ->layout('components.layouts.patient.app', [
                'title' => ucfirst($this->title),
            ]);
    }
}
