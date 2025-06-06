<?php

use App\Livewire\Doctor\SubmitDiagnosis;
use App\Livewire\Patient\Dashboard;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {

    Route::prefix('patient')->as('patient.')->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
    });

    Route::prefix('doctor')->as('doctor.')->group(function () {
        Route::get('/submit-diagnosis', SubmitDiagnosis::class)->name('submit-diagnosis');
    });
});

require __DIR__ . '/auth.php';
