<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\CreateVitalsSeeder;
use Database\Seeders\MedicineFormSeeder;
use Database\Seeders\CreateCounterSeeder;
use Database\Seeders\MakeHospitalsSeeder;
use Database\Seeders\InvoiceSequenceSeeder;
use Database\Seeders\TruncateDummyDataSeeder;
use Database\Seeders\DefaultDepartmentsSeeder;
use Database\Seeders\AppointmentStatusesSeeder;
use Database\Seeders\DiagnosisCategoriesSeeder;
use Database\Seeders\AddServiceCategoriesSeeder;
use Database\Seeders\DefaultRolesCreationSeeder;
use Database\Seeders\CreateInvestigationTypesSeeder;
use Database\Seeders\CreateServiceCategoriesCodeSeeder;
use Database\Seeders\CreateServiceCategoriesParentCodeSeeder;
use Database\Seeders\ServiceCategoryHospitalAssignmentSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // DiagnosisCategoriesSeeder::class,
             PermissionsSeeder::class,
        ]);
    }
}
