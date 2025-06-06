<?php

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
});

// require __DIR__ . '/auth.php';
