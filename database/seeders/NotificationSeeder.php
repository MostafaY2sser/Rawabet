<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('notifications')->insert([
            [
                'title' => 'تم قبول عرضك',
                'description' => 'تم قبول عرض السعر الخاص بك لمشروع المجمع السكني الفاخر.',
                'url' => '/provider/offers/show/1',
                'seen' => false,
                'reserver_type' => 'App\Models\Provider',
                'reserver_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
          
            [
                'title' => 'مشروع جديد متاح',
                'description' => 'يوجد مشروع جديد يناسب تخصصك في منطقة الرياض.',
                'url' => '/provider/projects/show/2',
                'seen' => true,
                'reserve_type' => 'App\Models\Provider',
                'reserver_id' => 1,
                'created_at' => now()->subHours(5),
                'updated_at' => now(),
            ],
            // البيانات الثالثة
            [
                'title' => 'مطلوب تحديث المستندات',
                'description' => 'يرجى تحديث شهادة الزكاة والدخل الخاصة بك قبل انتهاء صلاحيتها.',
                'url' => '/provider/profile/documents',
                'seen' => false,
                'reserve_type' => 'App\Models\Provider',
                'reserve_id' => 1,
                'created_at' => now()->subDays(2),
                'updated_at' => now(),
            ],
        ]);
    }
}
