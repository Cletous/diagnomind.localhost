<?php

use App\Livewire\Patient\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->prefix('patient')->as('patient.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
});
