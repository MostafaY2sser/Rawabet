<?php
namespace App\Utils;

use App\Enums\ProjectStatus;
use App\Models\Consultant;
use App\Models\InspectionReport;
use App\Models\Project;

class ProjectUtility
{
    const STATUS_PENDING = 'pending';

    public function getProjectTrackStatus()
    {
        $steps = [
            // ProjectStatus::REQUIRE_COMPLETE->value => [
            //     'title' => 'يحتاج الى استكمال',
            //     'description' => 'المشروع يحتاج الى مزيد من المعلومات',
            //     'icon' => 'fa fa-info-circle',
            //     'url'=>"#",
            //     'key'=>'require_complete'
            // ],
            ProjectStatus::PENDING->value => [
                'title' => 'قيد المراجعة',
                'description' => 'جاري مراجعة تفاصيل المشروع والمستندات',
                'icon' => 'fa fa-eye',
                'url'=>"#",
                'key'=>'pending'
            ],
        
            ProjectStatus::ACCEPTED->value => [
                'title' => 'تمت الموافقة و تعيين استشاري',
                'description' => 'تم قبول الطلب وتعيين استشاري للمعاينة',
                'icon' => 'fa fa-check',
                'url'=>"#",
                'key'=>'accepted_inspection'
            ],
            ProjectStatus::FIRST_INSPECTION_SCHEDULED->value => [
                'title' => 'تم جدولة المعاينة',
                'description' => 'تم تحديد موعد المعاينة',
                'icon' => 'fa fa-user',
                'url'=>"#",
                'key'=>'first_inspection_scheduled'

            ],
            ProjectStatus::FIRST_INSPECTION_COMPLETED->value => [
                'title' => 'تمت المعاينة',
                'description' => 'تمت المعاينة من قبل الاستشاري',
                'icon' => 'fa fa-calendar-check',
                'url'=>"#",
                'key'=>'first_inspection_completed'

            ],
              ProjectStatus::OPEN_FOR_OFFERS->value => [
                'title' => 'متاح للعروض',
                'description' => 'متاح للعروض',
                'icon' => 'fa fa-calendar-check',
                'key'=>'open_for_offers'
            ],
       
            ProjectStatus::IN_PROGRESS->value => [
                'title' => 'قيد التنفيذ',
                'description' => 'قيد التنفيذ',
                'icon' => 'fa fa-calendar-check',
                'key'=>'in_progress'
            ],
        ];
        return $steps;
    }


    

    // this is for demo case only till we have admin panel to handle this
   static function generateAutoInspection(Project $project)
{
    // Step 1: Get any consultant (random one)
    $consultant = Consultant::whereBetween('id', [1, 5])
        ->inRandomOrder()
        ->first();

    if (!$consultant) {
        // You may want to handle this better in real code
        throw new \Exception("No consultants available");
    }

    // Step 2: Create inspection
   $inspection =  $project->inspections()->create([
        'type' => 'first_inspection',
        'date' => now()->addDays(2)->toDateString(), // aftertomorrow
        'time' => '10:00:00',
        'status' => 'pending', // if you have status field
    ]);

    $recommendations = [
        "يُنصح بالبدء في المشروع في أقرب وقت ممكن",
        "الاستفادة من الموقع الاستراتيجي في التصميم",
        "إضافة مواقف سيارات كافية نظراً لطبيعة المنطقة التجارية"
    ];

    $details = [
        "صك الملكية صحيح ومطابق للواقع",
        "الموقع استراتيجي ومناسب للأنشطة التجارية",
        "لا توجد عوائق قانونية أو بيئية",
        "المرافق العامة متوفرة بالكامل (كهرباء، مياه، صرف صحي)"
    ];

    InspectionReport::create([
        "rate"=>rand(0,10),
        "result_summary"=>"الموقع ممتاز ومناسب تماماً للمشروع التجاري المطلوب مع توفر جميع المتطلبات",
        "recommendations"=>json_encode($recommendations),
        "details"=>json_encode($details),
        "features"=>"",
        "inspection_id"=>$inspection->id
    ]);

    // Step 3: Update project status
    $project->status = ProjectStatus::FIRST_INSPECTION_SCHEDULED;
    $project->consultant_id = $consultant->id;

    $project->save();
}


}
