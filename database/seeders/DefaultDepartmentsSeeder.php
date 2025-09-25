<?php

namespace Database\Seeders;

use DB;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DefaultDepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->truncate();

        $roles = [
            ['id'=> 1,'name' => 'Medical', 'status' => 1],
            ['id'=> 2,'name' => 'Paramedical', 'status' => 1],
            ['id'=> 3,'name' => 'Pathology', 'status' => 1],
            ['id'=> 4,'name' => 'Biochemistry', 'status' => 1],
            ['id'=> 5,'name' => 'Heamatology', 'status' => 1],
            ['id'=> 6,'name' => 'Parasitology', 'status' => 1],
            ['id'=> 7,'name' => 'Serology', 'status' => 1],
        ];

        foreach ($roles as $row) {
            $role = new Department();
            $role->name = $row['name'];
            $role->status = $row['status'];
            $role->created_by = 1;
            $role->save();
        }
    }
}
