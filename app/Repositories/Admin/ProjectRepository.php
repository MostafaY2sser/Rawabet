<?php
namespace App\Repositories\Admin;

use App\Enums\ProjectStatus;
use App\Models\Project;

class ProjectRepository
{
    public function getPendingProjects()
    {
        // Logic to retrieve pending projects from the database

        $statuses = [ProjectStatus::REQUIRE_COMPLETE , ProjectStatus::PENDING , ProjectStatus::FIRST_INSPECTION_SCHEDULED , ProjectStatus::FIRST_INSPECTION_COMPLETED];

        return Project::whereIn('status', array_map(fn($status) => $status->value, $statuses))->get();
    }
    public function getPendingProjectsQuery()
    {
        // Logic to retrieve pending projects from the database

        $statuses = [ProjectStatus::REQUIRE_COMPLETE , ProjectStatus::PENDING , ProjectStatus::FIRST_INSPECTION_SCHEDULED , ProjectStatus::FIRST_INSPECTION_COMPLETED];

        return Project::with(['customer', 'projectType', 'category', 'region'])->whereIn('status', array_map(fn($status) => $status->value, $statuses));
    }

    public function getActiveProjects($filters = [])
    {
        // Logic to retrieve active projects from the database

        $statuses = [ProjectStatus::OPEN_FOR_OFFERS , ProjectStatus::IN_PROGRESS];

       $query =  Project::whereIn('status', array_map(fn($status) => $status->value, $statuses));
       if(isset($filters['consultant_id']))
         $query = $query->where('consultant_id' , $filters['consultant_id'] );

        return $query->get();
    }

    public function getActiveProjectsQuery($filters = [])
    {
        // Logic to retrieve active projects from the database

        $statuses = [ProjectStatus::OPEN_FOR_OFFERS , ProjectStatus::IN_PROGRESS];

       $query =  Project::whereIn('status', array_map(fn($status) => $status->value, $statuses));
      
        return $query;
    }

    public function getCompletedProjects()
    {
        // Logic to retrieve completed projects from the database

        $statuses = [ProjectStatus::COMPLETED];

        return Project::whereIn('status', array_map(fn($status) => $status->value, $statuses))->get();
    }
    public function getCompletedProjectsQuery()
    {
        // Logic to retrieve completed projects from the database

        $statuses = [ProjectStatus::COMPLETED];

        return Project::whereIn('status', array_map(fn($status) => $status->value, $statuses));
    }

    public function getCanceledProjects()
    {
        // Logic to retrieve canceled projects from the database

        $statuses = [ProjectStatus::CANCELLED];

        return Project::whereIn('status', array_map(fn($status) => $status->value, $statuses))->get();
    }

    public function find($id)
    {
        return Project::find($id);
    }
}