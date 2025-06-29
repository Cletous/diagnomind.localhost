<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;

class ManageUserRolesLivewire extends Component
{
    public $users;
    public $title = 'User Roles';
    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $this->users = User::with('roles')->get();
    }

    public function assignRole($userId, $role)
    {
        $user = User::findOrFail($userId);

        if (!$user->hasRole($role)) {
            $user->assignRole($role);
            session()->flash('success', "Assigned '{$role}' role to {$user->first_name}");
        }

        $this->loadUsers();
    }

    public function removeRole($userId, $role)
    {
        $user = User::findOrFail($userId);

        if ($user->hasRole($role)) {
            $user->removeRole($role);
            session()->flash('info', "Removed '{$role}' role from {$user->first_name}");
        }

        $this->loadUsers();
    }

    public function render()
    {
        return view('livewire.admin.manage-user-roles-livewire')->layout('components.layouts.patient.app', ['title' => ucfirst($this->title)]);
    }
}
