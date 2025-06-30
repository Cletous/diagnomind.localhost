<?php

namespace App\Livewire\Doctor;

use App\Models\Hospital;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class HospitalLivewire extends Component
{
    public Hospital|null $hospital;

    public $mode = 'index'; // 'create', 'edit', 'invite'
    public $hospitals;
    public $hospitalId;
    public $name;
    public $address, $phone, $email;

    public $inviteEmail;
    public $invitedDoctors = [];

    public function mount($hospital = null)
    {
        if (request()->routeIs('doctor.hospitals.create')) {
            $this->mode = 'create';
        } elseif (request()->routeIs('doctor.hospitals.edit')) {
            $this->mode = 'edit';
            $this->loadHospital($hospital);
        } elseif (request()->routeIs('doctor.hospitals.invite')) {
            $this->mode = 'invite';
            $this->hospital = $hospital;

            $this->invitedDoctors = $hospital->doctors()
                ->orderBy('first_name')
                ->select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.created_at')
                ->get();

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
        $this->phone = $hospital->phone;
        $this->email = $hospital->email;
    }

    public function store()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:1000',
            'phone' => 'nullable|phone|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $hospital = Hospital::create([
            'name' => $this->name,
            'address' => $this->address,
            'admin_id' => Auth::id(),
            'phone' => $this->phone,
            'email' => $this->email,
        ]);

        $hospital->doctors()->syncWithoutDetaching(Auth::id());

        session()->flash('success', 'Hospital created successfully.');
        return redirect()->route('doctor.hospitals.index');
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:1000',
            'phone' => 'nullable|phone|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $hospital = Hospital::findOrFail($this->hospitalId);

        if ($hospital->admin_id !== Auth::id()) {
            abort(403);
        }

        $hospital->update([
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
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
        $hospital = Hospital::findOrFail($this->hospital->id);
        if ($hospital->doctors()->where('doctor_id', $doctor->id)->exists()) {
            throw ValidationException::withMessages([
                'inviteEmail' => 'This doctor is already part of this hospital.',
            ]);
        }

        // Attach doctor
        $hospital->doctors()->syncWithoutDetaching($doctor->id);

        // Optionally: fire an event or notification

        $this->reset('inviteEmail');
        session()->flash('success', 'Doctor invited successfully.');
        return redirect()->route('doctor.hospitals.invite', $this->hospital->id);
    }

    public function removeDoctor($doctorId)
    {
        if ($this->hospital->admin_id !== Auth::id()) {
            abort(403, 'Only the hospital administrator can remove doctors.');
        }

        // Prevent admin from removing themselves
        if ($doctorId == Auth::id()) {
            session()->flash('error', 'You cannot remove yourself as the hospital admin.');
            return;
        }

        $this->hospital->doctors()->detach($doctorId);

        session()->flash('success', 'Doctor removed successfully.');
        return redirect()->route('doctor.hospitals.invite', $this->hospital->id);
    }

    public function render()
    {
        return view('livewire.doctor.hospital-livewire')->layout('components.layouts.doctor.app', ['title' => ucfirst($this->mode)]);
    }
}
