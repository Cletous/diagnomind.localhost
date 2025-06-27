<?php

namespace App\Livewire\Doctor;

use App\Models\Hospital;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class HospitalLivewire extends Component
{
    public $mode = 'index'; // 'create', 'edit', 'invite'
    public $hospitals;
    public $hospitalId;
    public $name;
    public $address;

    public $inviteEmail;

    public function mount($hospital = null)
    {
        if (request()->routeIs('doctor.hospitals.create')) {
            $this->mode = 'create';
        } elseif (request()->routeIs('doctor.hospitals.edit')) {
            $this->mode = 'edit';
            $this->loadHospital($hospital);
        } elseif (request()->routeIs('doctor.hospitals.invite')) {
            $this->mode = 'invite';
            $this->hospitalId = $hospital?->id;
        } else {
            $this->mode = 'index';
            $this->hospitals = Auth::user()->hospitals()->get();
        }
    }

    public function loadHospital($hospital)
    {
        $this->hospitalId = $hospital->id;
        $this->name = $hospital->name;
        $this->address = $hospital->address;
    }

    public function store()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:1000',
        ]);

        $hospital = Hospital::create([
            'name' => $this->name,
            'address' => $this->address,
            'admin_id' => Auth::id(),
        ]);

        $hospital->doctors()->attach(Auth::id());

        session()->flash('success', 'Hospital created successfully.');
        return redirect()->route('doctor.hospitals.index');
    }

    public function update()
    {
        $hospital = Hospital::findOrFail($this->hospitalId);

        if ($hospital->admin_id !== Auth::id()) {
            abort(403);
        }

        $hospital->update([
            'name' => $this->name,
            'address' => $this->address,
        ]);

        session()->flash('success', 'Hospital updated successfully.');
        return redirect()->route('doctor.hospitals.index');
    }

    public function invite()
    {
        $this->validate([
            'inviteEmail' => 'required|email|exists:users,email',
        ]);

        $doctor = User::where('email', $this->inviteEmail)->firstOrFail();

        // Check if already added
        $hospital = Hospital::findOrFail($this->hospitalId);
        if ($hospital->doctors()->where('doctor_id', $doctor->id)->exists()) {
            throw ValidationException::withMessages([
                'inviteEmail' => 'This doctor is already part of this hospital.',
            ]);
        }

        // Attach doctor
        $hospital->doctors()->attach($doctor->id);

        // Optionally: fire an event or notification

        $this->reset('inviteEmail');
        session()->flash('success', 'Doctor invited successfully.');
    }

    public function render()
    {
        return view('livewire.doctor.hospital-livewire');
    }
}
