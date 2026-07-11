<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use App\Models\Project;
use App\Services\Customer\InspectionService;
use Illuminate\Http\Request;

class InspectionController extends Controller
{
    protected $inspectionService;

    public function __construct(InspectionService $inspectionService)
    {
        $this->inspectionService = $inspectionService;
    }

    public function update($id, Request $request)
    {
        $data = [
            'requested_date' => $request->new_date,
            'requested_time' => $request->time,
            'id' => $id,
            'reschedule_request'=>1
        ];
        $this->inspectionService->update($data);
        return redirect()->back()->with('success', 'Updated successfully');
    }

    public function show($id)
    {
        $inspection = Inspection::with('report')->findorfail($id);
        $view = $inspection->offer_item_id == null ? 'customer.project.inspection' : 'customer.project.stage-inspection';
        return view($view, compact('inspection'));
    }

    public function createStageInspection($project_id, Request $request)
    {
        $request->validate([
            'new_date' => 'required', 'time' => 'required'
        ]);
        $data = [
            'date' => $request->new_date,
            'time' => $request->time,
            'requested_date' => $request->new_date,
            'requested_time' => $request->time,
            'project_id' => $project_id,
            'offer_item_id' => $request->stage_id
        ];

        $this->inspectionService->createStageInspection($data);
        return redirect()->back()->with('success', 'created successfully');
    }
}
