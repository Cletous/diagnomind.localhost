<?php

namespace Database\Seeders;

use App\Models\DoctorReview;
use App\Models\User;
use Illuminate\Database\Seeder;

class DoctorReviewsSeeder extends Seeder
{
    public function run(): void
    {
        $patients = User::whereHas('roles', fn($q) => $q->where('name', 'patient'))->take(10)->get();
        $doctors = User::whereHas('roles', fn($q) => $q->where('name', 'doctor'))->take(4)->get();

        foreach ($doctors as $doctor) {
            foreach ($patients as $patient) {
                DoctorReview::create([
                    'doctor_id' => $doctor->id,
                    'patient_id' => $patient->id,
                    'rating' => rand(4, 5),
                    'review' => "Dr. {$doctor->first_name} was attentive and professional.",
                ]);
            }
        }
    }
}
