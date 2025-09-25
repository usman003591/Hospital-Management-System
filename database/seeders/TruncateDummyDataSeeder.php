<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TruncateDummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        //DB::table('invoice_services')->truncate();
        //DB::table('invoices')->truncate();
        DB::table('appointment_requests')->truncate();
        DB::table('appointment')->truncate();
        Schema::enableForeignKeyConstraints();
    }
}
