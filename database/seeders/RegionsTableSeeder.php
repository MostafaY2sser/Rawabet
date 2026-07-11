<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            ['name' => 'الرياض'],
            ['name' => 'جدة'],
            ['name' => 'مكة المكرمة'],
            ['name' => 'المدينة المنورة'],
            ['name' => 'الدمام'],
            ['name' => 'الطائف'],
            ['name' => 'تبوك'],
            ['name' => 'أبها'],
            ['name' => 'حائل'],
            ['name' => 'الخبر'],
            ['name' => 'القصيم'],
            ['name' => 'الجبيل'],
            ['name' => 'القطيف'],
            ['name' => 'خميس مشيط'],
            ['name' => 'الخرج'],
            ['name' => 'عرعر'],
            ['name' => 'سكاكا'],
            ['name' => 'بيشة'],
            ['name' => 'نجران'],
            ['name' => 'الباحة'],
            ['name' => 'جازان'],
            ['name' => 'ينبع'],
            ['name' => 'الخبر'],
            ['name' => 'القصيم']
        ];

        DB::table('regions')->insert($regions);
    }
}
