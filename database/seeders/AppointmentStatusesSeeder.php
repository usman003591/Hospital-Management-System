<?php

namespace Database\Seeders;

use App\Models\AppointmentStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AppointmentStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('appointment_statuses')->truncate();

        $appointment_statuses = [
            [
                'name' => 'Pending',
                'status' => 1,
                'created_by' => 1
            ],
            [
                'name' => 'Cancelled',
                'status' => 1,
                'created_by' => 1
            ],
            [
                'name' => 'Approved',
                'status' => 1,
                'created_by' => 1
            ],
        ];

        foreach ($appointment_statuses as $row) {
            AppointmentStatus::create($row);
        }
    }
}
