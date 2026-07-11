<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->updateOrInsert(
            ['email' => 'sadmin@gmail.com'],
            [
                'full_name'  => 'superAdmin',
                'password'   => Hash::make('12345678'),
                'type'=>'super_admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}


