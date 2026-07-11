<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // $specialities = [
        //     ['name' => 'بناء جديد'],
        //     ['name' => 'ترميم'],
        //     ['name' => 'تشطيب'],
        //     ['name' => 'ديكور'],
        //     ['name' => 'كهرباء'],
        //     ['name' => 'أخرى'],
        // ];
        // $projectTypes = [
        //     ['id'=>1, "name"=>'مشاريع سكنية' ,  "description"=>"فلل، شقق، ومجمعات سكنية"],
        //     ['id'=>2, "name"=>'مشاريع تجارية' ,  "description"=>"مولات، مكاتب، ومحلات تجارية"],
        //     ['id'=>3 , "name"=>"مشاريع صناعية" , "description"=>"مصانع، مستودعات، ومنشآت صناعية"]
            
        // ];

        $buidlingTypes =[
            ['id'=>1 , "name"=>"مبنى قائم"],
            ['id'=>2 , "name"=>"أرض فضاء"],
            ['id'=>3 , "name"=>"فيلا"],
            ['id'=>4 , "name"=>"شقة"],

        ];

        // $categories = [
        //     [ 'id'=>1,'name'=>'البناء والتشييد'],
        //     [ 'id'=>2,'name'=>'البناء s'],

        // ];

        // $durations = [
        //     ["id"=>1 , "name"=>"سنه"],
        //     ["id"=>2 , "name"=>"سنتين"],
        //     ["id"=>3 , "name"=>"٣ سنوات"],
        // ];

        // $admins =[
        //     "full_name"=>"superAdmin",
        //     "email"=>'sadmin@gmail.com',
        //     "password"=>bcrypt("12345678")
        // ]
        ;

        // \DB::table('admins')->insert($admins);
      
        // \DB::table('specialities')->insert($specialities);
        \DB::table('building_types')->insert($buidlingTypes);
        // \DB::table('project_types')->insert($projectTypes);
        // \DB::table('time_line_durations')->insert($durations);
        // \DB::table('project_categories')->insert($categories);

        //   \DB::table('consultants')->insert([
        //     [
        //         'fullname' => 'د. أحمد الزهراني',
        //         'avatar' => 'https://i.pravatar.cc/150?img=1',
        //         'specialty_id' => 1,
        //         'identity_number' => '1001001001',
        //         'experience_years' => 10,
        //         'certificates' => 'دكتوراه في الطب العام من جامعة الملك سعود',
        //         'email' => 'ahmedz@example.com',
        //         'phone_number' => '0550000001',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'fullname' => 'د. فاطمة الخالد',
        //         'avatar' => 'https://i.pravatar.cc/150?img=2',
        //         'specialty_id' => 2,
        //         'identity_number' => '1001001002',
        //         'experience_years' => 8,
        //         'certificates' => 'ماجستير في علم النفس الإكلينيكي من جامعة الدمام',
        //         'email' => 'fatma@example.com',
        //         'phone_number' => '0550000002',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'fullname' => 'د. سالم الحربي',
        //         'avatar' => 'https://i.pravatar.cc/150?img=3',
        //         'specialty_id' => 3,
        //         'identity_number' => '1001001003',
        //         'experience_years' => 12,
        //         'certificates' => 'شهادة البورد السعودي في الجراحة العامة',
        //         'email' => 'salem@example.com',
        //         'phone_number' => '0550000003',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'fullname' => 'د. نورة السبيعي',
        //         'avatar' => 'https://i.pravatar.cc/150?img=4',
        //         'specialty_id' => 1,
        //         'identity_number' => '1001001004',
        //         'experience_years' => 6,
        //         'certificates' => 'ماجستير في طب الأسرة',
        //         'email' => 'nora@example.com',
        //         'phone_number' => '0550000004',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'fullname' => 'د. عبدالله القحطاني',
        //         'avatar' => 'https://i.pravatar.cc/150?img=5',
        //         'specialty_id' => 2,
        //         'identity_number' => '1001001005',
        //         'experience_years' => 15,
        //         'certificates' => 'زمالة الطب النفسي من ألمانيا',
        //         'email' => 'abdullah@example.com',
        //         'phone_number' => '0550000005',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        // ]);




    }
}
