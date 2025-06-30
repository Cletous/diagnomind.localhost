<?php

namespace App\Livewire\Guest;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class DoctorsListingLivewire extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $doctors = User::whereHas('roles', function ($query) {
            $query->where('name', 'doctor');
        })
            ->withCount('doctorReviews')
            ->withAvg('doctorReviews', 'rating')
            ->orderBy('first_name')
            ->paginate(10);

        return view('livewire.guest.doctors-listing-livewire', [
            'doctors' => $doctors,
        ])->layout('components.layouts.main.app', [
                    'title' => 'Doctors Directory'
                ]);
    }
}
