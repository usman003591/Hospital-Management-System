<?php

namespace Database\Seeders;

use DB;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AddServiceCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('service_categories')->truncate();

        $services = [
            ['id'=> 1,'service_name' => 'Basic Services', 'default_amount' => 1000, 'employee_amount' => 500, 'resident_amount' => 700,'status' => 1,'parent_id' => 0],
            ['id'=> 2,'service_name' => 'Consultation', 'default_amount' => 1000, 'employee_amount' => 500, 'resident_amount' => 700,'status' => 1,'parent_id' => 1],
            ['id'=> 3,'service_name' => 'Electro Dianosis', 'default_amount' => 1050, 'employee_amount' => 500, 'resident_amount' => 700,'status' => 1,'parent_id' => 1],
            ['id'=> 4,'service_name' => 'Pain Procedures', 'default_amount' => 1100,'employee_amount' => 550, 'resident_amount' => 750,'status' => 1,'parent_id' => 1],
            ['id'=> 5,'service_name' => 'Phsiotherapy','default_amount' => 1200,'employee_amount' => 600, 'resident_amount' => 800,'status' => 1,'parent_id' => 1],
            ['id'=> 6,'service_name' => 'OT','default_amount' => 1250,'employee_amount' => 600, 'resident_amount' => 800,'status' => 1,'parent_id' => 1],
            ['id'=> 7,'service_name' => 'SLP','default_amount' => 1300,'employee_amount' => 650, 'resident_amount' => 850,'status' => 1,'parent_id' => 1],
            ['id'=> 8,'service_name' => 'Psychology','default_amount' => 1350,'employee_amount' => 650, 'resident_amount' => 850,'status' => 1,'parent_id' => 1],
            ['id'=> 9,'service_name' => 'Nutrition', 'default_amount' => 1400,'employee_amount' => 700, 'resident_amount' => 900,'status' => 1,'parent_id' => 1],
            ['id'=> 10,'service_name' => 'P&O', 'default_amount' => 1450,'employee_amount' => 750, 'resident_amount' => 950,'status' => 1,'parent_id' => 1],
            ['id'=> 11,'service_name' => 'Lab', 'default_amount' => 1500,'employee_amount' => 800, 'resident_amount' => 1000,'status' => 1,'parent_id' => 1],
        ];

        foreach ($services as $row) {
            $service = new ServiceCategory();
            $service->service_name = $row['service_name'];
            $service->default_amount = $row['default_amount'];
            $service->employee_amount = $row['employee_amount'];
            $service->resident_amount = $row['resident_amount'];
            $service->status = $row['status'];
            $service->parent_id = $row['parent_id'];
            $service->created_by = 1;
            $service->save();
        }
    }
}
