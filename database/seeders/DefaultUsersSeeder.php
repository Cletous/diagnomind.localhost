<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DefaultUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Doctor
        User::updateOrCreate([
            'national_id_number' => '631234567Y82',
        ], [
            'first_name' => 'Cletous',
            'last_name' => 'Ngoma',
            'email' => 'ngomacletousjnr@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);

        // Patient
        User::updateOrCreate([
            'national_id_number' => '631234567A82',
        ], [
            'first_name' => 'Application',
            'last_name' => 'Mahobho',
            'email' => 'mahobhoapplication@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
        ]);
    }
}