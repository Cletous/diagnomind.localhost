<?php


namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\DiagnosisRequest;
use Illuminate\Support\Facades\Auth;

class PatientDashboardLivewire extends Component
{
    public $diagnoses;
    public $title = 'Patient Dash';

    public function mount()
    {
        $this->diagnoses = DiagnosisRequest::where('patient_id', Auth::id())
            ->with('doctor')
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.patient.dashboard')->layout('components.layouts.patient.app', ['title' => ucfirst($this->title)]);
    }
}
