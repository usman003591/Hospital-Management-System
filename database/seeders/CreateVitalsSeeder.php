<?php

namespace Database\Seeders;

use App\Models\Vital;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateVitalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('vitals')->truncate();

        $vitals = [

            ['id'=> 1,'name' => 'B P', 'unit' => 'mmHg', 'is_boolean' => 0, 'status' => 1 ],
            // ['id'=> 3,'name' => 'Bmi', 'unit' => 'kg/m^2', 'is_boolean' => 0, 'status' => 1 ],
            // ['id'=> 4,'name' => 'O F C', 'unit' => 'cm', 'is_boolean' => 0, 'status' => 1 ],
            // ['id'=> 5,'name' => 'Weight', 'unit' => 'kg', 'is_boolean' => 0, 'status' => 1 ],
            // ['id'=> 6,'name' => 'Height', 'unit' => 'cm', 'is_boolean' => 0, 'status' => 1 ],
            ['id'=> 2,'name' => 'Pulse Rate', 'unit' => 'BPM', 'is_boolean' => 0, 'status' => 1 ],
            ['id'=> 3,'name' => 'Body Temperature', 'unit' => 'Fahrenheit', 'is_boolean' => 0, 'status' => 1 ],
               ['id'=> 4,'name' => 'Respiratory Rate', 'unit' => 'per minute', 'is_boolean' => 0, 'status' => 1 ],


        ];

        foreach ($vitals as $row) {
            $role = new Vital();
            $role->name = $row['name'];
            $role->unit = $row['unit'];
            $role->is_boolean = $row['is_boolean'];
            $role->status = $row['status'];
            $role->created_by = 1;
            $role->save();
        }
    }
}
