<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Hospital;
use Livewire\Component;
use Livewire\WithPagination;

class AdminDashboardLivewire extends Component
{
    use WithPagination;

    public $userCount;
    public $doctorCount;
    public $patientCount;
    public $hospitalCount;

    public $showAllUsers = false;
    public $search = '';
    public $title = 'Admin Dash';

    protected $updatesQueryString = ['search'];

    public function mount()
    {
        $this->userCount = User::count();
        $this->doctorCount = User::whereHas('roles', fn($q) => $q->where('name', 'doctor'))->count();
        $this->patientCount = User::whereHas('roles', fn($q) => $q->where('name', 'patient'))->count();
        $this->hospitalCount = Hospital::count();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleUserList()
    {
        $this->showAllUsers = !$this->showAllUsers;
        $this->resetPage();
    }

    public function render()
    {
        $users = User::with('roles')
            ->when($this->search !== '', function ($q) {
                $q->where(function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('national_id_number', 'like', '%' . $this->search . '%');
                });
            })
            ->latest();

        $paginatedUsers = $this->showAllUsers
            ? $users->paginate(15)
            : $users->take(10)->get();

        return view('livewire.admin.admin-dashboard-livewire', [
            'users' => $paginatedUsers
        ])->layout('components.layouts.admin.app', ['title' => ucfirst($this->title)]);
    }
}
