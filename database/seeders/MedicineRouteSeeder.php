<?php

namespace Database\Seeders;

use App\Models\MedicineRoute;
use Illuminate\Database\Seeder;

class MedicineRouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the table to remove existing data
        MedicineRoute::truncate();

        // Define the routes data
        $routes = [
            ['id' => 1, 'name' => 'PO (oral)', 'status' => 1],
            ['id' => 2, 'name' => 'I/V', 'status' => 1],
            ['id' => 3, 'name' => 'I/M', 'status' => 1],
            ['id' => 4, 'name' => 'SC', 'status' => 1],
            ['id' => 5, 'name' => 'PR', 'status' => 1],
            ['id' => 6, 'name' => 'Topical', 'status' => 1],
            ['id' => 7, 'name' => 'Inhalation', 'status' => 1],
        ];

        // Save the data using the MedicineRoute model
        foreach ($routes as $route) {
            $medicineRoute = new MedicineRoute();
            $medicineRoute->id = $route['id'];
            $medicineRoute->name = $route['name'];
            $medicineRoute->status = $route['status'];
            $medicineRoute->created_by = 1; // Set the creator ID (if applicable)
            $medicineRoute->save();
        }
    }
}
