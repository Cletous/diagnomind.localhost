<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class DefaultUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch roles from DB
        $doctorRole = Role::firstOrCreate(['name' => 'doctor'], ['label' => 'Doctor']);
        $patientRole = Role::firstOrCreate(['name' => 'patient'], ['label' => 'Patient']);

        // Doctor
        $doctor = User::updateOrCreate([
            'national_id_number' => '631631768T27',
        ], [
            'first_name' => 'Cletous',
            'last_name' => 'Ngoma',
            'email' => 'ngomacletousjnr@gmail.com',
            'password' => Hash::make('password'),
        ]);

        // Assign role(s)
        $doctor->roles()->syncWithoutDetaching([$doctorRole->id]);

        // Patient
        $patient = User::updateOrCreate([
            'national_id_number' => '63163176T27',
        ], [
            'first_name' => 'Application',
            'last_name' => 'Mahobho',
            'email' => 'mahobhoapplication@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $patient->roles()->syncWithoutDetaching([$patientRole->id]);
    }
}
