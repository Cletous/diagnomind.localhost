<?php

use App\Livewire\User\ProfileLivewire;
use Illuminate\Support\Facades\Auth;

use App\Livewire\Guest\AuthLivewire;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/verified-redirect');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Verification link sent!');
    })->middleware('throttle:1,5')   // 1 request per 5 minutes
        ->name('verification.send');
});

Route::middleware(['auth'])->get('/profile', ProfileLivewire::class)->name('profile');

Route::get('/login', AuthLivewire::class)->name('login');
Route::get('/register', AuthLivewire::class)->name('register');
Route::get('/forget-password', AuthLivewire::class)->name('forget_password');

Route::post('/logout', AuthLivewire::class)->name('logout');