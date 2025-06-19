<?php

use Illuminate\Support\Facades\Auth;

use App\Livewire\Guest\AuthLivewire;

Route::get('/login', AuthLivewire::class)->name('login');
Route::get('/register', AuthLivewire::class)->name('register');
Route::get('/forget-password', AuthLivewire::class)->name('forget_password');

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');