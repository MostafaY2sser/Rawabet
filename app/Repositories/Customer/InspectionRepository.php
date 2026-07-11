<?php

namespace App\Repositories\Customer;

use App\Enums\ProjectStatus;
use App\Models\Inspection;
use App\Models\InspectionReport;
use App\Models\Project;
use App\Models\ProjectAttachment;
use App\Utils\ProjectUtility;

class InspectionRepository
{
    public function store(array $data)
    {
        $inspection = Inspection::create($data);  // Only basic fields at step one
        // $recommendations = [
        //     'يُنصح بالبدء في المشروع في أقرب وقت ممكن',
        //     'الاستفادة من الموقع الاستراتيجي في التصميم',
        //     'إضافة مواقف سيارات كافية نظراً لطبيعة المنطقة التجارية'
        // ];

        // $details = [
        //     'صك الملكية صحيح ومطابق للواقع',
        //     'الموقع استراتيجي ومناسب للأنشطة التجارية',
        //     'لا توجد عوائق قانونية أو بيئية',
        //     'المرافق العامة متوفرة بالكامل (كهرباء، مياه، صرف صحي)'
        // ];

        // InspectionReport::create([
        //     'rate' => rand(0, 10),
        //     'result_summary' => 'الموقع ممتاز ومناسب تماماً للمشروع التجاري المطلوب مع توفر جميع المتطلبات',
        //     'recommendations' => json_encode($recommendations),
        //     'details' => json_encode($details),
        //     'features' => '',
        //     'inspection_id' => $inspection->id
        // ]);
        return $inspection;
    }

    public function update(array $data, $id)
    {
        $inspection = Inspection::find($id);

        $inspection->update($data);

        return $inspection;
    }
}
