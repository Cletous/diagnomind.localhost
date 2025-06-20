<?php

namespace App\Livewire\Guest;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class AuthLivewire extends Component
{
    public string $mode = 'login';

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

    public int $registerStep = 1;

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

            // Only load session values into each field at the correct step
            $this->hydrateFromSession();
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

            $user = Auth::user();

            if ($user->roles->contains('name', 'admin')) {
                return redirect('/admin/dashboard');
            } elseif ($user->roles->contains('name', 'doctor')) {
                return redirect('/doctor/dashboard');
            } else {
                return redirect('/patient/dashboard');
            }
        }

        session()->flash('error', 'Invalid credentials');
    }

    public function getValidationRulesForStep()
    {
        return match ($this->registerStep) {
            1 => ['first_name' => 'required|string|max:100'],
            2 => [
                'last_name' => 'required|string|max:100',
                'national_id_number' => 'required|regex:/^\d{8,9}[A-Z]\d{2}$/|unique:users,national_id_number',
            ],
            3 => [
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
            ],
            default => [],
        };
    }

    public function getValidationMessagesForStep()
    {
        return match ($this->registerStep) {
            2 => [
                'national_id_number.regex' =>
                    'The national id number must be in the format NNNNNNNNLNN or NNNNNNNNNLNN where N is a Number and L a capital letter.',
            ],
            default => [],
        };
    }

    public function nextStep()
    {
        $this->validate(
            $this->getValidationRulesForStep(),
            $this->getValidationMessagesForStep()
        );

        $this->storeStepData();
        $this->registerStep++;
    }

    public function previousStep()
    {
        $this->registerStep = max(1, $this->registerStep - 1);
    }

    protected function storeStepData()
    {
        $data = session('register_data', []);

        if ($this->registerStep === 1) {
            $data['first_name'] = $this->first_name;
        } elseif ($this->registerStep === 2) {
            $data['last_name'] = $this->last_name;
            $data['national_id_number'] = $this->national_id_number;
        } elseif ($this->registerStep === 3) {
            $data['email'] = $this->email;
            $data['password'] = $this->password;
            $data['password_confirmation'] = $this->password_confirmation;
        }

        session(['register_data' => $data]);
    }

    public function register()
    {
        $this->validate(
            $this->getValidationRulesForStep(),
            $this->getValidationMessagesForStep()
        );

        $this->storeStepData();

        $data = session('register_data');

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'national_id_number' => $data['national_id_number'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $role = Role::where('name', 'patient')->first();
        $user->roles()->attach($role->id);

        session()->forget('register_data');

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('verification.notice');
    }

    public function sendPasswordResetLink()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'The :attribute is not found in our database.',
        ]);

        try {
            Password::sendResetLink(['email' => $this->email]);

            session()->flash('success', 'Password reset link sent! Please check your inbox.');
        } catch (\Throwable $e) {
            session()->flash('error', 'Failed to send password reset link. Try again later.');
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        session()->flash('success', 'You have been logged out.');
        return redirect()->route('login');
    }

    protected function hydrateFromSession()
    {
        $data = session('register_data', []);

        if ($this->registerStep === 1 && isset($data['first_name'])) {
            $this->first_name = $data['first_name'];
        } elseif ($this->registerStep === 2) {
            $this->last_name = $data['last_name'] ?? null;
            $this->national_id_number = $data['national_id_number'] ?? null;
        } elseif ($this->registerStep === 3) {
            $this->email = $data['email'] ?? null;
            $this->password = $data['password'] ?? null;
            $this->password_confirmation = $data['password_confirmation'] ?? null;
        }
    }

}
