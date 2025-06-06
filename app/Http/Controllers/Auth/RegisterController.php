<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'national_id_number' => 'required|string|unique:users,national_id_number',
            'role' => 'required|in:doctor,patient',
        ]);

        $user = User::create([
            ...$data,
            'password' => Hash::make($data['password']),
        ]);

        auth()->login($user);

        return redirect('/patient/dashboard');
    }
}