<?php

namespace App\Livewire\Guest;

use Livewire\Component;

class HomeLivewire extends Component
{
    public function render()
    {
        return view('livewire.guest.home-livewire')
            ->layoutData(['title' => 'Welcome to DiagnoMind']);
    }
}
