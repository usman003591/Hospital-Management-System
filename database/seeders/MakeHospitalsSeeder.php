<?php

namespace Database\Seeders;

use App\Models\Hospital;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MakeHospitalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('hospitals')->truncate();

        $hospitals = [
            [
                'id' => 1,
                'name' => 'Smart Institute of Rehabilitation Medicine',
                'description' => 'Smart Institute of Rehabilitation Medicine',
                'logo' => 'logo.jpg',
                'project_logo' => 'smartcitylogo.png',
                'hospital_abbreviation' => 'SIRM',
                'status' => 1
            ],
            [
                'id' => 1,
                'name' => 'Smart City Hospital',
                'description' => 'Smart City Hospital',
                'logo' => 'logo.jpg',
                'project_logo' => 'smartcitylogo.png',
                'hospital_abbreviation' => 'SCH',
                'status' => 1
            ],
        ];

        foreach ($hospitals as $row) {
            $hospital = new Hospital();
            $hospital->name = $row['name'];
            $hospital->description = $row['description'];
            $hospital->hospital_abbreviation = $row['hospital_abbreviation'];
            $hospital->logo = $row['logo'];
            $hospital->project_logo = $row['project_logo'];
            $hospital->status = $row['status'];
            $hospital->created_by = 1;
            $hospital->save();
        }

    }
}
