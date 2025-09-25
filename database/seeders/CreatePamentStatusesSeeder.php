<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InvoicePaymentStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreatePamentStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('invoice_payment_statuses')->truncate();

        $roles = [
            ['id'=> 1,'name' => 'Paid', 'status' => 1],
            ['id'=> 2,'name' => 'Unpaid', 'status' => 1],
            ['id'=> 3,'name' => 'Rejected', 'status' => 1],
        ];

        foreach ($roles as $row) {
            $role = new InvoicePaymentStatus();
            $role->name = $row['name'];
            $role->status = $row['status'];
            $role->created_by = 1;
            $role->save();
        }
    }
}
