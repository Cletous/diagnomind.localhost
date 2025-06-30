<?php

namespace App\Livewire\Guest;

use Livewire\Component;
use App\Models\Hospital;
use Livewire\WithPagination;

class ShowHospitalReviewsLivewire extends Component
{
    use WithPagination;

    public Hospital $hospital;

    protected $paginationTheme = 'bootstrap';

    public function mount(Hospital $hospital)
    {
        $this->hospital = $hospital->load('reviews.patient');
    }

    public function render()
    {
        $reviews = $this->hospital->reviews()->latest()->paginate(10);

        return view('livewire.guest.show-hospital-reviews-livewire', [
            'reviews' => $reviews
        ])->layout('components.layouts.main.app', [
                    'title' => 'Reviews for ' . $this->hospital->name
                ]);
    }
}
