<?php

namespace Database\Seeders;

use DB;
use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\DiagnosisCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DiagnosisCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('diagnosis_categories')->truncate();

        $roles = [
            ['id'=> 1,'name' => 'Provisional Diagnosis', 'status' => 1],
            ['id'=> 2,'name' => 'Final Diagnosis ', 'status' => 1],
            ['id'=> 3,'name' => 'Differential Diagnosis', 'status' => 1],
            ['id'=> 4,'name' => 'Probable Diagnosis', 'status' => 1],
        ];

        foreach ($roles as $row) {
            $role = new DiagnosisCategory();
            $role->name = $row['name'];
            $role->status = $row['status'];
            $role->created_by = 1;
            $role->save();
        }
    }

}
