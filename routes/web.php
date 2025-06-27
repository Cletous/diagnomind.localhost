<?php

use App\Livewire\Doctor\DoctorDashboardLivewire;
use App\Livewire\Doctor\HospitalLivewire;
use App\Livewire\Doctor\SubmitDiagnosisLivewire;
use App\Livewire\Guest\HomeLivewire;
use App\Livewire\Patient\PatientDashboardLivewire;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeLivewire::class)->name('home');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::prefix('patient')->as('patient.')->group(function () {
        Route::get('/dashboard', PatientDashboardLivewire::class)->name('dashboard');
    });

    Route::prefix('doctor')->as('doctor.')->group(function () {
        Route::get('/dashboard', DoctorDashboardLivewire::class)->name('dashboard');

        Route::get('/submit-diagnosis', SubmitDiagnosisLivewire::class)->name('submit.diagnosis');

        Route::get('/hospitals', HospitalLivewire::class)->name('hospitals.index');
        Route::get('/hospitals/create', HospitalLivewire::class)->name('hospitals.create');
        Route::get('/hospitals/{hospital}/edit', HospitalLivewire::class)->name('hospitals.edit');
        Route::get('/hospitals/{hospital}/invite', HospitalLivewire::class)->name('hospitals.invite');
    });

    Route::prefix('admin')->as('admin.')->group(function () {
        Route::get('/dashboard', DoctorDashboardLivewire::class)->name('dashboard');
    });
});

require __DIR__ . '/auth.php';
