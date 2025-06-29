<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Role;
use Livewire\Component;

class ManageUserRolesLivewire extends Component
{
    public $users;
    public $title = 'User Roles';

    public $filterRole = 'all';

    public $confirmingRemoval = false;
    public $removalUserId;
    public $removalRole;

    public function mount()
    {
        $this->loadUsers();
    }

    public function updatedFilterRole()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $this->users = User::with('roles')
            ->when($this->filterRole !== 'all', function ($query) {
                $query->whereHas('roles', fn($q) => $q->where('name', $this->filterRole));
            })
            ->get();
    }

    public function assignRole($userId, $role)
    {
        $user = User::findOrFail($userId);
        if (!$user->hasRole($role)) {
            $user->assignRole($role);
            session()->flash('success', "Assigned '{$role}' to {$user->first_name}");
        }
        $this->loadUsers();
    }

    public function confirmRoleRemoval($userId, $role)
    {
        $this->removalUserId = $userId;
        $this->removalRole = $role;
        $this->confirmingRemoval = true;
    }

    public function cancelRemoval()
    {
        $this->confirmingRemoval = false;
        $this->removalUserId = null;
        $this->removalRole = null;
    }

    public function removeRoleConfirmed()
    {
        $user = User::findOrFail($this->removalUserId);
        if ($user->hasRole($this->removalRole)) {
            $user->removeRole($this->removalRole);
            session()->flash('info', "Removed '{$this->removalRole}' from {$user->first_name}");
        }

        $this->cancelRemoval();
        $this->loadUsers();
    }

    public function render()
    {
        return view('livewire.admin.manage-user-roles-livewire')
            ->layout('components.layouts.patient.app', ['title' => ucfirst($this->title)]);
    }
}
