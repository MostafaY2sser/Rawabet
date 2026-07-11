<?php
namespace App\Services\Admin;

use App\Repositories\Admin\InspectionRepository;

class InspectionService
{
    protected $inspectionRepository;

    public function __construct(InspectionRepository $inspectionRepository)
    {
        $this->inspectionRepository = $inspectionRepository;
    }

    public function assignInspector($data)
    {
        return $this->inspectionRepository->assignInspector($data);
    }   

    public function getAllInspections($filters = [])
    {
        return $this->inspectionRepository->getAllInspections($filters);
    }
    public function getAllInspectionsQuery($filters = [])
    {
        return $this->inspectionRepository->getAllInspectionsQuery($filters);
    }
    public function getAllInspectionsQueryByConsultant($id,$filters = [])
    {
        return $this->inspectionRepository->getAllInspectionsQueryByConsultant($id,$filters);
    }
    public function getInspectionById($id)
    {
        return $this->inspectionRepository->getInspectionById($id);
    }
    public function update($data)
    {
      return $this->inspectionRepository->update($data);
      
    }
    public function createReport($data)
    {
        return $this->inspectionRepository->createReport($data);
    }
       public function createStageReport($data)
    {
        return $this->inspectionRepository->createStageReport($data);
    }

    // Add methods for inspection-related business logic here
}