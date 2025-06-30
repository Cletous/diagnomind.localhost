<?php

namespace App\Livewire\Guest;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class ShowDoctorReviewsLivewire extends Component
{
    use WithPagination;

    public User $doctor;

    protected $paginationTheme = 'bootstrap';

    public function mount(User $doctor)
    {
        $this->doctor = $doctor->load('doctorReviews.patient');
    }

    public function render()
    {
        $reviews = $this->doctor->doctorReviews()->latest()->paginate(10);

        return view('livewire.guest.show-doctor-reviews-livewire', [
            'reviews' => $reviews
        ])->layout('components.layouts.main.app', [
                    'title' => 'Reviews for Dr. ' . $this->doctor->name
                ]);
    }
}
