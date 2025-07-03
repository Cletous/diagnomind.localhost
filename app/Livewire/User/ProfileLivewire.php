<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ProfileLivewire extends Component
{
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $national_id_number = '';
    public string $confirmDelete = '';
    public bool $confirmingDeletion = false;

    public function mount()
    {
        $user = Auth::user();

        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->national_id_number = $user->national_id_number;
    }

    public function updateProfile()
    {
        $validated = $this->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'national_id_number' => 'required|string|regex:/^\d{8,9}[A-Z]\d{2}$/|unique:users,national_id_number,' . Auth::id(),
        ], [
            'national_id_number.regex' =>
                'The national id number must be in the format NNNNNNNNLNN or NNNNNNNNNLNN where N is a Number and L a capital letter.'
        ]);

        Auth::user()->update($validated);

        session()->flash('success', 'Profile updated successfully.');
    }

    public function confirmDeletion()
    {
        $this->confirmingDeletion = true;
    }

    public function deleteAccount()
    {
        $this->validate([
            'confirmDelete' => 'required|in:DELETE',
        ]);

        $user = Auth::user();

        Auth::logout();
        $user->delete();

        session()->invalidate();
        session()->regenerateToken();

        session()->flash('success', 'Profile deleted successfully.');
        return redirect('/')->with('message', 'Account deleted successfully.');
    }

    public function render()
    {
        return view('livewire.user.profile-livewire')
            ->layout('components.layouts.main.app', ['title' => 'Profile']);
    }
}
