<?php
namespace App\Observers;

use App\Enums\ProjectStatus;
use App\Models\Admin;
use App\Models\Project;
use App\Utils\NotificationUtility;

class ProjectObserver
{
    public function updated(Project $project)
    {
        if ($project->isDirty('status')) {

            switch ($project->status) {
                case 'pending':
                    NotificationUtility::sendToAdminWIthPermission(['view projects.pending' , 'edit projects.pending'] , 'admin_project_pending', route('admin.projects.pending.edit' , $project->id), ['project' => ($project->serviceType?->name . ' ' . $project->buildingType?->name) ?? 'مشروع']);
                    NotificationUtility::sendToCustomer(
                        $project->customer,
                        'admin_project_pending',
                        route('customer.project.show', $project->id),
                        ['project' => ($project->serviceType?->name . ' ' . $project->buildingType?->name) ?? 'مشروع']
                    );
                    
                    
                    break;
                case 'accepted':
                    NotificationUtility::sendToCustomer(
                        $project->customer,
                        'admin_project_approved',
                        route('customer.project.show', $project->id),
                        ['project' => ($project->serviceType?->name . ' ' . $project->buildingType?->name) ?? 'مشروع']
                    );
                    break;

                case 'rejected':
                    NotificationUtility::sendToCustomer(
                        $project->customer,
                        'admin_project_rejected',
                        route('customer.project.show', $project->id),
                        ['project' => ($project->serviceType?->name . ' ' . $project->buildingType?->name) ?? 'مشروع']
                    );
                    break;

                case 'require_complete':
                    NotificationUtility::sendToCustomer(
                        $project->customer,
                        'admin_project_require_complete',
                        route('customer.project.show', $project->id),
                        ['project' => ($project->serviceType?->name . ' ' . $project->buildingType?->name) ?? 'مشروع']
                    );
                    break;

                case 'in_progress':
                    NotificationUtility::sendToCustomer(
                        $project->customer,
                        'admin_project_in_progress',
                        route('customer.project.show', $project->id),
                        ['project' => ($project->serviceType?->name . ' ' . $project->buildingType?->name) ?? 'مشروع']
                    );
                    break;

                case 'completed':
                    NotificationUtility::sendToCustomer(
                        $project->customer,
                        'admin_project_completed',
                        route('customer.project.show', $project->id),
                        ['project' => ($project->serviceType?->name . ' ' . $project->buildingType?->name) ?? 'مشروع']
                    );
                    break;

                case 'open_for_offers':
                    NotificationUtility::sendToCustomer(
                        $project->customer,
                        'admin_project_open_for_offers',
                        route('customer.project.show', $project->id),
                        ['project' => ($project->serviceType?->name . ' ' . $project->buildingType?->name) ?? 'مشروع']
                    );
                    break;

                case 'first_inspection_scheduled':
                    NotificationUtility::sendToCustomer(
                        $project->customer,
                        'admin_project_first_inspection_scheduled',
                        route('customer.project.show', $project->id),
                        ['project' => ($project->serviceType?->name . ' ' . $project->buildingType?->name) ?? 'مشروع']
                    );
                    $consultant  = $project->consultant;

                  NotificationUtility::sendToAdminWIthId($consultant->account_id , 'admin_project_first_inspection_scheduled' , route('admin.inspection.create.report' , $project->firstInspection()->id) , ['project' => ($project->serviceType?->name . ' ' . $project->buildingType?->name) ?? 'مشروع'] );
                    break;

                case 'first_inspection_completed':
                    NotificationUtility::sendToCustomer(
                        $project->customer,
                        'admin_project_first_inspection_completed',
                        route('customer.project.show', $project->id),
                        ['project' => ($project->serviceType?->name . ' ' . $project->buildingType?->name) ?? 'مشروع']
                    );
                       $consultant  = $project->consultant;

                  NotificationUtility::sendToAdminWIthPermission(['edit projects.pending'] , 'admin_project_first_inspection_completed' , route('admin.inspection.show.report' , $project->firstInspection()->id) , ['project' => ($project->serviceType?->name . ' ' . $project->buildingType?->name) ?? 'مشروع'] );
                 
                    break;

             
            }
        }
    }
    
    public function created(Project $project){
        if($project->status == ProjectStatus::PENDING->value){
      $admins = Admin::all();

    foreach ($admins as $admin) {
        // Assuming a method like this exists on Admin to check permissions
        if ($admin->canAny('view projects.pending')) {
            NotificationUtility::sentToAdmin(
                $admin,
                'new_project_created',
                route('admin.projects.pending.edit' , $project->id),
                [
                    'project' => ($project->serviceType?->name . ' ' . $project->buildingType?->name) ?? 'مشروع',
                ]
            );
        }
    }
}
    }
    
}
