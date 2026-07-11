<?php

namespace App\Services\Customer;

use App\Repositories\Customer\InspectionRepository;
use App\Repositories\Customer\PaymentRepositry;

class InspectionService
{
    protected $inspectionRepo;

    public function __construct(InspectionRepository $inspectionRepo)
    {
        $this->inspectionRepo = $inspectionRepo;
    }

    public function createStageInspection(array $data)
    {
        $data['type'] = "item_inspection";
        return $this->inspectionRepo->store($data);
    }

      public function createFirstInspection(array $data)
    {
        $data['type'] = "item_inspection";
        return $this->inspectionRepo->store($data);
    }
   

    public function update(array $data){
        $id = $data['id'];

        unset($data['id']);
        $this->inspectionRepo->update($data , $id);
    }
}
