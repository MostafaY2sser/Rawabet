<?php

namespace App\Observers;

use App\Models\ProjectReport;
use App\Utils\NotificationUtility;

class ProjectReportObserver
{
    public function created(ProjectReport $report)
    {
        $project = $report->project;
        $customerUrl = route('customer.project.implementation.index', $project->id);

        NotificationUtility::sendToCustomer(
            $project->customer,
            'project_report_added',
            $customerUrl,
            ['project' => ($project->serviceType?->name . ' ' . $project->buildingType?->name) ?? 'مشروع']
        );
    }
}
