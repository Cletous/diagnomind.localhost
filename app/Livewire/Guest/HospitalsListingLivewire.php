<?php

namespace App\Livewire\Guest;

use App\Models\Hospital;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class HospitalsListingLivewire extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap'; // or 'tailwind' depending on your setup

    public function render()
    {
        $hospitals = Hospital::select('hospitals.*')
            ->withCount('doctors')
            ->withAvg('reviews', 'rating')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.guest.hospitals-listing-livewire', [
            'hospitals' => $hospitals,
        ])->layout('components.layouts.main.app', [
                    'title' => 'Hospitals Directory'
                ]);
    }
}
