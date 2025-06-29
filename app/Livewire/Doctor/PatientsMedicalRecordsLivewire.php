<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class PatientsMedicalRecordsLivewire extends Component
{
    use WithPagination;

    public string $search = '';
    public $title = 'Patients Medical Records';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $doctor = Auth::user();

        // Get all hospitals the doctor is linked to
        $hospitalIds = $doctor->hospitals()->select('hospitals.id')->pluck('id');

        // Get patients diagnosed by the doctor within those hospitals
        $patients = User::whereHas('diagnosisRequests', function (Builder $query) use ($doctor, $hospitalIds) {
            $query->where('doctor_id', $doctor->id)
                ->orWhereIn('hospital_id', $hospitalIds);
        })
            ->where(function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('national_id_number', 'like', '%' . $this->search . '%');
            })
            ->distinct()
            ->paginate(10);

        return view('livewire.doctor.patients-medical-records-livewire', [
            'patients' => $patients,
        ])->layout('components.layouts.doctor.app', ['title' => ucfirst($this->title)]);
    }
}
