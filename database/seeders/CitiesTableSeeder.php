<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
    ['name' => 'النسيم', 'region_id' => 1],
        ['name' => 'الروضة', 'region_id' => 1],
        ['name' => 'الصفا', 'region_id' => 2],
        ['name' => 'الفيصلية', 'region_id' => 2],
        ['name' => 'العزيزية', 'region_id' => 3],
        ['name' => 'النزهة', 'region_id' => 3],
        ['name' => 'العنبرية', 'region_id' => 4],
        ['name' => 'قباء', 'region_id' => 4],
        ['name' => 'الشاطئ', 'region_id' => 5],
        ['name' => 'الخليج', 'region_id' => 5],
        ['name' => 'الزهور', 'region_id' => 6],
        ['name' => 'الفيحاء', 'region_id' => 6],
        ['name' => 'الروابي', 'region_id' => 7],
        ['name' => 'المروج', 'region_id' => 7],
        ['name' => 'الواحة', 'region_id' => 8],
        ['name' => 'المنسك', 'region_id' => 8],
       
];
        DB::table('cities')->insert($cities);



    }
}
