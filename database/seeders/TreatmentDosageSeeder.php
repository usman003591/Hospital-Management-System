<?php

namespace Database\Seeders;

use DB;
use App\Models\TreatmentDosage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TreatmentDosageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('treatment_dosage')->truncate();

        $data = [
            ['id' => 1, 'name' => '1/2', 'name_ur' => '1/2', 'status' => 1],
            ['id' => 2, 'name' => '1', 'name_ur' => '1', 'status' => 1],
            ['id' => 3, 'name' => '2', 'name_ur' => '2', 'status' => 1],
            ['id' => 4, 'name' => '3', 'name_ur' => '3', 'status' => 1],
            ['id' => 5, 'name' => '4', 'name_ur' => '4', 'status' => 1],
            ['id' => 6, 'name' => '5', 'name_ur' => '5', 'status' => 1],
            ['id' => 7, 'name' => '6', 'name_ur' => '6', 'status' => 1],
            ['id' => 8, 'name' => '7', 'name_ur' => '7', 'status' => 1],
            ['id' => 9, 'name' => '8', 'name_ur' => '8', 'status' => 1],
            ['id' => 10, 'name' => '9', 'name_ur' => '9', 'status' => 1],
            ['id' => 11, 'name' => '10', 'name_ur' => '10', 'status' => 1],
            ['id' => 12, 'name' => '11', 'name_ur' => '11', 'status' => 1],
            ['id' => 13, 'name' => '12', 'name_ur' => '12', 'status' => 1],
            ['id' => 14, 'name' => '13', 'name_ur' => '13', 'status' => 1],
            ['id' => 15, 'name' => '14', 'name_ur' => '14', 'status' => 1],
            ['id' => 16, 'name' => '15', 'name_ur' => '15', 'status' => 1],
            ['id' => 17, 'name' => '16', 'name_ur' => '16', 'status' => 1],
            ['id' => 18, 'name' => '17', 'name_ur' => '17', 'status' => 1],
            ['id' => 19, 'name' => '18', 'name_ur' => '18', 'status' => 1],
            ['id' => 20, 'name' => '19', 'name_ur' => '19', 'status' => 1],
        ];

        foreach ($data as $item) {

            $obj = new TreatmentDosage();
            $obj->name = $item['name'];
            $obj->name_ur = $item['name_ur'];
            $obj->status = $item['status'];
            $obj->created_by = 1; // Set the creator ID (if applicable)
            $obj->save();

        }
    }
}
