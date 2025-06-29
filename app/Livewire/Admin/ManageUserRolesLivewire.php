<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ManageUserRolesLivewire extends Component
{
    use WithPagination;

    public $title = 'User Roles';

    public $filterRole = 'all';
    public $confirmingRemoval = false;
    public $removalUserId;
    public $removalRole;

    // Reset pagination when filter changes
    public function updatedFilterRole()
    {
        $this->resetPage();
    }

    public function assignRole($userId, $role)
    {
        $user = User::findOrFail($userId);
        if (!$user->hasRole($role)) {
            $user->assignRole($role);
            session()->flash('success', "Assigned '{$role}' to {$user->first_name}");
        }
        $this->resetPage();
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
        $this->resetPage();
    }

    public function render()
    {
        $users = User::with('roles')
            ->when($this->filterRole !== 'all', fn($q) =>
                $q->whereHas('roles', fn($r) => $r->where('name', $this->filterRole)))
            ->orderBy('first_name')
            ->paginate(10);

        return view('livewire.admin.manage-user-roles-livewire', compact('users'))
            ->layout('components.layouts.admin.app', ['title' => ucfirst($this->title)]);
    }
}
