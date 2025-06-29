<?php

use App\Livewire\Admin\AdminDashboardLivewire;
use App\Livewire\Admin\ManageUserRolesLivewire;
use App\Livewire\Doctor\DoctorDashboardLivewire;
use App\Livewire\Doctor\GetAiDiagnosisLivewire;
use App\Livewire\Doctor\HospitalLivewire;
use App\Livewire\Guest\HomeLivewire;
use App\Livewire\Patient\DiagnosisHistoryLivewire;
use App\Livewire\Patient\PatientDashboardLivewire;
use App\Models\Hospital;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return view('errors.404');
});

Route::get('/', HomeLivewire::class)->name('home');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::middleware(['user_role:patient'])->prefix('patient')->as('patient.')->group(function () {
        Route::get('/dashboard', PatientDashboardLivewire::class)->name('dashboard');

        Route::get('/diagnosis-history', DiagnosisHistoryLivewire::class)->name('diagnosis.history');
    });

    Route::middleware(['user_role:doctor'])->prefix('doctor')->as('doctor.')->group(function () {
        Route::get('/dashboard', DoctorDashboardLivewire::class)->name('dashboard');

        Route::get('/get-ai-diagnosis', GetAiDiagnosisLivewire::class)->name('get.diagnosis');

        Route::get('/hospitals', HospitalLivewire::class)->name('hospitals.index');
        Route::get('/hospitals/create', HospitalLivewire::class)->name('hospitals.create');
        Route::get('/hospitals/{hospital}/edit', HospitalLivewire::class)->name('hospitals.edit')->can('update', [Hospital::class, '{hospital}' => 'hospital']);
        Route::get('/hospitals/{hospital}/invite', HospitalLivewire::class)->name('hospitals.invite')->can('invite', [Hospital::class, '{hospital}' => 'hospital']);
    });

    Route::middleware(['user_role:admin'])->prefix('admin')->as('admin.')->group(function () {
        Route::get('/dashboard', AdminDashboardLivewire::class)->name('dashboard');
        Route::get('/manage-user-roles', ManageUserRolesLivewire::class)->name('roles.manage');
    });
});

require __DIR__ . '/auth.php';
