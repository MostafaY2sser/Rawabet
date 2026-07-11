<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = [
            // // Customers
            // 'view customers',
            // 'create customers',
            // 'edit customers',
            // 'delete customers',
            // 'view customers.requests',
            // // Providers
            // 'view providers',
            // 'create providers',
            // 'edit providers',
            // 'delete providers',
            // 'view providers.requests',
            
            // // Projects
            // 'view projects.pending',
            // 'edit projects.pending',
            // 'delete projects.pending',
            // 'view projects.active',
            // 'edit projects.active',
            // 'delete projects.active',
            // 'view projects.completed',
            // // Inspections
            // 'view inspections',
            // 'create inspections',
            // 'edit inspections',
            // 'delete inspections',
            

            // // Offers
            // 'view offers.pending',
            // 'approve offers.pending',
            // 'reject offers.pending',
            // 'view offers.active',
            // 'edit offers.active',
            // 'view offers.completed',
            // 'view projects.workstages',
            // 'update projects.workstages',
            // 'view inspections.reports',
            // 'create inspections.reports',
            // 'view projects.workReports',
            // 'create projects.workReports',
            // 'view offers.additionalServices',
            // 'create offers.additionalServices',


            // // manage users
            // 'view users',
            // 'edit users',
            // 'create users',
            // // manage roles
            // 'view roles',
            // 'edit roles',
            // 'create roles',

            // //manage ratings
            // 'view ratings',
            // 'edit ratings',

            // settings
            'view settings',
            'edit settings',
            'view offers.drafted',
            'restore offers.drafted',
            'delete offers.drafted',
            'draft offers.pending',

            // manage partners
            // 'view partners',
            // 'create partners',
            // 'edit partners',
            // 'view partnersDiscounts',
            // 'create partnersDiscounts',
            // 'edit partnersDiscounts',


            // // manage resources
            // 'view resources',
            // 'create resources',
            // 'edit resources',


        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'admin',
            ]);
        }
    }
}
