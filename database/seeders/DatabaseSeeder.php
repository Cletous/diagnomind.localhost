<?php

namespace Database\Seeders;

use App\Models\DiagnosisRequest;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            DefaultUsersSeeder::class,
        ]);

        // Inside run() method after creating users
        $doctor = User::where('national_id_number', '111111111T01', )->first();
        $patient = User::where('national_id_number', '100000001T01', )->first();

        DiagnosisRequest::create([
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'prompt' => 'Patient reports fatigue, weight loss, frequent urination.',
            'ai_response' => 'Possible diagnosis: Type 2 Diabetes Mellitus. Recommend lab tests for fasting glucose and HbA1c.',
            'rating' => 'like',
        ]);
    }
}
