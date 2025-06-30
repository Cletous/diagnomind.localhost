<?php

namespace Database\Seeders;

use App\Models\Hospital;
use App\Models\HospitalReview;
use App\Models\User;
use Illuminate\Database\Seeder;

class HospitalReviewsSeeder extends Seeder
{
    public function run(): void
    {
        $patients = User::whereHas('roles', fn($q) => $q->where('name', 'patient'))->take(10)->get();
        $hospitals = Hospital::all();

        foreach ($hospitals as $hospital) {
            foreach ($patients as $patient) {
                HospitalReview::create([
                    'hospital_id' => $hospital->id,
                    'patient_id' => $patient->id,
                    'rating' => rand(3, 5),
                    'review' => "Service was generally satisfactory at {$hospital->name}.",
                ]);
            }
        }
    }
}
