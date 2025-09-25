<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateServiceCategoriesCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $service_categories = ServiceCategory::where('status',1)->get();
        foreach ($service_categories as $sc) {

            $category = ServiceCategory::where('id',$sc->id)->first();
            $service_name = $category->service_name;

            $words = explode(" ", trim($service_name)); // Trim to remove extra spaces

            if (count($words) >= 2) {
                $firstLetters = strtoupper($words[0][0] . $words[1][0]); // First letters of first two words
            } else {
                $firstLetters = strtoupper($words[0][0]); // Only the first letter of the first word
            }

            $generated_code = $firstLetters . $category->id + 1000;
            $category->category_code =  $generated_code;
            $category->update();

        }
    }
}
