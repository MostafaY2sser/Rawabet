<?php
namespace App\Repositories\Admin;

use App\Enums\InspectionStatus;
use App\Enums\ProjectStatus;
use App\Models\Inspection;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class InspectionRepository
{
    // Add methods related to inspection data handling here

    public function assignInspector($data)
    {
        $project = Project::find($data['project_id']);
        if (!$project) {
            throw new \Exception('Project not found');
        }
        if ($project->status != ProjectStatus::PENDING->value) {
            throw new \Exception('Cannot assign inspector to a project that is not pending');
        }

        $inspection = DB::transaction(function () use ($project, $data) {
            $inspectionOb =  $project->inspections()->create([
                'type' => 'first_inspection',
                'date' => $data['date'],
                'time' => $data['time'],
                'status' => 'pending',
            ]);

            $project->consultant_id = $data['inspector_id'];
            $project->status = ProjectStatus::FIRST_INSPECTION_SCHEDULED->value;
            $project->save();

            return $inspectionOb;

         
        });

        return $inspection;
    }

    public function getAllInspections($filters = [])
    {
        $query = Inspection::with(['project.serviceType', 'project.buildingType', 'project.customer', 'inspector']);
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($q) use ($search) {
                $q
                    ->where('id', 'like', "%{$search}%")
                    ->orWhereHas('project.serviceType', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('project.buildingType', fn($q3) => $q3->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('project.customer', fn($q4) => $q4->where('full_name', 'like', "%{$search}%"));
            });
        }

        return $query->get();
    }
    public function getAllInspectionsQuery($filters = [])
    {
        
        $query = Inspection::with(['project.serviceType', 'project.buildingType', 'project.customer', 'inspector'])->orderBy('id', 'desc');
       

        return $query;
    }
    public function getAllInspectionsQueryByConsultant($id,$filters = [])
    {
        $query = Inspection::with(['project.serviceType', 'project.buildingType', 'project.customer', 'inspector'])->whereHas('project', function ($q) use ($id) {
    $q->where('consultant_id', $id);
})->orderBy('id', 'desc');
       

        return $query;
    }

    public function getInspectionById($id)
    {
        return Inspection::with(['project', 'inspector'])
            ->findOrFail($id);
    }

    public function update($data)
    {
        $inspection = $this->getInspectionById($data['inspection_id']);

        $inspection = DB::transaction(function () use ($inspection, $data) {
            $inspection->update([
                'date' => $data['date'],
                'time' => $data['time'],
                'reschedule_request' => 0
            ]);

            $inspection->project->consultant_id = $data['consultant_id'];
            $inspection->project->save();

            return $inspection;
        });

        return $inspection;
    }

    public function createReport($data)
    {
        $inspection = $this->getInspectionById($data['inspection_id']);
        if ($inspection->status == 'completed') {
            throw new \Exception('Report already exists for this inspection');
        }

        $report = DB::transaction(function () use ($inspection, $data) {
            $report = $inspection->report()->create([
                'result_summary' => $data['summary'],
                'rate' => $data['evaluation'],
                'features' => json_encode($data['properties']),
                'details' => json_encode($data['points']),
                'recommendations' => json_encode($data['recommendations']),
            ]);

            if (isset($data['images'])) {
                foreach ($data['images'] as $attachment) {
                    $path = $attachment->store('inspection_reports', 'public');

                    $report->attachments()->create([
                        'file_path' => $path,
                        'title' => $attachment->getClientOriginalName(),
                        'description' => $attachment->getClientOriginalName(),
                    ]);
                }
            }

            $inspection->status = InspectionStatus::COMPLETED->value;
            $inspection->save();

            $inspection->project->status = ProjectStatus::FIRST_INSPECTION_COMPLETED->value;
            $inspection->project->save();

            return $report;
        });

        return $report;
    }

    public function createStageReport($data)
    {
        $inspection = $this->getInspectionById($data['inspection_id']);
        if ($inspection->status == 'completed') {
            throw new \Exception('Report already exists for this inspection');
        }

        $report = DB::transaction(function () use ($inspection, $data) {
            // 1. Create the report
            $report = $inspection->report()->create([
                'result_summary' => $data['summary'],
                'rate' => $data['evaluation'],
                'features' => json_encode($data['properties']),
                'details' => json_encode($data['points']),
                'recommendations' => json_encode($data['recommendations']),
            ]);

            // 2. Handle attachments (file upload + DB record)
            if (isset($data['images'])) {
                foreach ($data['images'] as $attachment) {
                    $path = $attachment->store('inspection_reports', 'public');  // Uploads file

                    $report->attachments()->create([
                        'file_path' => $path,
                        'title' => $attachment->getClientOriginalName(),
                        'description' => $attachment->getClientOriginalName(),
                    ]);
                }
            }

            // 3. Update inspection status
            $inspection->status = InspectionStatus::COMPLETED->value;
            $inspection->save();

            return $report;
        });
    }
}
