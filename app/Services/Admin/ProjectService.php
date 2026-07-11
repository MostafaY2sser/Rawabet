<?php
namespace App\Services\Admin;

use App\Enums\ProjectStatus;
use App\Repositories\Admin\ProjectRepository;

class ProjectService
{
    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getPendingProjects()
    {
        return $this->projectRepository->getPendingProjects();
    }
    public function getPendingProjectsQuery()
    {
        return $this->projectRepository->getPendingProjectsQuery();
    }

    public function getActiveProjects($filters =[])
    {
        return $this->projectRepository->getActiveProjects($filters);
    }
    public function getActiveProjectsQuery($filters =[])
    {
        return $this->projectRepository->getActiveProjectsQuery($filters);
    }

    public function getCompletedProjects()
    {
        return $this->projectRepository->getCompletedProjects();
    }
    public function getCompletedProjectsQuery()
    {
        return $this->projectRepository->getCompletedProjectsQuery();
    }

    public function getCanceledProjects()
    {
        return $this->projectRepository->getCanceledProjects();
    }

    public function getProjectById($id)
    {
        return $this->projectRepository->find($id);
    }

    public function updateProjectStatus($id, $status)
    {
        $project = $this->projectRepository->find($id);
        if ($project) {
            $project->status = $status;

            if ($status == ProjectStatus::OPEN_FOR_OFFERS->value)
                $project->open_for_offers_date = now();

            $project->save();
            return $project;
        }

        return null;
    }
}
