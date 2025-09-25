<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceCategory;

class ServiceCategoryHospitalAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $importantIds = [1, 7, 32, 41, 48, 57, 63, 74, 80];

        DB::transaction(function () use ($importantIds) {
            // 1. Set hospital_id = 1 for matching `id` OR `parent_id`
            ServiceCategory::where(function ($query) use ($importantIds) {
                $query->whereIn('parent_id', $importantIds)
                      ->orWhereIn('id', $importantIds);
            })->update(['hospital_id' => 1]);

            // 2. All others → hospital_id = 2
            ServiceCategory::whereNot(function ($query) use ($importantIds) {
                $query->whereIn('parent_id', $importantIds)
                      ->orWhereIn('id', $importantIds);
            })->update(['hospital_id' => 2]);
        });
    }
}
