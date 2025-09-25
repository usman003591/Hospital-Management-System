<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use App\Models\TreatmentDuration;
use App\Models\TreatmentDoseInterval;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MedcineFrequecnySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('treatment_dose_interval')->truncate();

        $data = [
            ['id' => 1, 'name' => 'Stat', 'name_ur' => 'Stat', 'status' => 1],
            ['id' => 2, 'name' => 'OD (Once a day)', 'name_ur' => 'OD (Once a day)', 'status' => 1],
            ['id' => 3, 'name' => 'BD (Twice/day)', 'name_ur' => 'BD (Twice/day)', 'status' => 1],
            ['id' => 4, 'name' => 'TDS/TID', 'name_ur' => 'TDS/TID', 'status' => 1],
            ['id' => 5, 'name' => 'HS (at Bedtime)', 'name_ur' => 'HS (at Bedtime)', 'status' => 1],
            ['id' => 6, 'name' => 'SOS/PRN (as needed)', 'name_ur' => 'SOS/PRN (as needed)', 'status' => 1],
            ['id' => 7, 'name' => '4 hourly', 'name_ur' => '4 hourly', 'status' => 1],
            ['id' => 8, 'name' => '6 hourly', 'name_ur' => '6 hourly', 'status' => 1],
        ];

        foreach ($data as $item) {
            $obj = new TreatmentDoseInterval();
            $obj->name = $item['name'];
            $obj->name_ur = $item['name_ur'];
            $obj->status = $item['status'];
            $obj->created_by = 1; // Set the creator ID (if applicable)
            $obj->save();
        }

    }
}
