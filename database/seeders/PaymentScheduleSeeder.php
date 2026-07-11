<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schedules = [
            ['title' => 'العربون', 'percentage' => 20],
            ['title' => 'بداية الأعمال', 'percentage' => 25],
            ['title' => 'إنجاز الهيكل', 'percentage' => 20],
            ['title' => 'التشطيبات', 'percentage' => 15],
            ['title' => 'التسليم النهائي', 'percentage' => 20],
        ];

        foreach ($schedules as $schedule) {
            DB::table('payment_schedules')->insert([
                'title'      => $schedule['title'],
                'percentage'=> $schedule['percentage'],
                'amount'     => 0, // You can adjust this as needed
                'offer_id'   => null, // Link to a real offer if needed
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
