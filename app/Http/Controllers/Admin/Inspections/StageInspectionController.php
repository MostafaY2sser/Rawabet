<?php

namespace App\Http\Controllers\Admin\Inspections;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StageInspectionController extends Controller
{

      protected $inspectionService;
    public function __construct(\App\Services\Admin\InspectionService $inspectionService)
    {
        $this->inspectionService = $inspectionService;
    }
    //
    public function create($id){
        if(!Auth::user('admin')->can('create inspections.reports'))
        abort(403);
        $inspection = Inspection::find($id);
        return view('admin.inspections.create-stage-report' , compact('inspection'));
    }

     public function StoreReport($id, Request $request){

          if(!Auth::user('admin')->can('create inspections.reports'))
        abort(403);


        $data = $request->validate([
            'summary' => 'required|string',
            'evaluation' => 'required|numeric|min:0|max:10',
            "images"=>'nullable|array',
            "images.*"=>'file|mimes:jpg,jpeg,png,pdf'
        ]);

        $inspection = $this->inspectionService->getInspectionById($id);
        $data['inspection_id'] = $id;

        $data['properties'] = [];
        $data['points'] = [];
        $data['recommendations'] = [];
        $this->inspectionService->createStageReport($data);

        return redirect()->route('admin.projects.active.workstages' , $inspection->stage->offer->project_id)->with('success', 'تم إنشاء التقرير بنجاح.');
    }


     public function showReport($id){
          if(!Auth::user('admin')->can('view inspections.reports'))
        abort(403);

        $inspection = $this->inspectionService->getInspectionById($id);
        return view('admin.inspections.show-stage-report', compact('inspection'));
    }
}
