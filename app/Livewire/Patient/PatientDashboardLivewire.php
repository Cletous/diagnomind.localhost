<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\DiagnosisRequest;
use Illuminate\Support\Facades\Auth;

class PatientDashboardLivewire extends Component
{
    public $totalDiagnoses;
    public $feedbackCount;
    public $mostVisitedHospital;
    public $recentDiagnoses = [];
    public $title = 'Patient Dashboard';

    public function mount()
    {
        $userId = Auth::id();

        $this->totalDiagnoses = DiagnosisRequest::where('patient_id', $userId)->count();

        $this->feedbackCount = DiagnosisRequest::where('patient_id', $userId)
            ->whereIn('rating', ['like', 'dislike'])->count();

        $this->mostVisitedHospital = DiagnosisRequest::where('patient_id', $userId)
            ->whereNotNull('hospital_id')
            ->with('hospital')
            ->selectRaw('hospital_id, COUNT(*) as count')
            ->groupBy('hospital_id')
            ->orderByDesc('count')
            ->first()
            ?->hospital?->name;

        $this->recentDiagnoses = DiagnosisRequest::with('hospital')
            ->where('patient_id', $userId)
            ->latest()
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.patient.patient-dashboard-livewire')->layout('components.layouts.patient.app', ['title' => ucfirst($this->title)]);
    }
}
