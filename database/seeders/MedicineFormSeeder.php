<?php

namespace Database\Seeders;

use App\Models\DosageForm;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MedicineFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            // Truncate the table to remove existing data
            DosageForm::truncate();

            // Define the routes data
            $routes = [
                ['id' => 1, 'name' => 'Tab', 'status' => 1],
                ['id' => 2, 'name' => 'Cap', 'status' => 1],
                ['id' => 3, 'name' => 'Syr', 'status' => 1],
                ['id' => 4, 'name' => 'Surp', 'status' => 1],
                ['id' => 5, 'name' => 'Inj', 'status' => 1],
                ['id' => 6, 'name' => 'Crm', 'status' => 1],
            ];

            // Save the data using the MedicineRoute model
            foreach ($routes as $route) {
                $medicine = new DosageForm();
                $medicine->id = $route['id'];
                $medicine->name = $route['name'];
                $medicine->status = $route['status'];
                $medicine->created_by = 1; // Set the creator ID (if applicable)
                $medicine->save();
            }
    }
}
