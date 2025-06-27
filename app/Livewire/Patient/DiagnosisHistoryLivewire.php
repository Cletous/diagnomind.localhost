<?php

namespace App\Livewire\Patient;

use App\Models\DiagnosisRequest;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class DiagnosisHistoryLivewire extends Component
{
    public $diagnoses = [];

    public function mount()
    {
        $this->diagnoses = DiagnosisRequest::with(['doctor', 'hospital'])
            ->where('patient_id', Auth::id())
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.patient.diagnosis-history-livewire');
    }
}
