<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InvestigationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateInvestigationTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('investigation_types')->truncate();

        $types = [
            ['id'=> 1,'name' => 'Radiology', 'create_by' => 1],
            ['id'=> 2,'name' => 'Pathology', 'create_by' => 1],
            ['id'=> 3,'name' => 'Rehablitation', 'create_by' => 1],
        ];

        $radiology = 1;
        $pathology = 2;
        $rehablitation = 3;

        foreach ($types as $row) {
            $type = new InvestigationType();
            $type->name = $row['name'];
            $type->created_by = 1;
            $type->save();
        }
    }

}
