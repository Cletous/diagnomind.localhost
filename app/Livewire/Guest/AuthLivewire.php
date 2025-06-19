<?php

namespace App\Livewire\Guest;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Stevebauman\Location\Facades\Location;

class AuthLivewire extends Component
{
    public string $mode = 'login'; // Default

    // Shared
    public $email;
    public $password;
    public $show_password = false;

    // Register-specific
    public $first_name;
    public $last_name;
    public $national_id_number;
    public $role = 'patient';
    public $password_confirmation;

    // Forgot/reset-specific
    public $reset_token;
    public $new_password;
    public $new_password_confirmation;

    // Extra
    public $country_of_signup_ip;

    public function mount()
    {
        if (request()->routeIs('logout')) {
            return $this->logout();
        }

        if (Auth::check()) {
            return redirect()->intended('/patient/dashboard');
        }

        if (request()->routeIs('login')) {
            $this->mode = 'login';
        } elseif (request()->routeIs('register')) {
            $this->mode = 'register';
        } elseif (request()->routeIs('forget_password')) {
            $this->mode = 'forget_password';
        } elseif (request()->routeIs('password.reset')) {
            $this->mode = 'reset_password';
            $this->reset_token = request()->get('token');
            $this->email = request()->get('email');
        }

    }

    public function render()
    {
        return view('livewire.guest.auth-livewire')
            ->layout('components.layouts.blank.app', ['title' => ucfirst($this->mode)]);
    }

    public function login()
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            return redirect()->intended('/patient/dashboard');
        }

        session()->flash('error', 'Invalid credentials');
    }

    public function register()
    {
        $this->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'national_id_number' => 'required|string|unique:users,national_id_number',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:doctor,patient',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'national_id_number' => $this->national_id_number,
            'email' => $this->email,
            'role' => $this->role,
            'password' => Hash::make($this->password),
        ]);

        Auth::login($user);
        return redirect('/patient/dashboard');
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        session()->flash('success', 'You have been logged out.');
        return redirect()->route('login');
    }
}
