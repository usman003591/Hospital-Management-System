<?php

namespace Database\Seeders;

use DB;
use App\Models\Role;
use App\Models\RoleRights;
use Illuminate\Database\Seeder;
use App\Models\RoleRightModules;
use App\Models\RoleRightsAllowed;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->truncate();
        DB::table('role_rights')->truncate();
        DB::table('role_rights_allowed')->truncate();
        DB::table('role_right_modules')->truncate();

        $roles = [
            ['id' => 1, 'name' => 'Super Admin', 'status' => 1],
            ['id' => 2, 'name' => 'Admin', 'status' => 1],
            ['id' => 3, 'name' => 'Doctor', 'status' => 1],
            ['id' => 4, 'name' => 'Receptionist', 'status' => 1],
            ['id' => 5, 'name' => 'Finance', 'status' => 1],
            ['id' => 6, 'name' => 'Laboratory Technician', 'status' => 1],
            ['id' => 7, 'name' => 'Pharmacy', 'status' => 1],
        ];

        foreach ($roles as $row) {
            $role = new Role();
            $role->name = $row['name'];
            $role->status = $row['status'];
            $role->created_by = 1;
            $role->save();
        }

        $role_right_modules = [
            [
                'id' => 1,
                'name' => 'User Management Section',
                'parent_id' => 0,
                'role_rights' => [
                    [
                        'name' => 'view section',
                        'role_right_module_id' => 1,
                    ],
                ]
            ],
            [
                'id' => 2,
                'name' => 'Roles',
                'parent_id' => 1,
                'role_rights' => [
                    [
                        'name' => 'create',
                        'role_right_module_id' => 2,
                    ],
                    [
                        'name' => 'update',
                        'role_right_module_id' => 2,
                    ],
                    [
                        'name' => 'delete',
                        'role_right_module_id' => 2,
                    ],
                    [
                        'name' => 'list',
                        'role_right_module_id' => 2,
                    ],
                    [
                        'name' => 'Permissions',
                        'role_right_module_id' => 2,
                    ],
                ]
            ],
            [
                'id' => 3,
                'name' => 'Users',
                'parent_id' => 1,
                'role_rights' => [
                    [
                        'name' => 'create',
                        'role_right_module_id' => 3,
                    ],
                    [
                        'name' => 'update',
                        'role_right_module_id' => 3,
                    ],
                    [
                        'name' => 'delete',
                        'role_right_module_id' => 3,
                    ],
                    [
                        'name' => 'list',
                        'role_right_module_id' => 3,
                    ],
                ]
            ],
            [
                'id' => 4,
                'name' => 'Performance Section',
                'parent_id' => 0,
                'role_rights' => [
                    [
                        'name' => 'view section',
                        'role_right_module_id' => 4,
                    ]
                ]
            ],
            [
                'id' => 5,
                'name' => 'Doctors Section',
                'parent_id' => 0,
                'role_rights' => [
                    [
                        'name' => 'create',
                        'role_right_module_id' => 5,
                    ],
                    [
                        'name' => 'update',
                        'role_right_module_id' => 5,
                    ],
                    [
                        'name' => 'delete',
                        'role_right_module_id' => 5,
                    ],
                    [
                        'name' => 'list',
                        'role_right_module_id' => 5,
                    ],
                ]
            ],
            [
                'id' => 6,
                'name' => 'Patients Section',
                'parent_id' => 0,
                'role_rights' => [
                    [
                        'name' => 'create',
                        'role_right_module_id' => 6,
                    ],
                    [
                        'name' => 'update',
                        'role_right_module_id' => 6,
                    ],
                    [
                        'name' => 'delete',
                        'role_right_module_id' => 6,
                    ],
                    [
                        'name' => 'list',
                        'role_right_module_id' => 6,
                    ],
                    [
                        'name' => 'download visiting card',
                        'role_right_module_id' => 6,
                    ],
                    [
                        'name' => 'detail',
                        'role_right_module_id' => 6,
                    ]
                ],
            ],
            [
                'id' => 7,
                'name' => 'Prescriptions Section',
                'parent_id' => 0,
                'role_rights' => [
                    [
                        'name' => 'create',
                        'role_right_module_id' => 7,
                    ],
                    [
                        'name' => 'update',
                        'role_right_module_id' => 7,
                    ],
                    [
                        'name' => 'delete',
                        'role_right_module_id' => 7,
                    ],
                    [
                        'name' => 'list',
                        'role_right_module_id' => 7,
                    ],
                    [
                        'name' => 'download prescription slip',
                        'role_right_module_id' => 7,
                    ],
                ],
            ],
            [
                'id' => 8,
                'name' => 'Invoices Section',
                'parent_id' => 0,
                'role_rights' => [
                    ['name' => 'view section', 'role_right_module_id' => 8],
                ],
            ],
            [
                'id' => 9,
                'name' => 'Reports Section',
                'parent_id' => 0,
                'role_rights' => [
                    ['name' => 'view section', 'role_right_module_id' => 9],
                    ['name' => 'create', 'role_right_module_id' => 9],
                    ['name' => 'cash-details-report', 'role_right_module_id' => 9],
                    ['name' => 'patient-details-prescription-report', 'role_right_module_id' => 9],
                    ['name' => 'Download', 'role_right_module_id' => 9,],
                ],
            ],
            [
                'id' => 10,
                'name' => 'Settings Section',
                'parent_id' => 0,
                'role_rights' =>
                    [
                        ['name' => 'view section', 'role_right_module_id' => 10],
                    ],
            ],
            [
                'id' => 11,
                'name' => 'Service Categories',
                'parent_id' => 10,
                'role_rights' => [
                    [
                        'name' => 'create',
                        'role_right_module_id' => 11,
                    ],
                    [
                        'name' => 'update',
                        'role_right_module_id' => 11,
                    ],
                    [
                        'name' => 'delete',
                        'role_right_module_id' => 11,
                    ],
                    [
                        'name' => 'list',
                        'role_right_module_id' => 11,
                    ],
                ],
            ],
            [
                'id' => 12,
                'name' => 'Departments',
                'parent_id' => 10,
                'role_rights' => [
                    [
                        'name' => 'create',
                        'role_right_module_id' => 12,
                    ],
                    [
                        'name' => 'update',
                        'role_right_module_id' => 12,
                    ],
                    [
                        'name' => 'delete',
                        'role_right_module_id' => 12,
                    ],
                    [
                        'name' => 'list',
                        'role_right_module_id' => 12,
                    ],
                ],
            ],
            [
                'id' => 13,
                'name' => 'Invoice Payment Statuses',
                'parent_id' => 10,
                'role_rights' => [
                    [
                        'name' => 'create',
                        'role_right_module_id' => 13,
                    ],
                    [
                        'name' => 'update',
                        'role_right_module_id' => 13,
                    ],
                    [
                        'name' => 'delete',
                        'role_right_module_id' => 13,
                    ],
                    [
                        'name' => 'list',
                        'role_right_module_id' => 13,
                    ],
                ],
            ],
            [
                'id' => 14,
                'name' => 'Medication Quantity',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 14],
                    ['name' => 'update', 'role_right_module_id' => 14],
                    ['name' => 'delete', 'role_right_module_id' => 14],
                    ['name' => 'list', 'role_right_module_id' => 14],
                ]
            ],
            [
                'id' => 15,
                'name' => 'Medication Frequency',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 15],
                    ['name' => 'update', 'role_right_module_id' => 15],
                    ['name' => 'delete', 'role_right_module_id' => 15],
                    ['name' => 'list', 'role_right_module_id' => 15],
                ]
            ],
            [
                'id' => 16,
                'name' => 'Medication Dose Interval',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 16],
                    ['name' => 'update', 'role_right_module_id' => 16],
                    ['name' => 'delete', 'role_right_module_id' => 16],
                    ['name' => 'list', 'role_right_module_id' => 16],
                ]
            ],
            [
                'id' => 17,
                'name' => 'Brands',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 17],
                    ['name' => 'update', 'role_right_module_id' => 17],
                    ['name' => 'delete', 'role_right_module_id' => 17],
                    ['name' => 'list', 'role_right_module_id' => 17],
                ]
            ],
            [
                'id' => 18,
                'name' => 'Admit Patients',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 18],
                    ['name' => 'update', 'role_right_module_id' => 18],
                    ['name' => 'delete', 'role_right_module_id' => 18],
                    ['name' => 'list', 'role_right_module_id' => 18],
                ]
            ],
            [
                'id' => 19,
                'name' => 'Medicine Routes',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 19],
                    ['name' => 'update', 'role_right_module_id' => 19],
                    ['name' => 'delete', 'role_right_module_id' => 19],
                    ['name' => 'list', 'role_right_module_id' => 19],
                ]
            ],
            [
                'id' => 20,
                'name' => 'Complaints',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 20],
                    ['name' => 'update', 'role_right_module_id' => 20],
                    ['name' => 'delete', 'role_right_module_id' => 20],
                    ['name' => 'list', 'role_right_module_id' => 20],
                ]
            ],
            [
                'id' => 21,
                'name' => 'General Physical Examination',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 21],
                    ['name' => 'update', 'role_right_module_id' => 21],
                    ['name' => 'delete', 'role_right_module_id' => 21],
                    ['name' => 'list', 'role_right_module_id' => 21],
                ]
            ],
            [
                'id' => 22,
                'name' => 'Systematic Physical Examination',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 22],
                    ['name' => 'update', 'role_right_module_id' => 22],
                    ['name' => 'delete', 'role_right_module_id' => 22],
                    ['name' => 'list', 'role_right_module_id' => 22],
                ]
            ],
            [
                'id' => 23,
                'name' => 'Vitals',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 23],
                    ['name' => 'update', 'role_right_module_id' => 23],
                    ['name' => 'delete', 'role_right_module_id' => 23],
                    ['name' => 'list', 'role_right_module_id' => 23],
                ]
            ],
            [
                'id' => 24,
                'name' => 'Medicines',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 24],
                    ['name' => 'update', 'role_right_module_id' => 24],
                    ['name' => 'delete', 'role_right_module_id' => 24],
                    ['name' => 'list', 'role_right_module_id' => 24],
                ]
            ],
            [
                'id' => 25,
                'name' => 'Diagnosis',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 25],
                    ['name' => 'update', 'role_right_module_id' => 25],
                    ['name' => 'delete', 'role_right_module_id' => 25],
                    ['name' => 'list', 'role_right_module_id' => 25],
                ]
            ],
            [
                'id' => 26,
                'name' => 'Investigations',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 26],
                    ['name' => 'update', 'role_right_module_id' => 26],
                    ['name' => 'delete', 'role_right_module_id' => 26],
                    ['name' => 'list', 'role_right_module_id' => 26],
                ]
            ],
            [
                'id' => 27,
                'name' => 'Investigation Types',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 27],
                    ['name' => 'update', 'role_right_module_id' => 27],
                    ['name' => 'delete', 'role_right_module_id' => 27],
                    ['name' => 'list', 'role_right_module_id' => 27],
                ]
            ],
            [
                'id' => 28,
                'name' => 'Hospitals',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 28],
                    ['name' => 'update', 'role_right_module_id' => 28],
                    ['name' => 'delete', 'role_right_module_id' => 28],
                    ['name' => 'list', 'role_right_module_id' => 28],
                ]
            ],
            [
                'id' => 29,
                'name' => 'Import Data',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'list', 'role_right_module_id' => 29],
                ]
            ],
            [
                'id' => 30,
                'name' => 'Appointment Statuses',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 30],
                    ['name' => 'update', 'role_right_module_id' => 30],
                    ['name' => 'delete', 'role_right_module_id' => 30],
                    ['name' => 'list', 'role_right_module_id' => 30],
                ]
            ],
            [
                'id' => 31,
                'name' => 'Procedures',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 31],
                    ['name' => 'update', 'role_right_module_id' => 31],
                    ['name' => 'delete', 'role_right_module_id' => 31],
                    ['name' => 'list', 'role_right_module_id' => 31],
                ]
            ],
            [
                'id' => 32,
                'name' => 'Dosage Forms',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 32],
                    ['name' => 'update', 'role_right_module_id' => 32],
                    ['name' => 'delete', 'role_right_module_id' => 32],
                    ['name' => 'list', 'role_right_module_id' => 32],
                ]
            ],
            [
                'id' => 33,
                'name' => 'Hospital Setup Section',
                'parent_id' => 0,
                'role_rights' => [
                    ['name' => 'view section', 'role_right_module_id' => 33],
                ]
            ],
            [
                'id' => 34,
                'name' => 'Floors',
                'parent_id' => 33,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 34],
                    ['name' => 'update', 'role_right_module_id' => 34],
                    ['name' => 'delete', 'role_right_module_id' => 34],
                    ['name' => 'list', 'role_right_module_id' => 34],
                ]
            ],
            [
                'id' => 35,
                'name' => 'Wards',
                'parent_id' => 33,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 35],
                    ['name' => 'update', 'role_right_module_id' => 35],
                    ['name' => 'delete', 'role_right_module_id' => 35],
                    ['name' => 'list', 'role_right_module_id' => 35],
                ]
            ],
            [
                'id' => 36,
                'name' => 'Beds',
                'parent_id' => 33,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 36],
                    ['name' => 'update', 'role_right_module_id' => 36],
                    ['name' => 'delete', 'role_right_module_id' => 36],
                    ['name' => 'list', 'role_right_module_id' => 36],
                ]
            ],
            [
                'id' => 37,
                'name' => 'Rooms',
                'parent_id' => 33,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 37],
                    ['name' => 'update', 'role_right_module_id' => 37],
                    ['name' => 'delete', 'role_right_module_id' => 37],
                    ['name' => 'list', 'role_right_module_id' => 37],
                ]
            ],
            [
                'id' => 38,
                'name' => 'Appointments Sections',
                'parent_id' => 0,
                'role_rights' => [
                    ['name' => 'view section', 'role_right_module_id' => 38],
                ]
            ],
            [
                'id' => 39,
                'name' => 'Appointment Requests',
                'parent_id' => 38,
                'role_rights' => [
                    ['name' => 'delete', 'role_right_module_id' => 39],
                    ['name' => 'list', 'role_right_module_id' => 39],
                    ['name' => 'detail', 'role_right_module_id' => 39],
                ]
            ],
            [
                'id' => 40,
                'name' => 'Appointments',
                'parent_id' => 38,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 40],
                    ['name' => 'update', 'role_right_module_id' => 40],
                    ['name' => 'delete', 'role_right_module_id' => 40],
                    ['name' => 'list', 'role_right_module_id' => 40],
                ]
            ],
            [
                'id' => 41,
                'name' => 'Pharmacy Section',
                'parent_id' => 0,
                'role_rights' => [
                    ['name' => 'view section', 'role_right_module_id' => 41],
                ]
            ],
            [
                'id' => 42,
                'name' => 'Patient Medicines',
                'parent_id' => 41,
                'role_rights' => [
                    ['name' => 'detail', 'role_right_module_id' => 42],
                    ['name' => 'list', 'role_right_module_id' => 42],
                ]
            ],
            [
                'id' => 43,
                'name' => 'Pharmacy Cashiers',
                'parent_id' => 41,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 43],
                    ['name' => 'update', 'role_right_module_id' => 43],
                    ['name' => 'delete', 'role_right_module_id' => 43],
                    ['name' => 'list', 'role_right_module_id' => 43],
                ]
            ],
            [
                'id' => 44,
                'name' => 'Medicine Categories',
                'parent_id' => 41,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 44],
                    ['name' => 'update', 'role_right_module_id' => 44],
                    ['name' => 'delete', 'role_right_module_id' => 44],
                    ['name' => 'list', 'role_right_module_id' => 44],
                ]
            ],
            [
                'id' => 45,
                'name' => 'Medicine Inventory Status',
                'parent_id' => 41,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 45],
                    ['name' => 'update', 'role_right_module_id' => 45],
                    ['name' => 'delete', 'role_right_module_id' => 45],
                    ['name' => 'list', 'role_right_module_id' => 45],
                ]
            ],
            [
                'id' => 46,
                'name' => 'Payment Methods',
                'parent_id' => 41,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 46],
                    ['name' => 'update', 'role_right_module_id' => 46],
                    ['name' => 'delete', 'role_right_module_id' => 46],
                    ['name' => 'list', 'role_right_module_id' => 46],
                ]
            ],
            [
                'id' => 47,
                'name' => 'Order Status',
                'parent_id' => 41,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 47],
                    ['name' => 'update', 'role_right_module_id' => 47],
                    ['name' => 'delete', 'role_right_module_id' => 47],
                    ['name' => 'list', 'role_right_module_id' => 47],
                ]
            ],
            [
                'id' => 48,
                'name' => 'OPD Section',
                'parent_id' => 0,
                'role_rights' => [
                    ['name' => 'view section', 'role_right_module_id' => 48],

                ]
            ],
            [
                'id' => 49,
                'name' => 'All',
                'parent_id' => 48,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 49],
                    ['name' => 'update', 'role_right_module_id' => 49],
                    ['name' => 'delete', 'role_right_module_id' => 49],
                    ['name' => 'list', 'role_right_module_id' => 49],
                    ['name' => 'download', 'role_right_module_id' => 49],
                    ['name' => 'detail', 'role_right_module_id' => 49],
                    ['name' => 'preview', 'role_right_module_id' => 49],
                    ['name' => 'vitals', 'role_right_module_id' => 49],
                    ['name' => 'snapshot', 'role_right_module_id' => 49],
                    ['name' => 'history', 'role_right_module_id' => 49],
                    ['name' => 'laboratory', 'role_right_module_id' => 49],
                ]
            ],
            [
                'id' => 50,
                'name' => 'Doctor OPD',
                'parent_id' => 48,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 50],
                    ['name' => 'update', 'role_right_module_id' => 50],
                    ['name' => 'delete', 'role_right_module_id' => 50],
                    ['name' => 'list', 'role_right_module_id' => 50],
                    ['name' => 'download', 'role_right_module_id' => 50],
                    ['name' => 'detail', 'role_right_module_id' => 50],
                    ['name' => 'preview', 'role_right_module_id' => 50],
                    ['name' => 'vitals', 'role_right_module_id' => 50],
                    ['name' => 'snapshot', 'role_right_module_id' => 50],
                    ['name' => 'history', 'role_right_module_id' => 50],
                    ['name' => 'laboratory', 'role_right_module_id' => 50],
                ]
            ],
            [
                'id' => 51,
                'name' => 'Deposit Slips Section',
                'parent_id' => 0,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 51],
                    ['name' => 'update', 'role_right_module_id' => 51],
                    ['name' => 'delete', 'role_right_module_id' => 51],
                    ['name' => 'list', 'role_right_module_id' => 51],
                    ['name' => 'download', 'role_right_module_id' => 51],
                ]
            ],
            [
                'id' => 52,
                'name' => 'User Preferences Section',
                'parent_id' => 0,
                'role_rights' => [
                    ['name' => 'change', 'role_right_module_id' => 52],
                ]
            ],
            [
                'id' => 53,
                'name' => 'Profile Section',
                'parent_id' => 0,
                'role_rights' => [
                    ['name' => 'view section', 'role_right_module_id' => 53],
                    ['name' => 'overview', 'role_right_module_id' => 53],
                    ['name' => 'change profile detail', 'role_right_module_id' => 53],
                    ['name' => 'change password', 'role_right_module_id' => 53],
                ]
            ],
            [
                'id' => 54,
                'name' => 'Pathology Lab Section',
                'parent_id' => 0,
                'role_rights' => [
                    ['name' => 'view section', 'role_right_module_id' => 54],
                ]
            ],
            [
                'id' => 55,
                'name' => 'Lab Groups',
                'parent_id' => 54,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 55],
                    ['name' => 'update', 'role_right_module_id' => 55],
                    ['name' => 'delete', 'role_right_module_id' => 55],
                    ['name' => 'list', 'role_right_module_id' => 55],
                    ['name' => 'download', 'role_right_module_id' => 55],
                    ['name' => 'detail', 'role_right_module_id' => 55],
                    ['name' => 'change_status', 'role_right_module_id' => 55],
                ]
            ],
            [
                'id' => 56,
                'name' => 'Lab Group Detail',
                'parent_id' => 54,
                'role_rights' => [
                    ['name' => 'view section', 'role_right_module_id' => 56],
                    ['name' => 'add lab test', 'role_right_module_id' => 56],
                    ['name' => 'delete lab test', 'role_right_module_id' => 56],
                    ['name' => 'add lab test data', 'role_right_module_id' => 56],
                    ['name' => 'change lab test status', 'role_right_module_id' => 56],
                    ['name' => 'download lab test', 'role_right_module_id' => 56],
                ]
            ],
            [
                'id' => 57,
                'name' => 'OPD Counter',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 57],
                    ['name' => 'update', 'role_right_module_id' => 57],
                    ['name' => 'delete', 'role_right_module_id' => 57],
                    ['name' => 'list', 'role_right_module_id' => 57],
                ]
            ],
            [
                'id' => 58,
                'name' => 'Medicine Durations',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 58],
                    ['name' => 'update', 'role_right_module_id' => 58],
                    ['name' => 'delete', 'role_right_module_id' => 58],
                    ['name' => 'list', 'role_right_module_id' => 58],
                ]
            ],
            [
                'id' => 59,
                'name' => 'Investigations Custom Fields',
                'parent_id' => 10,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 59],
                    ['name' => 'update', 'role_right_module_id' => 59],
                    ['name' => 'delete', 'role_right_module_id' => 59],
                    ['name' => 'list', 'role_right_module_id' => 59],
                ]
            ],
            [
                'id' => 60,
                'name' => 'Lab Invoices',
                'parent_id' => 8,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 60],
                    ['name' => 'update', 'role_right_module_id' => 60],
                    ['name' => 'delete', 'role_right_module_id' => 60],
                    ['name' => 'list', 'role_right_module_id' => 60],
                    ['name' => 'download', 'role_right_module_id' => 60],
                ]
            ],
            [
                'id' => 61,
                'name' => 'Finance Management',
                'parent_id' => 0,
                'role_rights' => [
                    ['name' => 'view section', 'role_right_module_id' => 61],

                ]
            ],
            [
                'id' => 62,
                'name' => 'Service Invoices Verification',
                'parent_id' => 61,
                'role_rights' => [
                    ['name' => 'list', 'role_right_module_id' => 62],
                    ['name' => 'download', 'role_right_module_id' => 62],
                    ['name' => 'detail', 'role_right_module_id' => 62],
                ]
            ],
            [
                'id' => 63,
                'name' => 'Pharmacy Invoices Verification',
                'parent_id' => 61,
                'role_rights' => [
                    ['name' => 'list', 'role_right_module_id' => 63],
                    ['name' => 'download', 'role_right_module_id' => 63],
                    ['name' => 'detail', 'role_right_module_id' => 63],
                ]
            ],
            [
                'id' => 64,
                'name' => 'Pathology Invoices Verification',
                'parent_id' => 61,
                'role_rights' => [
                    ['name' => 'list', 'role_right_module_id' => 64],
                    ['name' => 'download', 'role_right_module_id' => 64],
                    ['name' => 'detail', 'role_right_module_id' => 64],
                ]
            ],
            [
                'id' => 65,
                'name' => 'Services Invoices',
                'parent_id' => 8,
                'role_rights' => [
                    [
                        'name' => 'create',
                        'role_right_module_id' => 65,
                    ],
                    [
                        'name' => 'update',
                        'role_right_module_id' => 65,
                    ],
                    [
                        'name' => 'delete',
                        'role_right_module_id' => 65,
                    ],
                    [
                        'name' => 'list',
                        'role_right_module_id' => 65,
                    ],
                    [
                        'name' => 'download',
                        'role_right_module_id' => 65,
                    ],
                ]
            ],
            [
                'id' => 66,
                'name' => 'Notifications',
                'parent_id' => 0,
                'role_rights' => [
                    ['name' => 'view section', 'role_right_module_id' => 66],

                ]
            ],
            [
                'id' => 67,
                'name' => 'Notification Categories',
                'parent_id' => 66,
                'role_rights' => [
                    [
                        'name' => 'create',
                        'role_right_module_id' => 67,
                    ],
                    [
                        'name' => 'update',
                        'role_right_module_id' => 67,
                    ],
                    [
                        'name' => 'delete',
                        'role_right_module_id' => 67,
                    ],
                    [
                        'name' => 'list',
                        'role_right_module_id' => 67,
                    ],
                    [
                        'name' => 'download',
                        'role_right_module_id' => 67,
                    ],
                ]
            ],
            [
                'id' => 68,
                'name' => 'Notifications',
                'parent_id' => 66,
                'role_rights' => [
                    [
                        'name' => 'create',
                        'role_right_module_id' => 68,
                    ],
                    [
                        'name' => 'update',
                        'role_right_module_id' => 68,
                    ],
                    [
                        'name' => 'delete',
                        'role_right_module_id' => 68,
                    ],
                    [
                        'name' => 'list',
                        'role_right_module_id' => 68,
                    ],
                    [
                        'name' => 'download',
                        'role_right_module_id' => 68,
                    ],
                ]
            ],
            [
                'id' => 69,
                'name' => 'OPD Dashboard',
                'parent_id' => 4,
                'role_rights' => [
                       [
                        'name' => 'view',
                        'role_right_module_id' => 69,
                    ],
                    [
                        'name' => 'Dashboard actions',
                        'role_right_module_id' => 69,
                    ],
                    [
                        'name' => 'Dashboard stats',
                        'role_right_module_id' => 69,
                    ]
                ]
            ],
            [
                'id' => 70,
                'name' => 'Summary',
                'parent_id' => 61,
                'role_rights' => [
                    [ 'name' => 'view summary', 'role_right_module_id' => 70,],
                    [ 'name' => 'generate summary pdf', 'role_right_module_id' => 70]
                ]
            ],
            [
                'id' => 71,
                'name' => 'Pharmacy Inventory',
                'parent_id' => 41,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 71],
                    ['name' => 'update', 'role_right_module_id' => 71],
                    ['name' => 'delete', 'role_right_module_id' => 71],
                    ['name' => 'inventory batches', 'role_right_module_id' => 71],
                    ['name' => 'list', 'role_right_module_id' => 71],
                ]
            ],
            [
                'id' => 72,
                'name' => 'Pharmacy Inventory Batches',
                'parent_id' => 41,
                'role_rights' => [
                    ['name' => 'create', 'role_right_module_id' => 72],
                    ['name' => 'update', 'role_right_module_id' => 72],
                    ['name' => 'delete', 'role_right_module_id' => 72],
                    ['name' => 'download barcode', 'role_right_module_id' => 72],
                ]
            ],
            [
                'id' => 73,
                'name' => 'Pharmacy Dashboard',
                'parent_id' => 4,
                'role_rights' => [
                    [
                        'name' => 'view',
                        'role_right_module_id' => 73,
                    ],
                    [
                        'name' => 'Dashboard actions',
                        'role_right_module_id' => 73,
                    ],
                    [
                        'name' => 'Dashboard stats',
                        'role_right_module_id' => 73,
                    ]
                ]
            ],
            [
                'id' => 74,
                'name' => 'Pathology Dashboard',
                'parent_id' => 4,
                'role_rights' => [
                    [
                        'name' => 'view',
                        'role_right_module_id' => 74,
                    ],
                    [
                        'name' => 'Dashboard actions',
                        'role_right_module_id' => 74,
                    ],
                    [
                        'name' => 'Dashboard stats',
                        'role_right_module_id' => 74,
                    ]
                ]
            ],
            [
                'id' => 75,
                'name' => 'Doctor Dashboard',
                'parent_id' => 4,
                'role_rights' => [
                    [
                        'name' => 'view',
                        'role_right_module_id' => 75,
                    ],
                    [
                        'name' => 'Dashboard actions',
                        'role_right_module_id' => 75,
                    ],
                    [
                        'name' => 'Dashboard stats',
                        'role_right_module_id' => 75,
                    ]
                ]
            ],
            [
                'id' => 76,
                'name' => 'Finance Dashboard',
                'parent_id' => 4,
                'role_rights' => [
                    // [
                    //     'name' => 'Dashboard actions',
                    //     'role_right_module_id' => 76,
                    // ],
                        [
                        'name' => 'view',
                        'role_right_module_id' => 76,
                    ],
                    [
                        'name' => 'Dashboard stats',
                        'role_right_module_id' => 76,
                    ]
                ]
            ],
        ];

        foreach ($role_right_modules as $row) {

            $module = new RoleRightModules();
            $module->name = $row['name'];
            $module->parent_id = $row['parent_id'];
            $module->created_by = 1;
            $module->save();

            if ($row['role_rights']) {
                foreach ($row['role_rights'] as $role_rights_row) {
                    $rights_slug = $this->createRoleRightSlug($role_rights_row['name'], $row['name'], $role_rights_row['role_right_module_id']);
                    if ($rights_slug) {
                        if (
                            !RoleRights::where('rights_slug', '=', $rights_slug)
                                ->where('role_right_module_id', $role_rights_row['role_right_module_id'])->exists()
                        ) {
                            $obj = new RoleRights();
                            $obj->name = $role_rights_row['name'];
                            $obj->role_right_module_id = $role_rights_row['role_right_module_id'];
                            $obj->rights_slug = $rights_slug;
                            $obj->created_by = 1;
                            $obj->save();
                        }
                    }
                }
            }
        }

        $role_id = 2;
        $role = Role::find(id: $role_id);
        $permissions = [
                'view_section_performance_section_4',
                'view_opd_dashboard_69',
                'dashboard_actions_opd_dashboard_69',
                'dashboard_stats_opd_dashboard_69',
                'create_doctors_section_5',
                'update_doctors_section_5',
                'list_doctors_section_5',
                'create_patients_section_6',
                'update_patients_section_6',
                'list_patients_section_6',
                'download_visiting_card_patients_section_6',
                'detail_patients_section_6',
                'create_prescriptions_section_7',
                'delete_prescriptions_section_7',
                'list_prescriptions_section_7',
                'download_prescription_slip_prescriptions_section_7',
                'view_section_invoices_section_8',
                'create_lab_invoices_60',
                'create_services_invoices_65',
                'list_lab_invoices_60',
                'list_services_invoices_65',
                'download_lab_invoices_60',
                'download_services_invoices_65',
                'view_section_reports_section_9',
                'create_reports_section_9',
                'cash_details_report_reports_section_9',
                'patient_details_prescription_report_reports_section_9',
                'download_reports_section_9',
                'view_section_opd_section_48',
                'create_all_49',
                'list_all_49',
                'download_all_49',
                'detail_all_49',
                'preview_all_49',
                'vitals_all_49',
                'snapshot_all_49',
                'history_all_49',
                'create_deposit_slips_section_51',
                'update_deposit_slips_section_51',
                'list_deposit_slips_section_51',
                'download_deposit_slips_section_51',
                'view_section_profile_section_53',
                'overview_profile_section_53',
                'change_profile_detail_profile_section_53',
                'change_password_profile_section_53',
         ];

        foreach ($permissions as $ap) {
            $role_right = RoleRights::where('rights_slug', $ap)->first();
            $role_right_id = $role_right->id;

            $matchThese = ['role_id' => $role->id, 'role_right_id' => $role_right_id];
            RoleRightsAllowed::updateOrCreate($matchThese, ['name' => 'temp', 'created_by' => 1]);
        }

        $role_id = 3;  // Doctor
        $role = Role::find(id: $role_id);
        $permissions = [
            'view_section_performance_section_4',
            'list_patients_section_6',
            'detail_patients_section_6',
            'view_section_opd_section_48',
            'list_all_49',
            'detail_all_49',
            'preview_all_49',
            'vitals_all_49',
            'snapshot_all_49',
            'history_all_49',
            'list_doctor_opd_50',
            'detail_doctor_opd_50',
            'preview_doctor_opd_50',
            'vitals_doctor_opd_50',
            'snapshot_doctor_opd_50',
            'history_doctor_opd_50',
            'view_section_profile_section_53',
            'overview_profile_section_53',
            'change_profile_detail_profile_section_53',
            'change_password_profile_section_53',
            'view_doctor_dashboard_75',
            'dashboard_actions_doctor_dashboard_75',
            'dashboard_stats_doctor_dashboard_75',
        ];

        foreach ($permissions as $ap) {
            $role_right = RoleRights::where('rights_slug', $ap)->first();
            $role_right_id = $role_right->id;

            $matchThese = ['role_id' => $role->id, 'role_right_id' => $role_right_id];
            RoleRightsAllowed::updateOrCreate($matchThese, ['name' => 'temp', 'created_by' => 1]);
        }

        $role_id = 4;  // Receptionist
        $role = Role::find(id: $role_id);
        $permissions = [
            'view_section_performance_section_4',
                'create_patients_section_6',
                'update_patients_section_6',
                'list_patients_section_6',
                'download_visiting_card_patients_section_6',
                'detail_patients_section_6',
                'create_prescriptions_section_7',
                'update_prescriptions_section_7',
                'delete_prescriptions_section_7',
                'list_prescriptions_section_7',
                'download_prescription_slip_prescriptions_section_7',
                'view_section_invoices_section_8',
                'view_section_opd_section_48',
                'create_all_49',
                'update_all_49',
                'list_all_49',
                'download_all_49',
                'preview_all_49',
                'vitals_all_49',
                'snapshot_all_49',
                'create_deposit_slips_section_51',
                'update_deposit_slips_section_51',
                'list_deposit_slips_section_51',
                'download_deposit_slips_section_51',
                'create_services_invoices_65',
                'update_services_invoices_65',
                'list_services_invoices_65',
                'download_services_invoices_65',
                'view_opd_dashboard_69',
                'dashboard_actions_opd_dashboard_69',
        ];

        foreach ($permissions as $ap) {
            $role_right = RoleRights::where('rights_slug', $ap)->first();
            $role_right_id = $role_right->id;

            $matchThese = ['role_id' => $role->id, 'role_right_id' => $role_right_id];
            RoleRightsAllowed::updateOrCreate($matchThese, ['name' => 'temp', 'created_by' => 1]);
        }

        $role_id = 5;  // Finance
        $role = Role::find(id: $role_id);
        $permissions = [
            'view_section_performance_section_4',
            'view_section_finance_management_61',
            'list_service_invoices_verification_62',
            'download_service_invoices_verification_62',
            'detail_service_invoices_verification_62',
            'list_pharmacy_invoices_verification_63',
            'download_pharmacy_invoices_verification_63',
            'detail_pharmacy_invoices_verification_63',
            'list_pathology_invoices_verification_64',
            'download_pathology_invoices_verification_64',
            'detail_pathology_invoices_verification_64',
            'view_summary_summary_70',
            'generate_summary_pdf_summary_70',
            'view_finance_dashboard_76',
            'dashboard_stats_finance_dashboard_76',
        ];

        foreach ($permissions as $ap) {
            $role_right = RoleRights::where('rights_slug', $ap)->first();
            $role_right_id = $role_right->id;

            $matchThese = ['role_id' => $role->id, 'role_right_id' => $role_right_id];
            RoleRightsAllowed::updateOrCreate($matchThese, ['name' => 'temp', 'created_by' => 1]);
        }

        $role_id = 6;  // Laboratory Technician
        $role = Role::find(id: $role_id);
        $permissions = [
                'view_section_performance_section_4',
                'view_section_invoices_section_8',
                'view_section_opd_section_48',
                'list_all_49',
                'laboratory_all_49',
                'view_section_profile_section_53',
                'overview_profile_section_53',
                'change_profile_detail_profile_section_53',
                'change_password_profile_section_53',
                'view_section_pathology_lab_section_54',
                'create_lab_groups_55',
                'update_lab_groups_55',
                'delete_lab_groups_55',
                'list_lab_groups_55',
                'download_lab_groups_55',
                'detail_lab_groups_55',
                'change_status_lab_groups_55',
                'view_section_lab_group_detail_56',
                'add_lab_test_lab_group_detail_56',
                'delete_lab_test_lab_group_detail_56',
                'add_lab_test_data_lab_group_detail_56',
                'change_lab_test_status_lab_group_detail_56',
                'download_lab_test_lab_group_detail_56',
                'list_lab_invoices_60',
                'download_lab_invoices_60',
                'view_pathology_dashboard_74',
                'dashboard_actions_pathology_dashboard_74',
                'dashboard_stats_pathology_dashboard_74',
        ];

        foreach ($permissions as $ap) {
            $role_right = RoleRights::where('rights_slug', $ap)->first();
            $role_right_id = $role_right->id;

            $matchThese = ['role_id' => $role->id, 'role_right_id' => $role_right_id];
            RoleRightsAllowed::updateOrCreate($matchThese, ['name' => 'temp', 'created_by' => 1]);
        }


        $role_id = 7;  // Pharmacy Technician
        $role = Role::find(id: $role_id);
        $permissions = [
                'view_section_performance_section_4',
                'view_section_pharmacy_section_41',
                'detail_patient_medicines_42',
                'list_patient_medicines_42',
                'create_pharmacy_inventory_71',
                'update_pharmacy_inventory_71',
                'delete_pharmacy_inventory_71',
                'inventory_batches_pharmacy_inventory_71',
                'list_pharmacy_inventory_71',
                'create_pharmacy_inventory_batches_72',
                'update_pharmacy_inventory_batches_72',
                'delete_pharmacy_inventory_batches_72',
                'download_barcode_pharmacy_inventory_batches_72',
                'view_pharmacy_dashboard_73',
                'dashboard_actions_pharmacy_dashboard_73',
                'dashboard_stats_pharmacy_dashboard_73',
        ];

        foreach ($permissions as $ap) {
            $role_right = RoleRights::where('rights_slug', $ap)->first();
            $role_right_id = $role_right->id;

            $matchThese = ['role_id' => $role->id, 'role_right_id' => $role_right_id];
            RoleRightsAllowed::updateOrCreate($matchThese, ['name' => 'temp', 'created_by' => 1]);
        }
    }

    public function createRoleRightSlug($str, $module_name, $module, $delimiter = '_')
    {

        $vars = explode(" ", $str);
        $data = '';

        $slug = strtolower(trim(preg_replace(
            '/[\s-]+/',
            $delimiter,
            preg_replace(
                '/[^A-Za-z0-9-]+/',
                $delimiter,
                preg_replace(
                    '/[&]/',
                    'and',
                    preg_replace(
                        '/[\']/',
                        '',
                        iconv('UTF-8', 'ASCII//TRANSLIT', $str)
                    )
                )
            )
        ), $delimiter));

        $module_name = strtolower(trim(preg_replace(
            '/[\s-]+/',
            $delimiter,
            preg_replace(
                '/[^A-Za-z0-9-]+/',
                $delimiter,
                preg_replace(
                    '/[&]/',
                    'and',
                    preg_replace(
                        '/[\']/',
                        '',
                        iconv('UTF-8', 'ASCII//TRANSLIT', $module_name)
                    )
                )
            )
        ), $delimiter));

        return $slug . '_' . strtolower($module_name) . '_' . $module;

    }
}
