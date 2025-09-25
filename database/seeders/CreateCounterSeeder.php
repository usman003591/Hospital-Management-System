<?php

namespace Database\Seeders;

use App\Models\OPDCounter;
use Illuminate\Database\Seeder;
use App\Models\AppointmentStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateCounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('o_p_d_counters')->truncate();

        $types = [
            ['id'=> 1,'name' => '1', 'create_by' => 1],
            ['id'=> 2,'name' => '2', 'create_by' => 1],
            ['id'=> 3,'name' => '3', 'create_by' => 1],
        ];

        foreach ($types as $row) {
            $type = new OPDCounter();
            $type->name = $row['name'];
            $type->status = 1;
            $type->created_by = 1;
            $type->save();
        }
    }
}
