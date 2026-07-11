<?php

namespace App\Services\Customer;

use App\Enums\ProjectStatus;
use App\Repositories\Customer\ProjectRepository;

class PerojectService
{
    protected $projectRepo;

    public function __construct(ProjectRepository $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    public function createStepOne(array $data)
    {
        $data['step'] = 2;

        $data['customer_id'] = auth('customer')->user()->id;
        return $this->projectRepo->createStepOne($data);
    }

    public function updateStepOne(array $data)
    {
        $projectId = $data['project_id'];
        unset($data['project_id']);
        

        return $this->projectRepo->updateStepOne($projectId, $data);
    }

    public function updateSteptwo(array $data , $edit = null)
    {
        $projectId = $data['project_id'];
        unset($data['project_id']);
        if($edit != 1)
        $data['step'] = 3;

        return $this->projectRepo->updateStepTwo($projectId, $data);
    }

    public function updateStepthree(array $data , $edit = null)
    {
        $projectId = $data['project_id'];
        unset($data['project_id']);
        if($edit != 1)
        $data['step'] = 4;

        return $this->projectRepo->updateStepThree($projectId, $data);
    }

    public function updateStepFour(array $data , $edit = null)
    {
        $projectId = $data['project_id'];
        unset($data['project_id']);
        if($edit != 1)
        $data['step'] = 5;

        return $this->projectRepo->updateStepFour($projectId, $data);
    }

    public function updateStepFife(array $data , $edit = null)
    {
        $projectId = $data['project_id'];
        unset($data['project_id']);

        if($edit != 1)
        $data['step'] = 6;
        $data['status'] = 'pending';

        return $this->projectRepo->updateStepFife($projectId, $data);
    }

    public function update(array $data)
    {
        return $this->projectRepo->update($data);
    }

    public function createProjectAttahcmet($data){
        $this->projectRepo->createProjectAttahcmet($data);

    }
}
