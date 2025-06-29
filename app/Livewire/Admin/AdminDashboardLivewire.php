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
    public $showAllUsers = false;

    public $title = 'Admin Dash';

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        $this->userCount = User::count();
        $this->doctorCount = User::whereHas('roles', fn($q) => $q->where('name', 'doctor'))->count();
        $this->patientCount = User::whereHas('roles', fn($q) => $q->where('name', 'patient'))->count();
        $this->hospitalCount = Hospital::count();

        $this->loadUsers();
    }

    public function loadUsers()
    {
        $query = User::with('roles')->latest();
        $this->users = $this->showAllUsers ? $query->get() : $query->take(10)->get();
    }

    public function toggleUserList()
    {
        $this->showAllUsers = !$this->showAllUsers;
        $this->loadUsers();
    }

    public function render()
    {
        return view('livewire.admin.admin-dashboard-livewire')
            ->layout('components.layouts.admin.app', ['title' => ucfirst($this->title)]);
    }
}
