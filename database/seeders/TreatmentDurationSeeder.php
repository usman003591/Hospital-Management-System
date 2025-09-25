<?php

namespace Database\Seeders;

use DB;
use App\Models\TreatmentDuration;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TreatmentDurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('treatment_duration')->truncate();

        $data = [
            ['id' => 1, 'name' => '1 Day', 'name_ur' => '1 Day', 'status' => 1],
            ['id' => 2, 'name' => '2 Day', 'name_ur' => '2 Day', 'status' => 1],
            ['id' => 3, 'name' => '3 Day', 'name_ur' => '3 Day', 'status' => 1],
            // ['id' => 4, 'name' => 'TDS/TID', 'name_ur' => 'TDS/TID', 'status' => 1],
            // ['id' => 5, 'name' => 'HS (at Bedtime)', 'name_ur' => 'HS (at Bedtime)', 'status' => 1],
            // ['id' => 6, 'name' => 'SOS/PRN (as needed)', 'name_ur' => 'SOS/PRN (as needed)', 'status' => 1],
            // ['id' => 7, 'name' => '4 hourly', 'name_ur' => '4 hourly', 'status' => 1],
            // ['id' => 8, 'name' => '6 hourly', 'name_ur' => '6 hourly', 'status' => 1],
        ];

        foreach ($data as $item) {
            $obj = new TreatmentDuration();
            $obj->name = $item['name'];
            $obj->name_ur = $item['name_ur'];
            $obj->status = $item['status'];
            $obj->created_by = 1; // Set the creator ID (if applicable)
            $obj->save();
        }
    }
}
