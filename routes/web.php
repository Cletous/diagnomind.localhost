<?php

use App\Livewire\Admin\AdminDashboardLivewire;
use App\Livewire\Admin\ManageUserRolesLivewire;
use App\Livewire\Doctor\DoctorDashboardLivewire;
use App\Livewire\Doctor\GetAiDiagnosisLivewire;
use App\Livewire\Doctor\HospitalLivewire;
use App\Livewire\Doctor\PatientsMedicalRecordsLivewire;
use App\Livewire\Guest\DoctorsListingLivewire;
use App\Livewire\Guest\HomeLivewire;
use App\Livewire\Guest\HospitalsListingLivewire;
use App\Livewire\Guest\ShowDoctorReviewsLivewire;
use App\Livewire\Guest\ShowHospitalReviewsLivewire;
use App\Livewire\Patient\DiagnosisHistoryLivewire;
use App\Livewire\Patient\GetAiSelfDiagnosisLivewire;
use App\Livewire\Patient\PatientDashboardLivewire;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return view('errors.404');
});

Route::get('/', HomeLivewire::class)->name('home');
Route::get('/hospitals', HospitalsListingLivewire::class)->name('hospitals');
Route::get('/doctors', DoctorsListingLivewire::class)->name('doctors');

Route::get('/hospitals/{hospital}/reviews', ShowHospitalReviewsLivewire::class)->name('hospital.reviews');
Route::get('/doctors/{doctor}/reviews', ShowDoctorReviewsLivewire::class)->name('doctor.reviews');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::middleware(['user_role:patient'])->prefix('patient')->as('patient.')->group(function () {
        Route::get('/dashboard', PatientDashboardLivewire::class)->name('dashboard');

        Route::get('/self-diagnosis', GetAiSelfDiagnosisLivewire::class)->name('self.diagnosis');

        // For patients viewing their own history (default)
        Route::get('/diagnosis-history', DiagnosisHistoryLivewire::class)->name('diagnosis.history');

        // For doctors/admins viewing others’ histories
        Route::get('/diagnosis-history/user/{user}', DiagnosisHistoryLivewire::class)->name('diagnosis.history.with.user')->can('viewDiagnosisHistory', [User::class, '{user}' => 'user']);
    });

    Route::middleware(['user_role:doctor'])->prefix('doctor')->as('doctor.')->group(function () {
        Route::get('/dashboard', DoctorDashboardLivewire::class)->name('dashboard');

        Route::get('/get-ai-diagnosis', GetAiDiagnosisLivewire::class)->name('get.diagnosis');

        Route::get('/hospitals', HospitalLivewire::class)->name('hospitals.index');
        Route::get('/hospitals/create', HospitalLivewire::class)->name('hospitals.create');
        Route::get('/hospitals/{hospital}/edit', HospitalLivewire::class)->name('hospitals.edit')->can('update', [Hospital::class, '{hospital}' => 'hospital']);
        Route::get('/hospitals/{hospital}/invite', HospitalLivewire::class)->name('hospitals.invite')->can('invite', [Hospital::class, '{hospital}' => 'hospital']);

        Route::get('/patients-records', PatientsMedicalRecordsLivewire::class)->name('patients.records');
    });

    Route::middleware(['user_role:admin'])->prefix('admin')->as('admin.')->group(function () {
        Route::get('/dashboard', AdminDashboardLivewire::class)->name('dashboard');
        Route::get('/manage-user-roles', ManageUserRolesLivewire::class)->name('roles.manage');
    });
});

require __DIR__ . '/auth.php';
