<?php

namespace Database\Seeders;

use App\Models\Hospital;
use App\Models\User;
use Illuminate\Database\Seeder;

class HospitalsSeeder extends Seeder
{
    public function run(): void
    {
        $doctor1 = User::where('national_id_number', '111111111T02', )->first();
        $doctor2 = User::where('national_id_number', '111111111T03', )->first();

        $hospitals = [
            [
                'id' => 1,
                'name' => 'Harare General Hospital',
                'address' => '263 Josiah Tongogara St, Harare, Zimbabwe',
                'phone' => '+263242707011',
                'email' => 'info@hararehospital.org.zw',
                'admin_id' => $doctor1->id,
            ],
            [
                'id' => 2,
                'name' => 'Parirenyatwa Group of Hospitals',
                'address' => 'Mazowe Street, Harare, Zimbabwe',
                'phone' => '+263242701555',
                'email' => 'contact@parihospitals.co.zw',
                'admin_id' => $doctor2->id,
            ],
            [
                'id' => 3,
                'name' => 'Chitungwiza Central Hospital',
                'address' => 'Off Seke Road, Chitungwiza, Zimbabwe',
                'phone' => '+263772458221',
                'email' => 'admin@chchospital.org.zw',
                'admin_id' => $doctor1->id,
            ],
            [
                'id' => 4,
                'name' => 'Mpilo Central Hospital',
                'address' => 'Luveve Road, Bulawayo, Zimbabwe',
                'phone' => '+263219887651',
                'email' => 'info@mpilohospital.co.zw',
                'admin_id' => $doctor2->id,
            ],
            [
                'id' => 5,
                'name' => 'Mutare Provincial Hospital',
                'address' => 'Aerodrome Rd, Mutare, Zimbabwe',
                'phone' => '+263270642204',
                'email' => 'mutare@provhospitals.zw',
                'admin_id' => $doctor1->id,
            ],
        ];

        foreach ($hospitals as $hosp) {
            $hospital = Hospital::firstOrCreate(
                ['id' => $hosp['id']],
                [
                    'name' => $hosp['name'],
                    'address' => $hosp['address'],
                    'phone' => $hosp['phone'],
                    'email' => $hosp['email'],
                    'admin_id' => $hosp['admin_id'],
                ]
            );

            $hospital->doctors()->attach([$doctor1->id, $doctor2->id]);
        }
    }
}
