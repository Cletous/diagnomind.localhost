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

        //Super Admin
        $admin = User::updateOrCreate([
            'national_id_number' => '111111111T01',
        ], [
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('admin'),
            'email_verified_at' => now()
        ]);
        $admin->roles()->syncWithoutDetaching([$adminRole->id]);

        // Doctors
        $doctor1 = User::updateOrCreate([
            'national_id_number' => '111111111T02',
        ], [
            'first_name' => 'Doctor',
            'last_name' => 'One',
            'email' => 'doctor1@test.com',
            'password' => Hash::make('doctor'),
            'email_verified_at' => now()
        ]);
        $doctor1->roles()->syncWithoutDetaching([$doctorRole->id]);

        $doctor2 = User::updateOrCreate([
            'national_id_number' => '111111111T03',
        ], [
            'first_name' => 'Doctor',
            'last_name' => 'Two',
            'email' => 'doctor2@test.com',
            'password' => Hash::make('doctor'),
            'email_verified_at' => now()
        ]);
        $doctor2->roles()->syncWithoutDetaching([$doctorRole->id]);

        // Patients - Create 20 test users
        for ($i = 1; $i <= 20; $i++) {
            $email = "user{$i}@test.com";
            $nationalId = '1000000' . str_pad($i, 2, '0', STR_PAD_LEFT) . 'T' . str_pad($i, 2, '0', STR_PAD_LEFT);

            $user = User::updateOrCreate([
                'email' => $email,
            ], [
                'first_name' => 'User',
                'last_name' => (string) $i,
                'national_id_number' => $nationalId,
                'password' => Hash::make('patient'),
                'email_verified_at' => now(),
            ]);

            $user->roles()->syncWithoutDetaching([$patientRole->id]);
        }
    }
}
