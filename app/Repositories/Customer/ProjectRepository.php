<?php

namespace App\Repositories\Customer;

use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\ProjectAttachment;
use App\Utils\ProjectUtility;

class ProjectRepository
{
    public function createStepOne(array $data)
    {
        return Project::create($data);  // Only basic fields at step one
    }

    public function updateStepOne($projectId, $data)
    {
        $project = Project::find($projectId);
        if ($project->status != ProjectStatus::REQUIRE_COMPLETE->value)
            unset($data['step']);
        $project->update($data);
        return $project;
    }

    public function updateStepTwo($projectId, $data)
    {
        $project = Project::find($projectId);
        if ($project->status != ProjectStatus::REQUIRE_COMPLETE->value)
            unset($data['step']);
        $project->update($data);
        return $project;
    }

    public function updateStepThree($projectId, $data)
    {
        $project = Project::find($projectId);
        if ($project->status != ProjectStatus::REQUIRE_COMPLETE->value)
            unset($data['step']);

        $project->update($data);
        return $project;
    }

    public function createProjectAttahcmet($data)
    {
        ProjectAttachment::create([
            'project_id' => $data['project_id'],
            'file_path' => $data['file_path'],
            'file_name' => $data['file_name'],
        ]);
    }

    public function updateStepFour($projectId, $data)
    {
        $project = Project::findOrFail($projectId);

        if ($project->status != ProjectStatus::REQUIRE_COMPLETE->value) {
            unset($data['step']);
        }

        $project->update($data);

        unset($data['status'], $data['step']);

        // foreach ($data as $key => $file) {
        //     if (is_array($file)) {
        //         foreach ($file as $item) {

        //         }
        //     } else {
        //         ProjectAttachment::create([
        //             'project_id' => $project->id,
        //             'file_path' => $file,
        //             'file_name' => $key,
        //         ]);
        //     }
        // }

        return $project;
    }

    public function updateStepFife($projectId, $data)
    {
        $project = Project::find($projectId);

        if ($project->status != ProjectStatus::PENDING->value)
            unset($data['step']);

        $project->update($data);

        if (!$project->firstInspection()) {
            // ProjectUtility::generateAutoInspection($project);
        }
        return $project;
    }

    public function update($data)
    {
        $project = Project::find($data['project_id']);
        unset($data['project_id']);

        $project->update($data);
        return $project;
    }
}
