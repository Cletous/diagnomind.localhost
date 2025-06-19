<?php

use App\Livewire\Doctor\SubmitDiagnosisLivewire;
use App\Livewire\Patient\DashboardLivewire;
use Illuminate\Support\Facades\Route;

Route::view('/', 'guest.home')->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {

    Route::prefix('patient')->as('patient.')->group(function () {
        Route::get('/dashboard', DashboardLivewire::class)->name('dashboard');
    });

    Route::prefix('doctor')->as('doctor.')->group(function () {
        Route::get('/submit-diagnosis', SubmitDiagnosisLivewire::class)->name('submit-diagnosis');
    });
});

require __DIR__ . '/auth.php';
