<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use DB;

class DefaultRolesCreationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->truncate();

        $roles = [
            ['id'=> 1,'name' => 'Super Admin', 'status' => 1],
            ['id'=> 2,'name' => 'Admin', 'status' => 1],
            ['id'=> 3,'name' => 'Member', 'status' => 1],
        ];

        foreach ($roles as $row) {
            $role = new Role();
            $role->name = $row['name'];
            $role->status = $row['status'];
            $role->created_by = 1;
            $role->save();
        }
    }
}
