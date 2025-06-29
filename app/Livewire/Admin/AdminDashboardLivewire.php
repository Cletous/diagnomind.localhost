<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Hospital;
use Livewire\Component;

class AdminDashboardLivewire extends Component
{
    public $userCount;
    public $doctorCount;
    public $patientCount;
    public $hospitalCount;
    public $users;

    public function mount()
    {
        $this->userCount = User::count();

        $this->doctorCount = User::whereHas('roles', fn($q) => $q->where('name', 'doctor'))->count();
        $this->patientCount = User::whereHas('roles', fn($q) => $q->where('name', 'patient'))->count();
        $this->hospitalCount = Hospital::count();

        $this->users = User::with('roles')->latest()->take(10)->get();
    }

    public function render()
    {
        return view('livewire.admin.admin-dashboard-livewire');
    }
}
