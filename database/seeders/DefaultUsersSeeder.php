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
        // Fetch or create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['label' => 'Administrator']);
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
            'email_verified_at' => now()
        ]);
        $doctor->roles()->syncWithoutDetaching([$adminRole->id, $doctorRole->id]);

        // Patient
        $patient = User::updateOrCreate([
            'national_id_number' => '63163176T27',
        ], [
            'first_name' => 'Application',
            'last_name' => 'Mahobho',
            'email' => 'mahobhoapplication@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now()
        ]);
        $patient->roles()->syncWithoutDetaching([$patientRole->id]);

        // Add 20 more test patients
        for ($i = 1; $i <= 20; $i++) {
            $user = User::updateOrCreate([
                'email' => "user{$i}@test.com"
            ], [
                'first_name' => 'User',
                'last_name' => $i,
                'national_id_number' => 'TESTID' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            $user->roles()->syncWithoutDetaching([$patientRole->id]);
        }
    }
}
