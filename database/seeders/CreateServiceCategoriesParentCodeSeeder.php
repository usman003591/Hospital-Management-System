<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServiceCategory;

class CreateServiceCategoriesParentCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $service_categories = ServiceCategory::where('status',1)->get();

        foreach ($service_categories as $sc) {
            if( $sc->parent_id == 0) {

                $service_category_parent_id = $sc->id;
                $service_name = $sc->service_name;
                $words = explode(" ", trim($service_name)); // Trim to remove extra spaces

                $child_categories = ServiceCategory::where('parent_id',$service_category_parent_id)->get();

                foreach ($child_categories as $cc) {
                    $category = ServiceCategory::where('id',$cc->id)->first();

                    if (count($words) >= 2) {
                        $firstLetters = strtoupper($words[0][0] . $words[1][0]); // First letters of first two words
                    } else {
                        $firstLetters = strtoupper($words[0][0] . $words[0][1]); // Only the first two letter of the first word
                    }

                    $generated_code = $firstLetters;
                    $category->parent_code =  $generated_code;
                    $category->update();
                }
            }
        }
    }
}
