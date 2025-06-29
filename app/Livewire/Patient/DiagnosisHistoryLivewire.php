<?php

namespace App\Livewire\Patient;

use App\Models\DiagnosisRequest;
use App\Models\Hospital;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DiagnosisHistoryLivewire extends Component
{
    public $diagnoses = [];
    public $hospitalFilter = '';
    public $dateFilter = '';
    public $hospitals;
    public $title = 'Diagnosis History';


    public function mount()
    {
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
        $query = DiagnosisRequest::with(['doctor', 'hospital'])
            ->where('patient_id', Auth::id());

        if ($this->hospitalFilter) {
            $query->where('hospital_id', $this->hospitalFilter);
        }

        if ($this->dateFilter) {
            $query->whereDate('created_at', $this->dateFilter);
        }

        $this->diagnoses = $query->latest()->get();
    }

    public function render()
    {
        return view('livewire.patient.diagnosis-history-livewire')->layout('components.layouts.patient.app', ['title' => ucfirst($this->title)]);
    }
}
