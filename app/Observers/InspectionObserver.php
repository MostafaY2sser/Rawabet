<?php

namespace App\Observers;

use App\Models\Inspection;
use App\Utils\NotificationUtility;
use Carbon\Carbon;

class InspectionObserver
{
    /**
     * Handle the Inspection "updated" event.
     */
    public function updated(Inspection $inspection)
    {
        $customer = $inspection->project->customer;
        $projectId = $inspection->project->id;
        $consultant = $inspection->project->consultant->fullname;

        if ($inspection->isDirty('status')) {
            $status = $inspection->status;

            switch ($status) {
                case 'pending':
                    NotificationUtility::sendToCustomer(
                        $inspection->project->customer,
                        'inspection_pending',
                        route('customer.project.show', $inspection->project->id),
                        ['consultant' => $inspection->project->consultant->fullname]
                    );
                    break;

                case 'completed':
                    if ($inspection->type == 'item_inspection') {
                        NotificationUtility::sendToAdminWIthPermission(
                            ['update projects.workstages', 'view projects.workstages'],
                            'stage_inspection_completed',
                            route('admin.projects.active.workstages', $inspection->project->id),
                            [
                                'project' => ($inspection->project->serviceType?->name . ' ' . $inspection->project->buildingType?->name) ?? 'مشروع',
                                'stage' => $inspection->stage->title,
                            ]
                        );

                        NotificationUtility::sendToCustomer(
                            $inspection->project->customer,
                            'stage_inspection_completed',
                            route('customer.project.implementation.index', $inspection->project->id),
                            [
                                'project' => ($inspection->project->serviceType?->name . ' ' . $inspection->project->buildingType?->name) ?? 'مشروع',
                                'stage' => $inspection->stage->title,
                            ]
                        );
                    } else {
                        NotificationUtility::sendToCustomer(
                            $inspection->project->customer,
                            'inspection_completed',
                            route('customer.project.show', $inspection->project->id),
                            ['consultant' => $inspection->project->consultant->fullname]
                        );
                    }
                    break;

                case 'canceled':
                    NotificationUtility::sendToCustomer(
                        $inspection->project->customer,
                        'inspection_canceled',
                        route('customer.project.show', $inspection->project->id),
                        ['consultant' => $inspection->project->consultant->fullname]
                    );
                    break;
            }
        }
        if ($inspection->isDirty('date') || $inspection->isDirty('time')) {
            $date = $inspection->date;
            $time = Carbon::parse($inspection->time)->format('h:i A');
            $replacements = [
                'consultant' => $consultant,
                'day' => $date,
                'time' => $time
            ];

            NotificationUtility::sendToCustomer(
                $customer,
                'inspection_rescheduled',
                route('customer.project.show', $projectId),
                $replacements
            );
        }
    }

    public function created(Inspection $inspection)
    {
        $consultant = $inspection->project->consultant;

        if ($inspection->type == 'item_inspection') {
            NotificationUtility::sendToAdminWIthId(
                $consultant->account_id,
                'customer_request_stage_inspection',
                route('admin.projects.active.workstages', $inspection->project_id),
                [
                    'stage' => $inspection->stage->title,
                    'project' => ($inspection->project->serviceType?->name . ' ' . $inspection->project->buildingType?->name) ?? 'مشروع',
                ]
            );
        }
    }
}
