<?php

namespace App\Livewire\Doctor;

use App\Models\DiagnosisRequest;
use App\Models\Hospital;
use Livewire\Component;

class DoctorDashboardLivewire extends Component
{
    public $hospitalCount;
    public $diagnosedPatientsCount;
    public $title = 'Doctor Dashboard';

    public function mount()
    {
        $this->hospitalCount = auth()->user()
            ->hospitals()
            ->count();

        $this->diagnosedPatientsCount = DiagnosisRequest::where('doctor_id', auth()->id())
            ->distinct('patient_id')
            ->count('patient_id');
    }

    public function render()
    {
        return view('livewire.doctor.doctor-dashboard-livewire')->layout('components.layouts.doctor.app', ['title' => ucfirst($this->title)]);
    }
}
